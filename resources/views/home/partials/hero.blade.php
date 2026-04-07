<section class="pf-container mt-8">
    <div class="pf-hero overflow-hidden rounded-3xl px-6 py-10 text-white md:px-10 md:py-14">
        <div class="grid items-center gap-10 md:grid-cols-2">
            <div class="pf-fade-up">
                <span class="pf-badge bg-white/15 text-white">Therapy + Psychiatry + Training</span>
                <h1 class="pf-title mt-4">Mental health care that feels deeply human.</h1>
                <p class="mt-4 max-w-xl text-sm text-cyan-50 md:text-base">
                    Book counselling online, manage therapy schedules, and enroll in outcome-oriented training programmes,
                    all in one seamless platform.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('client.bookings.create') }}" class="pf-btn-secondary border-0 bg-white text-slate-900">Book a Session</a>
                        <a href="{{ route('dashboard') }}" class="pf-btn-secondary border-white/30 bg-transparent text-white">Open Dashboard</a>
                    @else
                        <a href="#specialists" class="pf-btn-secondary border-0 bg-white text-slate-900">Book a Session</a>
                        <a href="{{ route('register') }}" class="pf-btn-secondary border-white/30 bg-transparent text-white">Create Account</a>
                    @endauth
                </div>
            </div>
            <div class="pf-fade-up-delay">
                <div class="pf-card border-white/25 bg-white/10 p-6 text-white backdrop-blur">
                    <p class="text-sm font-semibold text-cyan-100">Why families choose Prafulta</p>
                    <div class="mt-5 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-3xl font-extrabold">{{ $counsellors->count() }}+</p>
                            <p class="text-xs text-cyan-100">Active specialists</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold">{{ $trainingProgrammes->count() }}+</p>
                            <p class="text-xs text-cyan-100">Training tracks</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold">24x7</p>
                            <p class="text-xs text-cyan-100">Booking access</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold">1:1</p>
                            <p class="text-xs text-cyan-100">Personal care plans</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
