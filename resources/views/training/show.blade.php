<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $programme->title }} | Prafulta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="pf-glass-nav">
        <div class="pf-container flex items-center justify-between py-4">
            <a href="{{ route('training.index') }}" class="text-lg font-extrabold tracking-tight">Training</a>
            @auth
                <a href="{{ route('dashboard') }}" class="pf-btn-primary px-4 py-2">Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="pf-btn-primary px-4 py-2">Get Started</a>
            @endauth
        </div>
    </header>

    <main class="pf-container py-10">
        @if(session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">{{ session('status') }}</div>
        @endif

        <div class="grid gap-6 lg:grid-cols-5">
            <section class="pf-card p-6 lg:col-span-3">
                <p class="pf-badge">{{ $programme->category }}</p>
                <h1 class="mt-3 text-3xl md:text-4xl">{{ $programme->title }}</h1>
                <p class="mt-4 text-sm text-[color:var(--pf-muted)]">{{ $programme->description ?: 'Programme description will be shared soon.' }}</p>

                <div class="mt-6 grid gap-3 text-sm md:grid-cols-2">
                    <div class="rounded-xl border border-[color:var(--pf-border)] bg-[color:var(--pf-brand-soft)]/40 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--pf-muted)]">Location</p>
                        <p class="mt-1 font-semibold">{{ $programme->location ?: 'TBA' }}</p>
                    </div>
                    <div class="rounded-xl border border-[color:var(--pf-border)] bg-[color:var(--pf-brand-soft)]/40 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--pf-muted)]">Schedule</p>
                        <p class="mt-1 font-semibold">{{ optional($programme->start_date)->format('d M Y') ?: 'TBA' }} - {{ optional($programme->end_date)->format('d M Y') ?: 'TBA' }}</p>
                    </div>
                    <div class="rounded-xl border border-[color:var(--pf-border)] p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--pf-muted)]">Registration Fee</p>
                        <p class="mt-1 text-xl font-bold">₹{{ number_format((float) $programme->registration_fee, 0) }}</p>
                    </div>
                    <div class="rounded-xl border border-[color:var(--pf-border)] p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--pf-muted)]">Balance Fee</p>
                        <p class="mt-1 text-xl font-bold">₹{{ number_format((float) $programme->balance_fee, 0) }}</p>
                    </div>
                </div>

                @if(!empty($programme->modules))
                    <div class="mt-6">
                        <p class="text-lg font-semibold">Modules Included</p>
                        <ul class="mt-2 list-disc list-inside text-sm text-[color:var(--pf-muted)]">
                        @foreach($programme->modules as $module)
                            <li>{{ $module }}</li>
                        @endforeach
                    </ul>
                    </div>
                @endif
            </section>

            @auth
                <form method="POST" action="{{ route('training.register', $programme) }}" class="pf-card space-y-4 p-6 lg:col-span-2">
                    @csrf
                    <h2 class="text-2xl">Register Now</h2>
                    <p class="text-sm text-[color:var(--pf-muted)]">Pay registration first, then complete balance payment after approval.</p>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-[color:var(--pf-muted)]">Name</label>
                            <input type="text" name="participant_name" value="{{ old('participant_name', auth()->user()->name) }}" class="mt-1 w-full rounded-xl border-[color:var(--pf-border)]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[color:var(--pf-muted)]">Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="mt-1 w-full rounded-xl border-[color:var(--pf-border)]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[color:var(--pf-muted)]">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="mt-1 w-full rounded-xl border-[color:var(--pf-border)]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[color:var(--pf-muted)]">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="mt-1 w-full rounded-xl border-[color:var(--pf-border)]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[color:var(--pf-muted)]">Notes (optional)</label>
                            <textarea name="notes" rows="3" class="mt-1 w-full rounded-xl border-[color:var(--pf-border)]">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    <button class="pf-btn-primary w-full">Submit Registration</button>
                </form>
            @else
                <aside class="pf-card p-6 lg:col-span-2">
                    <h2 class="text-2xl">Ready to join?</h2>
                    <p class="mt-2 text-sm text-[color:var(--pf-muted)]">Create an account to complete your registration with staged payment options.</p>
                    <a class="pf-btn-primary mt-5 w-full" href="{{ route('register') }}">Sign Up to Register</a>
                </aside>
            @endauth
        </div>
    </main>
</body>
</html>
