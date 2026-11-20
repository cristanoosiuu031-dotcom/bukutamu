<?php

namespace App\Http\Controllers;

use App\Models\GuestEntry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestbookController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($validated['q'] ?? '');

        $entries = GuestEntry::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('organization', 'like', "%{$search}%")
                        ->orWhere('met_with', 'like', "%{$search}%")
                        ->orWhere('purpose', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('guestbook', [
            'entries' => $entries,
            'search' => $search,
            'totalGuests' => GuestEntry::count(),
        ]);
    }
}
