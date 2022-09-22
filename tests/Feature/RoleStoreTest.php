<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Administration\Models\User;
use Administration\Models\Role;
use Administration\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RoleStoreTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_role_when_user_is_authenticated()
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        Permission::create(
            [
                'name' => 'roles index',
                'guard_name' => 'web'
            ]
        );
        Permission::create(
            [
                'name' => 'roles create',
                'guard_name' => 'web'
            ]
        );
        Permission::create(
            [
                'name' => 'roles show',
                'guard_name' => 'web'
            ]
        );

        $response = $this->actingAs($superUser)->post('/roles', [
            'name' => 'User',
            'permissions' => ["roles index"]
        ]);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('roles', ['name' => 'User']);
    }

    public function test_store_role_when_user_is_un_authenticated(): void 
    {
        $response = $this->post('/roles', [
            'name' => 'User',
            'permissions' => ['roles index', 'roles create', 'roles show']
        ]);

        $response->assertStatus(500);
    }
}
