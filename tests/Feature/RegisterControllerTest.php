<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    // Menggunakan RefreshDatabase agar database di-reset setiap kali test dijalankan
    use RefreshDatabase;

    /**
     * [TC-REG-01] Menguji apakah sistem menampilkan halaman registrasi
     */
    public function test_it_displays_register_view()
    {
        // Asumsi route kamu adalah /register
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('register');
    }

    /**
     * [TC-REG-02] Menguji registrasi dengan data yang valid
     */
    public function test_it_can_register_a_new_user_with_valid_data()
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi.tester@gmail.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        // Assert redirect ke route login
        $response->assertRedirect(route('login'));
        
        // Assert session memiliki pesan success
        $response->assertSessionHas('success', 'Akun berhasil dibuat! Silakan login.');

        // Assert data masuk ke database
        $this->assertDatabaseHas('users', [
            'name' => 'Budi Santoso',
            'email' => 'budi.tester@gmail.com',
        ]);

        // Assert password di-hash (tidak tersimpan dalam bentuk plain text)
        $user = User::where('email', 'budi.tester@gmail.com')->first();
        $this->assertTrue(Hash::check('rahasia123', $user->password));
    }

    /**
     * [TC-REG-03] Menguji kegagalan jika field kosong
     */
    public function test_it_fails_validation_if_fields_are_empty()
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /**
     * [TC-REG-04] Menguji kegagalan jika nama terlalu pendek
     */
    public function test_it_fails_validation_if_name_is_too_short()
    {
        $response = $this->post('/register', [
            'name' => 'Al', // Kurang dari 3 karakter
            'email' => 'valid.email@gmail.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * [TC-REG-05] Menguji kegagalan jika format email tidak valid
     */
    public function test_it_fails_validation_if_email_is_invalid()
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'bukan-email-yang-benar', // Format salah
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * [TC-REG-06] Menguji kegagalan jika email sudah terdaftar
     */
    public function test_it_fails_validation_if_email_is_already_taken()
    {
        // Buat user dummy di database terlebih dahulu
        User::create([
            'name' => 'User Lama',
            'email' => 'existing@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/register', [
            'name' => 'User Baru',
            'email' => 'existing@gmail.com', // Email sudah ada
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * [TC-REG-07] Menguji kegagalan jika password terlalu pendek
     */
    public function test_it_fails_validation_if_password_is_too_short()
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi.new@gmail.com',
            'password' => '12345', // Kurang dari 6 karakter
            'password_confirmation' => '12345',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * [TC-REG-08] Menguji kegagalan jika konfirmasi password tidak cocok
     */
    public function test_it_fails_validation_if_password_confirmation_does_not_match()
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi.new@gmail.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'beda123', // Tidak cocok dengan password
        ]);

        $response->assertSessionHasErrors(['password']);
    }
}