<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================================
    // index()
    // =========================================================================

    /** @test */
    public function index_returns_login_view()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('login');
    }

    /** @test */
    public function index_is_accessible_to_guests()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    // =========================================================================
    // authenticate()
    // =========================================================================

    /** @test */
    public function authenticate_validates_email_is_required()
    {
        $response = $this->post(route('login'), [
            'email'    => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function authenticate_validates_email_must_be_valid_format()
    {
        $response = $this->post(route('login'), [
            'email'    => 'not-an-email',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function authenticate_validates_password_is_required()
    {
        $response = $this->post(route('login'), [
            'email'    => 'user@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function authenticate_returns_error_when_credentials_are_wrong()
    {
        User::factory()->create([
            'email'    => 'user@example.com',
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'user@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function authenticate_returns_error_when_email_does_not_exist()
    {
        $response = $this->post(route('login'), [
            'email'    => 'nobody@example.com',
            'password' => 'any-password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function authenticate_flashes_email_back_to_input_on_failure()
    {
        $response = $this->post(route('login'), [
            'email'    => 'user@example.com',
            'password' => 'wrong',
        ]);

        $response->assertSessionHasInput('email', 'user@example.com');
    }

    /** @test */
    public function authenticate_does_not_flash_password_back_on_failure()
    {
        $response = $this->post(route('login'), [
            'email'    => 'user@example.com',
            'password' => 'wrong',
        ]);

        $response->assertSessionMissing('password');
    }

    /** @test */
    public function authenticate_logs_in_user_with_correct_credentials()
    {
        User::factory()->create([
            'email'    => 'user@example.com',
            'password' => bcrypt('correct-password'),
            'role'     => 'user',
        ]);

        $this->post(route('login'), [
            'email'    => 'user@example.com',
            'password' => 'correct-password',
        ]);

        $this->assertTrue(Auth::check());
    }

    /** @test */
    public function authenticate_regenerates_session_on_successful_login()
    {
        $user = User::factory()->create([
            'email'    => 'user@example.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        $oldToken = session()->token();

        $this->post(route('login'), [
            'email'    => 'user@example.com',
            'password' => 'password',
        ]);

        // Session ID regenerated — CSRF token should differ
        $this->assertNotEquals($oldToken, session()->token());
    }

    /** @test */
    public function authenticate_redirects_regular_user_to_home()
    {
        User::factory()->create([
            'email'    => 'user@example.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'user@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function authenticate_redirects_admin_user_to_admin_panel()
    {
        User::factory()->create([
            'email'    => 'admin@example.com',
            'password' => bcrypt('adminpass'),
            'role'     => 'admin',
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'admin@example.com',
            'password' => 'adminpass',
        ]);

        $response->assertRedirect('/admin');
    }

    // =========================================================================
    // logout()
    // =========================================================================

    /** @test */
    public function logout_logs_out_the_authenticated_user()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('logout'));

        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function logout_invalidates_the_session()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $sessionId = session()->getId();

        $this->post(route('logout'));

        $this->assertNotEquals($sessionId, session()->getId());
    }

    /** @test */
    public function logout_regenerates_csrf_token()
    {
        $user  = User::factory()->create();
        $this->actingAs($user);
        $oldToken = session()->token();

        $this->post(route('logout'));

        $this->assertNotEquals($oldToken, session()->token());
    }

    /** @test */
    public function logout_redirects_to_login_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function logout_shows_success_flash_message()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertSessionHas('success');
    }

    /** @test */
    public function logout_is_idempotent_for_guests()
    {
        // Logging out when already a guest should not throw
        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
    }
}