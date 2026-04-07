<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Support\Roles;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuestBookingController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'counsellor_id' => ['required', 'exists:users,id'],
            'service_type' => ['required', 'in:regular_counselling,occupational_therapy,remedial_therapy'],
            'session_mode' => ['required', 'in:video,call,in_person'],
            'scheduled_at' => ['required', 'date', 'after:now'],
        ]);

        $scheduledAt = Carbon::parse($validated['scheduled_at'], config('app.timezone'));

        // Find or create the user (guest auto-registration).
        $user = User::query()->firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'password' => Hash::make(Str::random(16)),
                'role' => Roles::CLIENT,
            ]
        );

        $counsellor = User::with('counsellorProfile')->findOrFail($validated['counsellor_id']);
        $amount = (float) optional($counsellor->counsellorProfile)->session_price;

        $booking = Booking::query()->create([
            'booking_reference' => 'BK-'.strtoupper(Str::random(8)),
            'client_id' => $user->id,
            'counsellor_id' => (int) $validated['counsellor_id'],
            'service_type' => $validated['service_type'],
            'session_mode' => $validated['session_mode'],
            'scheduled_at' => $scheduledAt,
            'status' => 'pending',
            'payment_status' => 'pending',
            'amount' => $amount ?: 0,
            'created_by' => $user->id,
        ]);

        // Build Razorpay order or simulation payload.
        $razorpayKeyId = config('services.razorpay.key_id');

        if ($razorpayKeyId && $razorpayKeyId !== 'simulate') {
            // Real Razorpay order creation would go here.
            // For now return the key so checkout.js can use it.
            return response()->json([
                'booking_reference' => $booking->booking_reference,
                'amount' => (int) ($amount * 100), // Razorpay expects paise.
                'currency' => 'INR',
                'razorpay_key_id' => $razorpayKeyId,
                'razorpay_order_id' => null, // Replace with real order id when API is wired.
                'mode' => 'razorpay',
                'prefill' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'contact' => $user->phone,
                ],
            ]);
        }

        // Simulation mode — no real Razorpay keys configured.
        return response()->json([
            'booking_reference' => $booking->booking_reference,
            'amount' => $amount,
            'currency' => 'INR',
            'mode' => 'simulate',
            'prefill' => [
                'name' => $user->name,
                'email' => $user->email,
                'contact' => $user->phone,
            ],
        ]);
    }
}
