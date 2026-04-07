<?php

namespace App\Http\Controllers\Counsellor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CounsellorAttendance;
use App\Models\CounsellorAvailability;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $upcomingSessions = Booking::query()
            ->where('counsellor_id', $userId)
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->take(10)
            ->get();

        $availabilities = CounsellorAvailability::query()
            ->where('counsellor_id', $userId)
            ->latest('available_date')
            ->take(12)
            ->get();

        $todayAttendance = CounsellorAttendance::query()
            ->where('counsellor_id', $userId)
            ->whereDate('attendance_date', today())
            ->first();

        return view('counsellor.dashboard', compact('upcomingSessions', 'availabilities', 'todayAttendance'));
    }

    public function storeAvailability(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'available_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'is_available' => ['required', 'boolean'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        CounsellorAvailability::query()->create([
            ...$validated,
            'counsellor_id' => auth()->id(),
            'source' => 'self',
        ]);

        return back()->with('status', 'Availability updated.');
    }

    public function storeAttendance(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:present,absent'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        CounsellorAttendance::query()->updateOrCreate(
            [
                'counsellor_id' => auth()->id(),
                'attendance_date' => today()->toDateString(),
            ],
            $validated
        );

        return back()->with('status', 'Attendance saved.');
    }
}
