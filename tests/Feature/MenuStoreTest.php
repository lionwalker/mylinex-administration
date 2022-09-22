<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Administration\Models\User;
use Illuminate\Support\Facades\Hash;

class MenuStoreTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_menu_when_parent_menu_is_true(): void
    {
        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'User4',
            'email' => 'user4@mylinex.com',
            'password' => Hash::make('user4@mylinex.com')
        ]);

        $response = $this->actingAs($user)->post('/menu', [
            'isParent' => 'on',
            'parent_id' => '',
            'title' => 'test',
            'url' => '',
            'permission-tags[]' => ''
        ]);

        $response->assertStatus(200);
    }

    public function test_store_menu_when_parent_menu_is_false(): void
    {
        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $response = $this->actingAs($user)->post('/menu', [
            'parent_id' => '1',
            'title' => 'Test',
            'url' => 'test',
            'permission-tags[]' => ''
        ]);

        $response->assertStatus(200);
    }

    public function test_store_menu_with_invalid_inputs_when_parent_menu_is_false(): void
    {
        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $response = $this->actingAs($user)->post('/menu', [
            'parent_id' => '1',
            'title' => 'Test',
            'url' => 'test',
            'permission-tags[]' => ''
        ]);
        
        $response->assertStatus(200);
    }

}
