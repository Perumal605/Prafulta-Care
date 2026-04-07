<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounsellorProfile;
use App\Models\User;
use App\Support\Roles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CounsellorController extends Controller
{
    public function index(): View
    {
        $counsellors = User::query()
            ->where('role', Roles::COUNSELLOR)
            ->with('counsellorProfile')
            ->latest()
            ->paginate(12);

        return view('admin.counsellors.index', compact('counsellors'));
    }

    public function create(): View
    {
        return view('admin.counsellors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8'],
            'bio' => ['nullable', 'string'],
            'specializations' => ['nullable', 'string'],
            'session_modes' => ['nullable', 'array'],
            'session_modes.*' => ['in:video,call,in_person'],
            'session_duration_minutes' => ['required', 'integer', 'min:15', 'max:240'],
            'session_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => Roles::COUNSELLOR,
            'email_verified_at' => now(),
        ]);

        CounsellorProfile::query()->create([
            'user_id' => $user->id,
            'bio' => $validated['bio'] ?? null,
            'specializations' => isset($validated['specializations'])
                ? array_filter(array_map('trim', explode(',', $validated['specializations'])))
                : [],
            'session_modes' => $validated['session_modes'] ?? ['video', 'call', 'in_person'],
            'session_duration_minutes' => $validated['session_duration_minutes'],
            'session_price' => $validated['session_price'],
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.counsellors.index')
            ->with('status', 'Counsellor created successfully.');
    }

    public function edit(User $counsellor): View
    {
        abort_unless($counsellor->role === Roles::COUNSELLOR, 404);
        $counsellor->load('counsellorProfile');

        return view('admin.counsellors.edit', compact('counsellor'));
    }

    public function update(Request $request, User $counsellor): RedirectResponse
    {
        abort_unless($counsellor->role === Roles::COUNSELLOR, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'bio' => ['nullable', 'string'],
            'specializations' => ['nullable', 'string'],
            'session_modes' => ['nullable', 'array'],
            'session_modes.*' => ['in:video,call,in_person'],
            'session_duration_minutes' => ['required', 'integer', 'min:15', 'max:240'],
            'session_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $counsellor->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
        ]);

        $profile = $counsellor->counsellorProfile()->firstOrCreate(['user_id' => $counsellor->id]);
        $profile->update([
            'bio' => $validated['bio'] ?? null,
            'specializations' => isset($validated['specializations'])
                ? array_filter(array_map('trim', explode(',', $validated['specializations'])))
                : [],
            'session_modes' => $validated['session_modes'] ?? ['video', 'call', 'in_person'],
            'session_duration_minutes' => $validated['session_duration_minutes'],
            'session_price' => $validated['session_price'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.counsellors.index')
            ->with('status', 'Counsellor updated successfully.');
    }
}
