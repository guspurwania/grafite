<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomerAcceptanceApiTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->Customer = factory(App\Models\Customer::class)->make([
            'id' => '1',
		'name' => '1',

        ]);
        $this->CustomerEdited = factory(App\Models\Customer::class)->make([
            'id' => '1',
		'name' => '1',

        ]);
        $user = factory(App\Models\User::class)->make();
        $this->actor = $this->actingAs($user);
    }

    public function testIndex()
    {
        $response = $this->actor->call('GET', 'api/v1/customers');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = $this->actor->call('POST', 'api/v1/customers', $this->Customer->toArray());
        $this->assertEquals(200, $response->getStatusCode());
        $this->seeJson(['id' => 1]);
    }

    public function testUpdate()
    {
        $this->actor->call('POST', 'api/v1/customers', $this->Customer->toArray());
        $response = $this->actor->call('PATCH', 'api/v1/customers/1', $this->CustomerEdited->toArray());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('customers', $this->CustomerEdited->toArray());
    }

    public function testDelete()
    {
        $this->actor->call('POST', 'api/v1/customers', $this->Customer->toArray());
        $response = $this->call('DELETE', 'api/v1/customers/'.$this->Customer->id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->seeJson(['success' => 'customer was deleted']);
    }

}
