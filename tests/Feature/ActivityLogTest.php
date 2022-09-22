<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Administration\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityLogTest extends TestCase
{
    use DatabaseMigrations;
    
    public function test_user_can_see_activity_log_page(): void 
    {
        $superUser = User::create([
            'role' => 'Super Admin',
            'name' => 'Super User',
            'email' => 'super@mylinex.com',
            'password' => Hash::make('super@mylinex.com')
        ]);

        $response = $this->actingAs($superUser)->get('/activity-logs');

        $response->assertStatus(200);
        // $response->assertSuccessfull();
    }
}
