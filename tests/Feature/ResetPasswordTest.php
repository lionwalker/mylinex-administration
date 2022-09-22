<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Administration\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_reset_password()
    {
        $userId = User::create([
            'role' => 'Super Admin',
            'name' => 'User5',
            'email' => 'user5@mylinex.com',
            'password' => Hash::make('user4@mylinex.com')
        ])->id;

        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $responseFirstLogin = $this->post('/user-login', [
            'email' => 'user5@mylinex.com',
            'password' => 'user4@mylinex.com'
        ]);
        
        $this->actingAs($user)->put('/users/'.$userId.'/reset', [
            'password' => 'user5@mylinex.com'
        ]);

        $responseSecondLogin = $this->post('/user-login', [
            'email' => 'user5@mylinex.com',
            'password' => 'user5@mylinex.com'
        ]);

        $responseFirstLogin->assertStatus(302);
        $responseSecondLogin->assertStatus(302);
    }

    public function test_reset_password_without_user_loged_in()
    {
        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ])->id;
        
        $response = $this->put('/users/'.$user.'/reset', [
            'password' => 'ahdghhs'
        ]);

        $response->assertStatus(500);
    }
}
