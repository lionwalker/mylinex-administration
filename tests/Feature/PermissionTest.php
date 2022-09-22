<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Administration\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PermissionTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_view_permission_page_when_user_loged_in()
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $response = $this->actingAs($superUser)->get('/permissions');

        $response->assertOk();
    }

    public function test_user_can_view_permission_page_when_user_is_un_authenticated(): void 
    {
        $response = $this->get('/permissions');

        $response->assertStatus(500);
    }
}
