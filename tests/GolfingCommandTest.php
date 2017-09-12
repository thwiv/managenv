<?php

class GolfingCommandTest extends TestCase {
	use \Illuminate\Foundation\Testing\DatabaseTransactions;

	public function testCreateEnv()
	{
		$parent_name = factory(App\Environment::class, 'parent')->create()->name;
		\Illuminate\Support\Facades\Artisan::call('env:create', [
			'name' => 'on_to_something_new',
			'--parent' => $parent_name
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertContains('Environment', $result);
	}

	public function testCreateEnvNoParent()
	{
		\Illuminate\Support\Facades\Artisan::call('env:create', [
			'name' => 'on_to_something_new',
			'--parent' => 'i_dont_exist'
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("Parent Does Not Exist\n", $result);
	}

	public function testCreateEnvDuplicate()
	{
		$name = factory(App\Environment::class, 'parent')->create()->name;
		\Illuminate\Support\Facades\Artisan::call('env:create', [
			'name' => $name
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("Environment Already Exists\n", $result);
	}

	public function testExportEnv()
	{
		$name = factory(App\Environment::class, 'parent')->create()->name;
		$location = '.\test-output';
		\Illuminate\Support\Facades\Artisan::call('env:export', [
			'name' => $name,
			'location' => $location
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("", $result);
	}

	public function testGetVar()
	{
		$var = factory(App\Variable::class, 'parentVar')->create();
		$childEnv = factory(App\Environment::class, 'child')->create(['parent_id' => $var->environment_id]);
		\Illuminate\Support\Facades\Artisan::call('env:get', [
			'environment' => $childEnv->name,
			'variable' => $var->name
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals($var->value."\n", $result);
	}

	public function testGetVarNoEnv()
	{
		\Illuminate\Support\Facades\Artisan::call('env:get', [
			'environment' => 'not_there',
			'variable' => 'me_either'
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("Environment Not Found\n", $result);
	}

	public function testGetVarNoVar()
	{
		$env = factory(App\Environment::class, 'parent')->create();
		\Illuminate\Support\Facades\Artisan::call('env:get', [
			'environment' => $env->name,
			'variable' => 'not_there'
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("Variable Not Found\n", $result);
	}

	public function testSetVar()
	{
		$env = factory(App\Environment::class, 'parent')->create();
		$val = 'newVal';
		\Illuminate\Support\Facades\Artisan::call('env:set', [
			'environment' => $env->name,
			'variable' => 'brandNew',
			'value' => $val
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("Variable Saved\n", $result);
	}

	public function testSetVarNoEnv()
	{
		$val = 'newVal';
		\Illuminate\Support\Facades\Artisan::call('env:set', [
			'environment' => 'env_dont_exist',
			'variable' => 'brandNew',
			'value' => $val
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("Environment Not Found\n", $result);
	}

	public function testImportEnv()
	{
		\Illuminate\Support\Facades\Storage::shouldReceive('exists')->andReturn(true);
		$envFileInfo = "VAR_1=12345\nVAR_2=45678\n\nVAR_3";
		\Illuminate\Support\Facades\Storage::shouldReceive('get')->andReturn($envFileInfo);
		$env = factory(App\Environment::class, 'parent')->create();

		\Illuminate\Support\Facades\Artisan::call('env:import', [
			'location' => 'a_new_name.env',
			'--parent' => $env->name,
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("Could Not Read Variable: VAR_3\n", $result);
	}

	public function testImportEnvNoFile()
	{
		\Illuminate\Support\Facades\Storage::shouldReceive('exists')->andReturn(false);
		\Illuminate\Support\Facades\Artisan::call('env:import', [
			'location' => '.example',
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("The file does not exist\n", $result);
	}

	public function testImportEnvErrorFile()
	{
		\Illuminate\Support\Facades\Storage::shouldReceive('exists')->andThrow(\Illuminate\Contracts\Filesystem\FileNotFoundException::class);
		\Illuminate\Support\Facades\Artisan::call('env:import', [
			'location' => '.example',
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertContains("An Error Occured Importing The File: ", $result);
	}
	public function testImportEnvParentNotFound()
	{
		\Illuminate\Support\Facades\Storage::shouldReceive('exists')->andReturn(true);
		\Illuminate\Support\Facades\Storage::shouldReceive('get')->andReturn("no matter");
		\Illuminate\Support\Facades\Artisan::call('env:import', [
			'location' => '.example',
			'--parent' => 'not_found',
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("Parent Not Found\n", $result);
	}

	public function testImportEnvParentNotSame()
	{
		\Illuminate\Support\Facades\Storage::shouldReceive('exists')->andReturn(true);
		\Illuminate\Support\Facades\Storage::shouldReceive('get')->andReturn("no matter");
		$env = factory(App\Environment::class, 'parent')->create();
		$child = factory(App\Environment::class, 'child')->create();
		\Illuminate\Support\Facades\Artisan::call('env:import', [
			'location' => $child->name.'.env',
			'--parent' => $env->name,
		]);
		$result = \Illuminate\Support\Facades\Artisan::output();
		$this->assertEquals("Parent is not associated with the environment\n", $result);
	}
}
