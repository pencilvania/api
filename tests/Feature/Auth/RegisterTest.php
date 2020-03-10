<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Register_Successfully()
    {
        //User's data
        $data = [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ];
        //Send post request
     //   $response = $this->json('POST',route('api.register'),$data);
        //Assert it was successful
        $response =$this->json('POST', 'api/auth/register', $data);
        DB::table('users')->where('email','test@gmail.com')->delete();
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user' => [
                'id',
                'status',
                'email',
                'created_at',
                'updated_at'
            ]
        ]);

    }

    public function test_Register_duplicate_email()
    {
        //User's data
        $data = [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ];
        //Send post request
        //   $response = $this->json('POST',route('api.register'),$data);
        //Assert it was successful
        $response =$this->json('POST', 'api/auth/register', $data);
        $response =$this->json('POST', 'api/auth/register', $data);
        DB::table('users')->where('email','test@gmail.com')->delete();
        $response->assertStatus(422);
        $response->assertSeeText('The email has already been taken');

    }

    public function test_Require_Password_Confirmation()
    {
        //User's data
        $data = [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ];
        //Send post request
        //   $response = $this->json('POST',route('api.register'),$data);
        //Assert it was successful
        $response =$this->json('POST', 'api/auth/register', $data);
        $response->assertStatus(422);
        $response->assertSeeText('The password confirmation field is required');

    }
}
