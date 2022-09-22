<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Administration\Models\User;
use Administration\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_view_a_login_form(): void
    {
        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertViewIs('Administration::auth.login');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        Role::create([
            'name' => 'Super Admin',
            'gaurd_name' => 'web'
        ]);
        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Test User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);
        
        $response = $this->post('/user-login', [
            'email' => 'super@mylinex.com',
            'password' => 'super@mylinex.com',
        ]);
        
        $response->assertStatus(302);
        $response->assertRedirect('/home');
    }
    
    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Test User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $response = $this->post('/user-login', [
            'email' => 'super@mylinex',
            'password' => 'super@mylinex'
        ]);
        
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
