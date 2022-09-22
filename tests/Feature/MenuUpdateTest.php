<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Administration\Models\User;
use Administration\Models\Menu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MenuUpdateTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_menu_when_user_loged_in()
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $parentMenu = Menu::create([
            'isParent' => 'on',
            'parent_id' => null,
            'title' => 'Administration',
            'url' => '',
            'permission-tags[]' => ''
        ])->id;

        $menu = Menu::create([
            'parent_id' => $parentMenu,
            'title' => 'Menu',
            'url' => 'menu.index',
            'permission-tags[]' => 'index, create, show'
        ])->id;

        $response = $this->actingAs($superUser)->put('/menu/'.$menu, [
            'parent_id' => $parentMenu,
            'title' => 'Role',
            'url' => 'roles.index',
            'permission-tags[]' => ''
        ]);

        $response->assertStatus(200)->getContent();
    }

    public function test_update_menu_when_user_unauthenticated(): void
    {
        $parentMenu = Menu::create([
            'isParent' => 'on',
            'parent_id' => null,
            'title' => 'Administration',
            'url' => '',
            'permission-tags[]' => ''
        ])->id;

        $menu = Menu::create([
            'parent_id' => $parentMenu,
            'title' => 'Menu',
            'url' => 'menu.index',
            'permission-tags[]' => 'index, create, show'
        ])->id;

        $response = $this->put('/menu/'.$menu, [
            'parent_id' => $parentMenu,
            'title' => 'Role',
            'url' => 'roles.index',
            'permission-tags[]' => ''
        ]);

        $response->assertStatus(500)->getContent();
    }

    public function test_parent_menu_update(): void
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $parentMenu = Menu::create([
            'isParent' => 'on',
            'parent_id' => null,
            'title' => 'Administration',
            'url' => '',
            'permission-tags[]' => ''
        ])->id;

        $response = $this->actingAs($superUser)->put('/menu/'.$parentMenu, [
            'isParent' => 'on',
            'title' => 'NoMenu',
        ]);
        
        $response->assertStatus(200)->getContent();
    }
}
