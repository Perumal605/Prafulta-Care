<section id="specialists" class="pf-container mt-14">
    <div class="mb-6 flex items-end justify-between gap-4">
        <div>
            <span class="pf-badge">Specialists</span>
            <h2 class="pf-section-title mt-3">Meet our counsellors</h2>
            <p class="mt-2 text-sm text-[color:var(--pf-muted)]">Click on a specialist to book a session directly.</p>
        </div>
    </div>
    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse($counsellors as $profile)
            <article class="pf-card group overflow-hidden transition hover:-translate-y-1 hover:shadow-md" id="specialist-{{ $profile->user->id }}">
                <div class="h-1.5 w-full bg-gradient-to-r from-[color:var(--pf-brand)] to-teal-400"></div>
                <div class="p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-lg font-bold group-hover:text-[color:var(--pf-brand-dark)]">{{ $profile->user->name }}</p>
                            <p class="mt-1 text-sm text-[color:var(--pf-muted)]">{{ $profile->bio ?: 'Specialist profile coming soon.' }}</p>
                        </div>
                        <span class="pf-badge shrink-0">Available</span>
                    </div>
                    <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-[color:var(--pf-muted)]">Specializations</p>
                    <p class="mt-1 text-sm">{{ implode(', ', $profile->specializations ?? []) ?: 'General counselling' }}</p>
                    <div class="mt-4 flex items-center justify-between border-t border-[color:var(--pf-border)] pt-4">
                        <div>
                            <p class="text-xs text-[color:var(--pf-muted)]">{{ $profile->session_duration_minutes }} min session</p>
                            <p class="text-lg font-bold text-[color:var(--pf-brand-dark)]">₹{{ number_format((float) $profile->session_price, 0) }}</p>
                        </div>
                        <button
                            type="button"
                            onclick='openBookingModal({{ json_encode([
                                'counsellor_id' => $profile->user->id,
                                'name' => $profile->user->name,
                                'bio' => $profile->bio ?: 'Specialist profile coming soon.',
                                'specializations' => implode(', ', $profile->specializations ?? []) ?: 'General counselling',
                                'session_price' => (float) $profile->session_price,
                                'session_modes' => $profile->session_modes ?? ['video', 'call', 'in_person'],
                                'session_duration' => $profile->session_duration_minutes,
                            ]) }})'
                            class="inline-flex items-center gap-1.5 rounded-xl bg-[color:var(--pf-brand-soft)] px-4 py-2 text-sm font-bold text-[color:var(--pf-brand-dark)] transition group-hover:bg-[color:var(--pf-brand)] group-hover:text-white"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Show
                        </button>
                    </div>
                </div>
            </article>
        @empty
            <p class="text-sm text-[color:var(--pf-muted)]">No active counsellor profiles yet.</p>
        @endforelse
    </div>
</section>
