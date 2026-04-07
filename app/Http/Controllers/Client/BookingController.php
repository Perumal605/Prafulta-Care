<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Support\Roles;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->with('counsellor')
            ->where('client_id', auth()->id())
            ->latest('scheduled_at')
            ->paginate(12);

        return view('client.bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        $counsellors = User::query()
            ->where('role', Roles::COUNSELLOR)
            ->whereHas('counsellorProfile', fn ($q) => $q->where('is_active', true))
            ->with('counsellorProfile')
            ->get();

        return view('client.bookings.create', compact('counsellors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'counsellor_id' => ['required', 'exists:users,id'],
            'service_type' => ['required', 'in:regular_counselling,occupational_therapy,remedial_therapy'],
            'session_mode' => ['nullable', 'in:video,call,in_person'],
            'scheduled_at' => ['required', 'date', 'after:now'],
        ]);

        $scheduledAt = Carbon::parse($validated['scheduled_at'], config('app.timezone'));

        $amount = (float) optional(User::find($validated['counsellor_id'])->counsellorProfile)->session_price;

        Booking::query()->create([
            'booking_reference' => 'BK-'.strtoupper(Str::random(8)),
            'client_id' => auth()->id(),
            'counsellor_id' => (int) $validated['counsellor_id'],
            'service_type' => $validated['service_type'],
            'session_mode' => $validated['session_mode'] ?? null,
            'scheduled_at' => $scheduledAt,
            'status' => 'pending',
            'payment_status' => 'pending',
            'amount' => $amount ?: 0,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('client.bookings.index')
            ->with('status', 'Booking request submitted.');
    }
}
