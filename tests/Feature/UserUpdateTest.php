<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Administration\Models\User;
use Illuminate\Support\Facades\Hash;

class UserUpdateTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_update_when_user_is_not_loged(): void
    {
        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Test User2',
            'email' => 'test2@mylinex.com',
            'password' => Hash::make('test2@mylinex.com')
        ])->id;

        $response = $this->put('/users/'.$user, [
            'role' => 'Super Admin',
            'name' => 'Test User',
            'email' => 'test2@mylinex.com'
        ]);

        $response->assertStatus(500);
    }

    public function test_user_update_when_user_is_loged(): void
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Test User',
            'email' => 'test@mylinex.com',
            'password' => Hash::make('test@mylinex.com')
        ])->id;

        $this->post('/user-login', [
            'email' => 'test@mylinex.com',
            'password' => 'test@mylinex.com',
        ]);

        $response = $this->put('/users/'.$user, [
            'role' => 'Super Admin',
            'name' => 'Test User',
            'email' => 'user@mylinex.com'
        ]);

        $response->assertStatus(200);
    }

    public function test_user_update_with_already_exist_user(): void
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        User::create([
            'role' => 'Super Admin',
            'name' => 'User',
            'email' => 'user@mylinex.com',
            'password' => Hash::make('user@mylinex.com')
        ]);

        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Test User',
            'email' => 'test@mylinex.com',
            'password' => Hash::make('test@mylinex.com')
        ])->id;

        $response = $this->actingAs($superUser)->put('/users/'.$user, [
            'role' => 'Admin',
            'name' => 'Test User',
            'email' => 'user@mylinex.com'
        ]);
        
        $response->assertStatus(200)->getContent();
    }

    public function test_user_update_with_invalid_inputs(): void
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Test User',
            'email' => 'test@mylinex.com',
            'password' => Hash::make('test@mylinex.com')
        ])->id;

        $response = $this->actingAs($superUser)->put('/users/'.$user, [
            'role' => 'Admin',
            'name' => '',
            'email' => ''
        ]);
        
        $response->assertStatus(500)->getContent();
    }
}
