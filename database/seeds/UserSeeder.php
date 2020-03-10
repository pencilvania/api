<?php

use Illuminate\Database\Seeder;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'email' => 'guest@cartrack.pt',
            'password' => Hash::make('1234'),
            'status' => UserStatus::Activated
        ]);
    }
}
