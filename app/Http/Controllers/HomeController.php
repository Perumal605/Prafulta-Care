<?php

namespace App\Http\Controllers;

use App\Models\CounsellorProfile;
use App\Models\TrainingProgramme;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $counsellors = collect();
        if (Schema::hasTable('counsellor_profiles')) {
            $counsellors = CounsellorProfile::query()
                ->with('user')
                ->where('is_active', true)
                ->latest()
                ->take(6)
                ->get();
        }

        $trainingProgrammes = collect();
        if (Schema::hasTable('training_programmes')) {
            $trainingProgrammes = TrainingProgramme::query()
                ->where('is_active', true)
                ->latest()
                ->take(6)
                ->get();
        }

        return view('welcome', compact('counsellors', 'trainingProgrammes'));
    }
}
