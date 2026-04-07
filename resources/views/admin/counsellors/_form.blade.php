@php
    $editing = isset($counsellor);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('name', $counsellor->name ?? '') }}" required>
        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('email', $counsellor->email ?? '') }}" @disabled($editing) required>
        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Phone</label>
        <input type="text" name="phone" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('phone', $counsellor->phone ?? '') }}">
    </div>
    @if(! $editing)
        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" class="mt-1 w-full rounded-md border-gray-300" required>
        </div>
    @endif
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Bio</label>
        <textarea name="bio" class="mt-1 w-full rounded-md border-gray-300" rows="3">{{ old('bio', $counsellor->counsellorProfile->bio ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Specializations (comma separated)</label>
        <input type="text" name="specializations" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('specializations', isset($counsellor) ? implode(', ', $counsellor->counsellorProfile->specializations ?? []) : '') }}">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Session Modes</label>
        @php
            $selectedModes = old('session_modes', $counsellor->counsellorProfile->session_modes ?? ['video', 'call', 'in_person']);
        @endphp
        <div class="mt-2 space-x-4">
            @foreach(['video' => 'Video', 'call' => 'Call', 'in_person' => 'In-person'] as $mode => $label)
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="session_modes[]" value="{{ $mode }}" @checked(in_array($mode, $selectedModes, true))>
                    <span>{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Session Duration (minutes)</label>
        <input type="number" name="session_duration_minutes" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('session_duration_minutes', $counsellor->counsellorProfile->session_duration_minutes ?? 60) }}" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Session Price</label>
        <input type="number" step="0.01" name="session_price" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('session_price', $counsellor->counsellorProfile->session_price ?? 0) }}" required>
    </div>
    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $counsellor->counsellorProfile->is_active ?? true))>
            <span>Active</span>
        </label>
    </div>
</div>
