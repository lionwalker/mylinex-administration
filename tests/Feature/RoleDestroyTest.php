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

class RoleDestroyTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_destroy_role_when_user_is_loged_in()
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

        $role = Role::create([
            'name' => 'User',
            'permissions' => ['roles index', 'roles create', 'roles show'],
            'guard_name' => 'web'
        ]);

        $this->assertEquals(1, Role::count());
        
        $response = $this->actingAs($superUser)->delete('/roles/'.$role->id);
        $this->assertEquals(0, Role::count());
        $response->assertOk();
    }

    public function test_destroy_role_when_user_is_un_authenticated(): void 
    {
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

        $role = Role::create([
            'name' => 'User',
            'permissions' => ['roles index', 'roles create', 'roles show'],
            'guard_name' => 'web'
        ]);
        
        $response = $this->delete('/roles/'.$role->id);
        $this->assertEquals(1, Role::count());
        $response->assertStatus(500);
    }
}
