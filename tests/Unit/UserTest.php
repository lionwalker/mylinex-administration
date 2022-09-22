<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Administration\Controllers\LoginController;
use Administration\Controllers\UserController;
use Administration\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_function(): void 
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);
        
        $response = $this->actingAs($superUser)->post('/user-login', [
            'email' => 'super@mylinex.com',
            'password' => 'super@mylinex.com'
        ]);
        
        $response->assertStatus(302);
    }

    public function test_user_store(): void 
    {
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

        $data = [
            'role_name' => 'Super Admin', 
            'name' => 'user',
            'email' => 'user@mylinex.com', 
            'password' => 'user@mylinex.com'
        ];
        $request = new Request($data);
        $response = (new UserController())->store($request);
        
        $this->assertEquals(2, User::count());
    }
}
