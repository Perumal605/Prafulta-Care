<section class="pf-container mt-14">
    <div class="pf-card flex flex-col items-start justify-between gap-5 p-6 md:flex-row md:items-center">
        <div>
            <h3 class="text-2xl">Start your care journey with confidence.</h3>
            <p class="mt-2 text-sm text-[color:var(--pf-muted)]">Secure booking, transparent pricing, and expert-led support under one platform.</p>
        </div>
        @auth
            <a href="{{ route('dashboard') }}" class="pf-btn-primary">Go to Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="pf-btn-primary">Create Free Account</a>
        @endauth
    </div>
</section>
