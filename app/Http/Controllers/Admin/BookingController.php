<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->with(['client', 'counsellor'])
            ->latest('scheduled_at')
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }
}
