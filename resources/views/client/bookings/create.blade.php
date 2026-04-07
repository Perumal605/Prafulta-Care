<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl">Book a Session</h2>
            <p class="mt-1 text-sm text-[color:var(--pf-muted)]">Choose your specialist, session mode, and preferred schedule.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-5">
                <form method="POST" action="{{ route('client.bookings.store') }}" class="pf-card space-y-4 p-6 lg:col-span-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-[color:var(--pf-muted)]">Counsellor</label>
                        <select name="counsellor_id" class="mt-1 w-full rounded-xl border-[color:var(--pf-border)]" required>
                            <option value="">Select counsellor</option>
                            @foreach($counsellors as $counsellor)
                                <option value="{{ $counsellor->id }}" @selected(old('counsellor_id') == $counsellor->id)>
                                    {{ $counsellor->name }} (₹{{ number_format((float) optional($counsellor->counsellorProfile)->session_price, 0) }})
                                </option>
                            @endforeach
                        </select>
                        @error('counsellor_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[color:var(--pf-muted)]">Service Type</label>
                        <select name="service_type" class="mt-1 w-full rounded-xl border-[color:var(--pf-border)]" required>
                            <option value="regular_counselling">Regular Counselling (Online Booking)</option>
                            <option value="occupational_therapy">Occupational Therapy (Admin Managed)</option>
                            <option value="remedial_therapy">Remedial Therapy (Admin Managed)</option>
                        </select>
                        @error('service_type') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[color:var(--pf-muted)]">Session Mode</label>
                        <select name="session_mode" class="mt-1 w-full rounded-xl border-[color:var(--pf-border)]">
                            <option value="">Select mode</option>
                            <option value="video">Video</option>
                            <option value="call">Call</option>
                            <option value="in_person">In-person</option>
                        </select>
                        @error('session_mode') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[color:var(--pf-muted)]">Preferred Date & Time</label>
                        <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}" class="mt-1 w-full rounded-xl border-[color:var(--pf-border)]" required />
                        @error('scheduled_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="pf-btn-primary w-full">Submit Booking Request</button>
                    </div>
                </form>

                <aside class="pf-card p-6 lg:col-span-2">
                    <h3 class="text-2xl">Booking Guide</h3>
                    <ul class="mt-4 space-y-3 text-sm text-[color:var(--pf-muted)]">
                        <li class="rounded-xl border border-[color:var(--pf-border)] p-3">
                            <span class="font-semibold text-[color:var(--pf-text)]">Regular Counselling</span><br>
                            Instant online booking for video/call/in-person.
                        </li>
                        <li class="rounded-xl border border-[color:var(--pf-border)] p-3">
                            <span class="font-semibold text-[color:var(--pf-text)]">Occupational / Remedial</span><br>
                            Admin team may coordinate offline schedule confirmation.
                        </li>
                        <li class="rounded-xl border border-[color:var(--pf-border)] p-3">
                            <span class="font-semibold text-[color:var(--pf-text)]">Payments</span><br>
                            You can view payment and booking status from “My Bookings”.
                        </li>
                    </ul>
                    <a href="{{ route('client.bookings.index') }}" class="pf-btn-secondary mt-5 w-full">Back to My Bookings</a>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
