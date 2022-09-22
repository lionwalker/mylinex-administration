<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Http\Request;
use Administration\Models\User;
use Administration\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserStoreTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_user_if_unauthenticated()
    {
        $response = $this->post('/users', [
            'role' => 'Super Admin', 
            'name' => 'User', 
            'email' => 'user@mylinex.com', 
            'password' => 'user@mylinex.com'
        ]);

        $response->assertStatus(500);
    }

    public function test_store_user_if_authenticated()
    {
        Role::create([
            'name' => 'Super Admin',
            'gaurd_name' => 'web'
        ]);
        
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $this->post('/user-login', [
            'email' => 'super@mylinex.com',
            'password' => 'super@mylinex.com'
        ]);
        
        $response = $this->post('/users', [
            'name' => 'User', 
            'email' => 'user@mylinex.com', 
            'password' => 'user@mylinex.com'
        ]);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['name' => 'User', 'email' => 'user@mylinex.com']);
    }

    public function test_store_user_with_invalid_inputs()
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $response = $this->actingAs($superUser)->post('/users', [
            'role' => 'Super Admin', 
            'name' => '', 
            'email' => 'tempory@mylinex.com', 
            'password' => ''
        ]);

        $response->assertStatus(500);
        $this->assertDatabaseMissing('users', ['name' => '', 'email' => 'tempory@mylinex.com']);
    }

    public function test_store_user_with_already_exist_user()
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $response = $this->actingAs($superUser)->post('/users', [
            'name' => 'User2', 
            'email' => 'user@mylinex.com', 
            'password' => 'user@123'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'user@mylinex.com']);
    }
}
