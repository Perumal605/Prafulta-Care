<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgramme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainingProgrammeController extends Controller
{
    public function index(): View
    {
        $programmes = TrainingProgramme::query()->latest()->paginate(15);

        return view('admin.training-programmes.index', compact('programmes'));
    }

    public function create(): View
    {
        return view('admin.training-programmes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'modules' => ['nullable', 'string'],
            'registration_fee' => ['required', 'numeric', 'min:0'],
            'balance_fee' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        TrainingProgramme::query()->create([
            ...$validated,
            'modules' => isset($validated['modules'])
                ? array_filter(array_map('trim', explode(',', $validated['modules'])))
                : [],
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.training-programmes.index')
            ->with('status', 'Training programme created.');
    }
}
