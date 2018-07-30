<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomerAcceptanceTest extends TestCase
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
        $response = $this->actor->call('GET', 'customers');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('customers');
    }

    public function testCreate()
    {
        $response = $this->actor->call('GET', 'customers/create');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = $this->actor->call('POST', 'customers', $this->Customer->toArray());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('customers/'.$this->Customer->id.'/edit');
    }

    public function testEdit()
    {
        $this->actor->call('POST', 'customers', $this->Customer->toArray());

        $response = $this->actor->call('GET', '/customers/'.$this->Customer->id.'/edit');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('customer');
    }

    public function testUpdate()
    {
        $this->actor->call('POST', 'customers', $this->Customer->toArray());
        $response = $this->actor->call('PATCH', 'customers/1', $this->CustomerEdited->toArray());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseHas('customers', $this->CustomerEdited->toArray());
        $this->assertRedirectedTo('/');
    }

    public function testDelete()
    {
        $this->actor->call('POST', 'customers', $this->Customer->toArray());

        $response = $this->call('DELETE', 'customers/'.$this->Customer->id);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('customers');
    }

}
