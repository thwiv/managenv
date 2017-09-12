<?php

class GolfingCleanupTest extends TestCase {
	use \Illuminate\Foundation\Testing\DatabaseTransactions;

	public function testGetVariableEnvironment()
	{
		$var = factory(App\Variable::class, 'parentVar')->create();
		$this->assertEquals($var->environment_id, $var->environment->id);
	}

	public function testFailToDecrypt()
	{
		$val = 'test';
		$var = factory(App\Variable::class, 'parentVar')->create(['value' => $val]);
		\Illuminate\Support\Facades\Crypt::shouldReceive('decrypt')->andThrow(\Illuminate\Contracts\Encryption\DecryptException::class);
		$this->assertNotEquals($val, $var->value);
	}
}
