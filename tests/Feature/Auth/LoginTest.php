<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Login_Successfully()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('1234'),
        ]);
        $response = $this->post('api/auth/login', [
            'email' => $user->email,
            'password' => '1234'
        ]);
        DB::table('users')->where('email',$user->email)->delete();
        $response->assertStatus(200);
        $response->assertSeeText('token');

    }

    public function test_Login_without_email_or_password()
    {

        $response = $this->post('api/auth/login', [
            'password' => '1234'
        ]);
        $response->assertStatus(422);


    }


}
