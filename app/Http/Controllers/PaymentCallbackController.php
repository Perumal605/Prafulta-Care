<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentCallbackController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'booking_reference' => ['required', 'string', 'exists:bookings,booking_reference'],
            'razorpay_payment_id' => ['nullable', 'string'],
            'razorpay_signature' => ['nullable', 'string'],
            'simulated' => ['nullable', 'boolean'],
        ]);

        $booking = Booking::query()
            ->where('booking_reference', $validated['booking_reference'])
            ->firstOrFail();

        if ($booking->payment_status === 'paid') {
            return response()->json([
                'success' => true,
                'message' => 'Payment already recorded.',
                'booking_reference' => $booking->booking_reference,
            ]);
        }

        // In production, verify Razorpay signature here.
        // For now accept both simulated and real callbacks.

        $booking->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);

        Payment::query()->create([
            'booking_id' => $booking->id,
            'training_registration_id' => null,
            'payment_purpose' => 'booking',
            'method' => !empty($validated['simulated']) ? 'cash' : 'razorpay',
            'status' => 'paid',
            'amount' => $booking->amount,
            'transaction_reference' => $validated['razorpay_payment_id'] ?? 'SIM-'.strtoupper(Str::random(10)),
            'receipt_number' => 'RCPT-'.$booking->booking_reference,
            'meta' => [
                'razorpay_payment_id' => $validated['razorpay_payment_id'] ?? null,
                'razorpay_signature' => $validated['razorpay_signature'] ?? null,
                'simulated' => $validated['simulated'] ?? false,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment successful! Your session is confirmed.',
            'booking_reference' => $booking->booking_reference,
        ]);
    }
}
