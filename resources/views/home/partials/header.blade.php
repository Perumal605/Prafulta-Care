<header class="pf-glass-nav">
    <div class="pf-container flex items-center justify-between py-4">
        <a href="{{ route('home') }}" class="text-lg font-extrabold tracking-tight">Prafulta Care</a>
        <div class="hidden items-center gap-6 text-sm font-semibold md:flex">
            <a href="#services" class="text-[color:var(--pf-muted)] hover:text-[color:var(--pf-text)]">Services</a>
            <a href="#specialists" class="text-[color:var(--pf-muted)] hover:text-[color:var(--pf-text)]">Specialists</a>
            <a href="{{ route('training.index') }}" class="text-[color:var(--pf-muted)] hover:text-[color:var(--pf-text)]">Training</a>
            @auth
                <a href="{{ route('dashboard') }}" class="pf-btn-primary px-4 py-2">Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="pf-btn-primary px-4 py-2">Get Started</a>
            @endauth
        </div>
    </div>
</header>
