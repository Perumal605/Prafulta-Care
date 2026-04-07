<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgramme;
use Illuminate\View\View;

class ProgrammeController extends Controller
{
    public function index(): View
    {
        $categories = TrainingProgramme::query()
            ->where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        $programmes = TrainingProgramme::query()
            ->where('is_active', true)
            ->when(request('category'), fn ($q, $cat) => $q->where('category', $cat))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('training.index', compact('programmes', 'categories'));
    }

    public function show(TrainingProgramme $programme): View
    {
        return view('training.show', compact('programme'));
    }
}
