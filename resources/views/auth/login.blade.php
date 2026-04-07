<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-3xl">Welcome back</h2>
        <p class="mt-2 text-sm text-[color:var(--pf-muted)]">Login to manage your sessions, profile, and training registrations.</p>
    </div>

    <x-auth-session-status class="mb-4 rounded-xl border border-green-200 bg-green-50 px-3 py-2 text-sm text-green-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-xl border-[color:var(--pf-border)]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full rounded-xl border-[color:var(--pf-border)]"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center text-sm">
                <input id="remember_me" type="checkbox" class="rounded border-[color:var(--pf-border)] text-teal-700 focus:ring-teal-600" name="remember">
                <span class="ms-2 text-[color:var(--pf-muted)]">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-teal-700 hover:text-teal-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="pf-btn-primary w-full">{{ __('Log in') }}</button>
        </div>

        <p class="text-center text-sm text-[color:var(--pf-muted)]">
            New here?
            <a href="{{ route('register') }}" class="font-semibold text-teal-700 hover:text-teal-900">Create an account</a>
        </p>
    </form>
</x-guest-layout>
