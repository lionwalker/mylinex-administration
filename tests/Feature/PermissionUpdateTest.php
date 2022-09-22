<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Administration\Models\User;
use Administration\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PermissionUpdateTest extends TestCase
{
    use DatabaseMigrations;
    
    public function test_update_permission(): void
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $permission = Permission::create([
            'name' => 'home index',
            'gaurd_name' => 'web'
        ]);

        $this->assertEquals('home index', Permission::first()->name);

        $response = $this->actingAs($superUser)->put('/permissions/'.$permission->id, [
            'name' => 'home create'
        ]);

        $this->assertEquals('home create', Permission::first()->name);
        $response->assertOk();
    }

    public function test_update_permission_when_user_is_unauthenticated(): void 
    {
        $permission = Permission::create([
            'name' => 'home index',
            'gaurd_name' => 'web'
        ]);

        $this->assertEquals('home index', Permission::first()->name);

        $response = $this->put('/permissions/'.$permission->id, [
            'name' => 'home create'
        ]);

        $this->assertEquals('home index', Permission::first()->name);
        $response->assertStatus(500);
    }

    public function test_update_permission_with_exist_data(): void 
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $permission = Permission::create([
            'name' => 'home index',
            'gaurd_name' => 'web'
        ]);

        Permission::create([
            'name' => 'menu index',
            'gaurd_name' => 'web'
        ]);

        $this->assertEquals('home index', Permission::first()->name);
        $this->assertEquals('menu index', Permission::find(2)->name);
        
        $response = $this->actingAs($superUser)->put('/permissions/'.$permission->id, [
            'name' => 'menu index'
        ]);
        
        $this->assertEquals('menu index', Permission::first()->name);
        $this->assertEquals('menu index', Permission::find(2)->name);
        $response->assertOk();
    }
}
