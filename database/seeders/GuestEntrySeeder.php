<?php

namespace Database\Seeders;

use App\Models\GuestEntry;
use Illuminate\Database\Seeder;

class GuestEntrySeeder extends Seeder
{
    public function run(): void
    {
        GuestEntry::factory()->create([
            'name' => 'Andi Saputra',
            'organization' => 'PT Telkom Indonesia',
            'met_with' => 'DG',
            'purpose' => 'Koordinasi program kerja',
            'message' => 'Terima kasih atas sambutan hangatnya.',
        ]);

        GuestEntry::factory()->create([
            'name' => 'Maya Putri',
            'organization' => 'Ruang Belajar',
            'met_with' => 'Maya Pratama',
            'purpose' => 'Silaturahmi',
            'message' => 'Senang bisa berkunjung dan bertukar cerita.',
        ]);

        GuestEntry::factory()->create([
            'name' => 'Rizky Hidayat',
            'organization' => 'PT Sinar Abadi',
            'met_with' => 'Rina Kusuma',
            'purpose' => 'Pekerjaan',
            'message' => 'Semoga bisa bertemu lagi di kesempatan berikutnya.',
        ]);
    }
}
