<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TrainingProgramme;
use App\Models\TrainingRegistration;
use App\Models\User;
use App\Support\Roles;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboards.admin', [
            'totalClients' => User::query()->where('role', Roles::CLIENT)->count(),
            'totalCounsellors' => User::query()->where('role', Roles::COUNSELLOR)->count(),
            'totalBookings' => Booking::query()->count(),
            'pendingBookings' => Booking::query()->where('status', 'pending')->count(),
            'trainingProgrammes' => TrainingProgramme::query()->count(),
            'trainingRegistrations' => TrainingRegistration::query()->count(),
        ]);
    }
}
