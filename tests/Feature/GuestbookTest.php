<?php

namespace Tests\Feature;

use App\Models\GuestEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestbookTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_is_available(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Masuk ke akun')
            ->assertSee('name="password"', false);
    }

    public function test_guestbook_entries_are_publicly_visible_without_a_submission_form(): void
    {
        GuestEntry::factory()->create([
            'name' => 'Rina Putri',
            'organization' => 'PT Telkom Indonesia',
            'met_with' => 'DG',
            'purpose' => 'Rapat koordinasi',
        ]);

        $this->get(route('guestbook.index'))
            ->assertOk()
            ->assertSee('Rina Putri')
            ->assertSee('PT Telkom Indonesia')
            ->assertSee('DG')
            ->assertSee('Rapat koordinasi')
            ->assertDontSee('Tulis nama Anda');
    }

    public function test_guests_cannot_open_or_submit_the_admin_guestbook_form(): void
    {
        $this->get(route('admin.guestbook.create'))
            ->assertRedirect(route('login'));

        $this->post(route('admin.guestbook.store'), [
            'name' => 'Tamu Anonim',
            'organization' => 'PT Telkom',
            'met_with' => 'DG',
            'purpose' => 'Kunjungan langsung',
        ])->assertRedirect(route('login'));

        $this->assertDatabaseCount('guest_entries', 0);
    }

    public function test_an_admin_can_log_in_and_record_a_visit(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);

        $this->post(route('login.store'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assertRedirect(route('admin.guestbook.create'));

        $this->assertAuthenticatedAs($admin);
        $this->get(route('admin.guestbook.create'))
            ->assertOk()
            ->assertSee('Bertemu dengan');

        $this->post(route('admin.guestbook.store'), [
            'name' => 'Rina Putri',
            'organization' => 'PT Telkom Indonesia',
            'met_with' => 'DG',
            'purpose' => 'Rapat koordinasi',
            'email' => 'rina@example.com',
            'phone' => '08123456789',
            'message' => 'Membahas kerja sama.',
        ])->assertRedirect(route('admin.guestbook.create'));

        $this->assertDatabaseHas('guest_entries', [
            'name' => 'Rina Putri',
            'organization' => 'PT Telkom Indonesia',
            'met_with' => 'DG',
            'purpose' => 'Rapat koordinasi',
        ]);

        $this->get(route('guestbook.index'))
            ->assertOk()
            ->assertSee('PT Telkom Indonesia')
            ->assertSee('DG');
    }

    public function test_non_admin_users_cannot_log_in_or_access_admin_routes(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();

        $this->actingAs($user)
            ->get(route('admin.guestbook.create'))
            ->assertForbidden();
    }

    public function test_admin_can_sign_out(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.logout'))
            ->assertRedirect(route('guestbook.index'));

        $this->assertGuest();
        $this->get(route('admin.guestbook.create'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_visit_requires_a_name_company_contact_and_purpose(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->from(route('admin.guestbook.create'))
            ->post(route('admin.guestbook.store'), [])
            ->assertRedirect(route('admin.guestbook.create'))
            ->assertSessionHasErrors(['name', 'organization', 'met_with', 'purpose']);

        $this->assertDatabaseCount('guest_entries', 0);
    }

    public function test_guest_entries_can_be_searched_by_company(): void
    {
        GuestEntry::factory()->create([
            'name' => 'Budi Santoso',
            'organization' => 'PT Telkom',
            'met_with' => 'DG',
            'purpose' => 'Kunjungan kerja',
        ]);
        GuestEntry::factory()->create([
            'name' => 'Sari Dewi',
            'organization' => 'PT Lain',
            'met_with' => 'Rina',
            'purpose' => 'Rapat',
        ]);

        $this->get(route('guestbook.index', ['q' => 'Telkom']))
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertDontSee('Sari Dewi');
    }
}
