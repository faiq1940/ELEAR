<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_login_redirects_to_student_dashboard(): void
    {
        User::factory()->create([
            'name' => 'Faiq',
            'email' => 'faiq@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'mahasiswa',
        ]);

        $response = $this->post('/login', [
            'name' => 'Faiq',
            'password' => 'secret123',
            'role' => 'mahasiswa',
        ]);

        $response->assertRedirect('/dashboard/mahasiswa');
        $response->assertSessionHas('user.role', 'mahasiswa');
    }

    public function test_invalid_login_redirects_back_and_does_not_enter_dashboard(): void
    {
        User::factory()->create([
            'name' => 'Dosen',
            'email' => 'dosen@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'dosen',
        ]);

        $response = $this->post('/login', [
            'name' => 'Dosen',
            'password' => 'wrong-password',
            'role' => 'dosen',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionMissing('user');
    }

    public function test_login_accepts_legacy_plain_text_passwords_and_rehashes_them(): void
    {
        User::factory()->create([
            'name' => 'Legacy User',
            'email' => 'legacy@example.com',
            'password' => 'secret123',
            'role' => 'mahasiswa',
        ]);

        $response = $this->post('/login', [
            'name' => 'Legacy User',
            'password' => 'secret123',
            'role' => 'mahasiswa',
        ]);

        $response->assertRedirect('/dashboard/mahasiswa');
        $response->assertSessionHas('user.role', 'mahasiswa');

        $user = User::where('name', 'Legacy User')->first();
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    public function test_student_login_renders_student_dashboard_view(): void
    {
        User::factory()->create([
            'name' => 'Student View',
            'email' => 'student-view@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'mahasiswa',
        ]);

        $this->post('/login', [
            'name' => 'Student View',
            'password' => 'secret123',
            'role' => 'mahasiswa',
        ])->assertRedirect('/dashboard/mahasiswa');

        $this->get('/dashboard/mahasiswa')
            ->assertStatus(200)
            ->assertSee('Dashboard Mahasiswa')
            ->assertSee('Kelas Aktif');
    }

    public function test_dosen_login_renders_dosen_dashboard_view(): void
    {
        User::factory()->create([
            'name' => 'Dosen View',
            'email' => 'dosen-view@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'dosen',
        ]);

        $this->post('/login', [
            'name' => 'Dosen View',
            'password' => 'secret123',
            'role' => 'dosen',
        ])->assertRedirect('/dashboard/dosen');

        $this->get('/dashboard/dosen')
            ->assertStatus(200)
            ->assertSee('Dashboard Dosen')
            ->assertSee('Kelas yang Saya Ampu');
    }

    public function test_logout_clears_session_and_redirects_home(): void
    {
        $user = User::factory()->create([
            'name' => 'Logout User',
            'email' => 'logout@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'mahasiswa',
        ]);

        $this->withSession([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
            ],
        ]);

        $response = $this->get('/logout');

        $response->assertRedirect('/');
        $response->assertSessionMissing('user');
    }
}
