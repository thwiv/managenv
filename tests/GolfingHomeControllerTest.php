<?php

class GolfingHomeControllerTest extends TestCase
{
	use \Illuminate\Foundation\Testing\DatabaseTransactions;
	use \Illuminate\Foundation\Testing\WithoutMiddleware;

	public function testIndex()
	{
		$this->call('GET', '/home');
		$this->assertViewHas('environments');
	}

	public function testAddEnvironment()
	{
		/** @var \Illuminate\Http\JsonResponse $response */
		$response = $this->call('POST', '/environment/', ['name' => 'home_controller_test_env']);
		$data = json_decode($response->content(), true);
		$this->assertTrue($data['success']);
	}

	public function testAddEnvironmentDuplicate()
	{
		$name = factory(App\Environment::class, 'parent')->create()->name;
		$response = $this->call('POST', '/environment/', ['name' => $name]);
		$data = json_decode($response->content(), true);
		$this->assertFalse($data['success']);
	}

	public function testGetEnvironment()
	{
		$id = factory(App\Environment::class, 'parent')->create()->id;
		$this->call('GET', '/environment/'.$id);
		$this->assertViewHas('env');
	}
	public function testGetEnvironmentError()
	{
		$id = -1;
		$this->call('GET', '/environment/'.$id);
		$this->assertResponseStatus(404);
	}

	public function testSetVariable()
	{
		$id = factory(App\Environment::class, 'parent')->create()->id;
		/** @var \Illuminate\Http\JsonResponse $response */
		$response = $this->call('POST', '/set-variable/'.$id, [
			'name' => 'something_random',
			'value' => '12345'
		]);
		$data = json_decode($response->content(), true);
		$this->assertTrue($data['success']);
	}

	public function testDeleteVariableError()
	{
		$response = $this->call('POST', '/delete-variable', ['id' => '-1', 'environment' => '-1']);
		$data = json_decode($response->content(), true);
		$this->assertFalse($data['success']);
	}

	public function testDeleteVariableNoParent()
	{
		$var = factory(App\Variable::class, 'parentVar')->create();
		$response = $this->call('POST', '/delete-variable', ['id' => $var->id, 'environment' => $var->environment_id]);
		$data = json_decode($response->content(), true);
		$this->assertTrue($data['success']);
	}

	public function testDeleteVariableWithParent()
	{
		$var = factory(App\Variable::class, 'childVar')->create();
		$response = $this->call('POST', '/delete-variable', ['id' => $var->id, 'environment' => $var->environment_id]);
		$data = json_decode($response->content(), true);
		$this->assertTrue($data['success']);
	}

	public function testExport()
	{
		$id = factory(App\Environment::class, 'parent')->create()->id;
		$this->call('GET', '/export/'.$id);
		$this->assertResponseOk();
	}

	public function testExportFail()
	{
		$this->call('GET', '/export/-1');
		$this->assertResponseStatus(404);
	}
}
