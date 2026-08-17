<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect($user->getDashboardUrl());
    }

    public function test_authenticated_users_cannot_access_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect($user->getDashboardUrl());
    }

    public function test_authenticated_users_cannot_access_root_route(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect($user->getDashboardUrl());
    }

    public function test_authenticated_admin_redirected_to_admin_dashboard_from_login(): void
    {
        $admin = User::factory()->create(['role' => \App\Enums\UserRole::ADMIN]);

        $response = $this->actingAs($admin)->get('/login');

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_authenticated_lecturer_redirected_to_lecturer_dashboard_from_login(): void
    {
        $lecturer = User::factory()->create(['role' => \App\Enums\UserRole::LECTURER]);

        $response = $this->actingAs($lecturer)->get('/login');

        $response->assertRedirect(route('lecturer.dashboard'));
    }

    public function test_authenticated_student_redirected_to_student_dashboard_from_login(): void
    {
        $student = User::factory()->create(['role' => \App\Enums\UserRole::STUDENT]);

        $response = $this->actingAs($student)->get('/login');

        $response->assertRedirect(route('student.dashboard'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
