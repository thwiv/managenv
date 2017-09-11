<?php

class GolfingHomeControllerTest extends TestCase
{
	use \Illuminate\Foundation\Testing\DatabaseTransactions;
	use \Illuminate\Foundation\Testing\WithoutMiddleware;

	public function testIndex()
	{
		$id = factory(App\Environment::class, 'parent')->create()->id;
		$response = $this->call('GET', '/home');
		$this->assertViewHas('environments');
		$data = $response->getOriginalContent()->getData();
		$hasEnv = false;
		foreach ($data['environments'] as $environment) {
			if ($environment->id == $id) {
				$hasEnv = true;
				break;
			}
		}
		$this->assertTrue($hasEnv, "Created Environment Not Found");
	}
}
