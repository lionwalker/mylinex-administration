<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Administration\Models\User;
use Administration\Models\Menu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MenuDestroyTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_destroy_menu_when_user_authenticated()
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

        $response = $this->actingAs($superUser)->delete('/menu/'.$parentMenu);
            
        $response->assertStatus(200);
    }

    public function test_destroy_menu_when_user_is_un_authenticated(): void 
    {
        $parentMenu = Menu::create([
            'isParent' => 'on',
            'parent_id' => null,
            'title' => 'Administration',
            'url' => '',
            'permission-tags[]' => ''
        ])->id;

        $response = $this->delete('/menu/'.$parentMenu);
            
        $response->assertStatus(500);
    }
}
