<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Administration\Models\User;
use Administration\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PermissionStoreTest extends TestCase
{
    use DatabaseMigrations;
    
    public function test_store_permission(): void
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $response = $this->actingAs($superUser)->post('/permissions', [
            'name' => 'home index'
        ]);
        
        $this->assertEquals('home index', Permission::first()->name);
        $response->assertok();
    }

    public function test_store_permissions_when_user_is_un_authenticated(): void 
    {
        $response = $this->post('/permissions', [
            'name' => 'home index'
        ]);
        
        $response->assertStatus(500);
    }

    public function test_store_permission_with_invalid_inputs(): void 
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $response = $this->actingAs($superUser)->post('/permissions', [
            'name' => ''
        ]);
        
        $this->assertEquals(0, Permission::count());
        $response->assertStatus(500);
    }
}
