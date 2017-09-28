<?php
class HomeControllerTest extends TestCase
{
	use \Illuminate\Foundation\Testing\DatabaseTransactions;
	use \Illuminate\Foundation\Testing\WithoutMiddleware;

	public function setUp()
	{
		$this->markTestSkipped('For Science!');
	}
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


	public function testAddParentEnvironment()
	{
		/** @var \Illuminate\Http\JsonResponse $response */
		$response = $this->call('POST', '/environment/', ['name' => 'home_controller_test_env']);
		$this->seeInDatabase('environments', ['name' => 'new_environment', 'parent_id'=>null]);
		$data = json_decode($response->content(), true);
		$this->assertArrayHasKey('success', $data);
		$this->assertTrue($data['success']);
		$this->assertArrayHasKey('id', $data);
	}

	public function testAddParentEnvironmentDuplicate()
	{
		$name = factory(App\Environment::class, 'parent')->create()->name;
		/** @var \Illuminate\Http\JsonResponse $response */
		$response = $this->call('POST', '/environment/', ['name' => $name]);
		$this->seeInDatabase('environments', ['name' => 'new_environment', 'parent_id'=>null]);
		$data = json_decode($response->content(), true);
		$this->assertArrayHasKey('success', $data);
		$this->assertTrue($data['success']);
		$this->assertArrayNotHasKey('id', $data);
		$this->assertArrayHasKey('error', $data);
		$this->assertEquals('Name Must Be Unique', $data['error']);
	}
}
