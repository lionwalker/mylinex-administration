<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Administration\Models\User;
use Administration\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PermissionDestroyTest extends TestCase
{
    use DatabaseMigrations;
    
    public function test_permission_destroy(): void
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

        $this->assertEquals(1, Permission::count());

        $response = $this->actingAs($superUser)->delete('/permissions/'.$permission->id);

        $this->assertEquals(0, Permission::count());

        $response->assertStatus(200);
    }

    public function test_permission_destroy_without_user_authenticated(): void 
    {
        $permission = Permission::create([
            'name' => 'home index',
            'gaurd_name' => 'web'
        ]);

        $this->assertEquals(1, Permission::count());

        $response = $this->delete('/permissions/'.$permission->id);

        $this->assertEquals(1, Permission::count());

        $response->assertStatus(500);
    }
}
