<?php

namespace App\Http\Controllers;

use App\Models\GuestEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminGuestbookController extends Controller
{
    public function create(): View
    {
        return view('guestbook-admin', [
            'totalGuests' => GuestEntry::count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'organization' => ['required', 'string', 'max:120'],
            'met_with' => ['required', 'string', 'max:120'],
            'purpose' => ['required', 'string', 'max:180'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:32'],
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        GuestEntry::create($validated);

        return redirect()
            ->route('admin.guestbook.create')
            ->with('success', 'Kunjungan tamu berhasil dicatat.');
    }
}
