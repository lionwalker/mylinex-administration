<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Administration\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_view_a_home_page_when_user_does_not_loged_in()
    {
        $response = $this->get('/home');

        $response->assertStatus(500);
    }

    public function test_user_can_view_a_home_page_when_user_authenticated()
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $this->post('/user-login', [
            'email' => 'super@mylinex.com',
            'password' => 'super@mylinex.com',
        ]);

        $response = $this->get('/home');
        $response->assertSuccessful();
        $response->assertViewIs('Administration::home');
    }
}
