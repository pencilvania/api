<?php

namespace Tests\Feature\Auth;

use App\Superheros;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\AttachJwtToken;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class SuperHeroTest extends TestCase
{

    /**
     * A trait for create Authentications
     *
     */
    use AttachJwtToken;

    public function createHero()
    {
        return factory(Superheros::class)->create();
    }

    /**
     * POST /api/heros/create
     * Should return 200 with data array
     *
     */
    public function test_create_superhero()
    {

        $data = [
            'heroname' => 'testcasetest',
            'realname' => 'bbb',
            'publisher' => 'sad',
            'fadate' => '2017/10/12',
            'affiliations' => []
        ];

        //Assert it was successful
        $response =$this->json('POST', 'api/heros/create', $data);
        DB::table('superheros')->where('heroname','testcasetest')->delete();
        $response->assertStatus(200);
        $response->assertSeeText('record added successfully');

    }

    /**
     * GET /api/heros/{id}
     * Should return 201 with data array
     *
     */
    public function test_Show_by_id()
    {
        // Create a test shop with filled out fields
        $activity = $this->createHero();
        // Check the API for the new entry
        $response = $this->json('GET', "/api/heros/{$activity->id}");
        // Delete the test shop
        $activity->delete();
        $response->assertStatus(200);

    }

    /**
     * DELETE /api/heros/<id>/remove
     * Tests the destroy() method that deletes the hero
     *
     */
    public function test_Destroy()
    {
        $activity = $this->createHero();
        $response = $this->json('DELETE', "api/heros/{$activity->id}/remove");
        $response
            ->assertStatus(200);
    }

    /**
     * DELETE /api/heros/<id>/remove
     * Tests the destroy() method that deletes the hero
     *
     */
    public function test_destroy_when_id_does_not_exist()
    {
        $random_id = rand(1000000,3000000);
        $response = $this->json('DELETE', "api/heros/{$random_id}/remove");
        $response
            ->assertStatus(200);
    }

}
