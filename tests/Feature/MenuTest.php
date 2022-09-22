<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Administration\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MenuTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_meu_page_when_user_loged_in()
    {
        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'User4',
            'email' => 'user4@mylinex.com',
            'password' => Hash::make('user4@mylinex.com')
        ]);

        $response = $this->actingAs($user)->get('/menu');
        
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('Administration::menu.index');
    }

    public function test_user_can_see_menu_page_when_user_does_not_loged_in()
    {
        $response = $this->get('/menu');
        $response->assertStatus(500);
    }
}
