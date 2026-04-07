<section class="pf-container mt-14">
    <div class="mb-6 flex items-end justify-between gap-4">
        <div>
            <span class="pf-badge">Training</span>
            <h2 class="pf-section-title mt-3">Professional development programmes</h2>
        </div>
        <a href="{{ route('training.index') }}" class="pf-btn-secondary hidden md:inline-flex">View All Programmes</a>
    </div>
    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse($trainingProgrammes as $programme)
            <a href="{{ route('training.show', $programme) }}" class="pf-card block p-5 transition hover:-translate-y-0.5">
                <p class="pf-badge">{{ $programme->category }}</p>
                <p class="mt-3 text-xl font-bold">{{ $programme->title }}</p>
                <p class="mt-3 text-sm text-[color:var(--pf-muted)]">
                    Registration ₹{{ number_format((float) $programme->registration_fee, 0) }} · Balance ₹{{ number_format((float) $programme->balance_fee, 0) }}
                </p>
            </a>
        @empty
            <p class="text-sm text-[color:var(--pf-muted)]">No training programmes published yet.</p>
        @endforelse
    </div>
</section>
