<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgramme;
use App\Models\TrainingRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request, TrainingProgramme $programme): RedirectResponse
    {
        $validated = $request->validate([
            'participant_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        TrainingRegistration::query()->create([
            'training_programme_id' => $programme->id,
            'user_id' => auth()->id(),
            ...$validated,
            'form_data' => ['notes' => $validated['notes'] ?? null],
            'status' => 'submitted',
            'payment_status' => 'pending',
        ]);

        return back()->with('status', 'Registration submitted. Admin will review and share payment link.');
    }
}
