<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Prafulta Care') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-2">
        <section class="relative hidden overflow-hidden bg-gradient-to-br from-teal-700 via-cyan-700 to-sky-900 p-10 text-white lg:flex">
            <div class="absolute -left-20 top-10 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-cyan-300/20 blur-2xl"></div>
            <div class="relative z-10 flex flex-col justify-between">
                <a href="{{ route('home') }}" class="text-lg font-extrabold tracking-tight">Prafulta Care</a>
                <div>
                    <span class="pf-badge bg-white/20 text-white">Mental Health Platform</span>
                    <h1 class="mt-5 text-4xl leading-tight">Support that meets you where you are.</h1>
                    <p class="mt-4 max-w-md text-sm text-cyan-50">
                        Book therapy, connect with specialists, and access trusted training tracks from one secure platform.
                    </p>
                    <div class="mt-8 grid grid-cols-2 gap-4">
                        <div class="rounded-2xl border border-white/25 bg-white/10 p-4">
                            <p class="text-2xl font-bold">1:1</p>
                            <p class="mt-1 text-xs text-cyan-100">Personal sessions</p>
                        </div>
                        <div class="rounded-2xl border border-white/25 bg-white/10 p-4">
                            <p class="text-2xl font-bold">24x7</p>
                            <p class="mt-1 text-xs text-cyan-100">Booking access</p>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-cyan-100">Safe, private, and clinically guided care.</p>
            </div>
        </section>

        <section class="flex items-center justify-center px-4 py-10 sm:px-6">
            <div class="w-full max-w-md">
                <div class="mb-6 text-center lg:hidden">
                    <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tight">Prafulta Care</a>
                    <p class="mt-2 text-sm text-[color:var(--pf-muted)]">Therapy and training support platform</p>
                </div>
                <div class="pf-card rounded-3xl p-6 shadow-lg sm:p-8">
                    {{ $slot }}
                </a>
            </div>
        </section>
    </div>
</body>
</html>
