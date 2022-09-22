<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Administration\Models\User;
use Illuminate\Support\Facades\Hash;

class UserDestroyTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_destroy_user_when_loged(): void
    {
        $id = User::create([
            'role' => 'Admin',
            'name' => 'Test User2',
            'email' => 'test4@mylinex.com',
            'password' => Hash::make('test4@mylinex.com')
        ])->id;

        $user = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $response = $this->actingAs($user)->call('DELETE', '/users/'.$id);
        $response->assertStatus(200)->getContent();
    }
}
