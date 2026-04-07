<?php

namespace App\Http\Controllers;

use App\Support\Roles;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $user = request()->user();

        return match ($user->role) {
            Roles::ADMIN, Roles::TRAINING_MANAGER => redirect()->to('/admin'),
            Roles::COUNSELLOR => redirect()->route('counsellor.dashboard'),
            default => redirect()->route('client.bookings.index'),
        };
    }
}
