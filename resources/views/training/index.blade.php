<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Training Programmes | Prafulta</title>
    <meta name="description" content="Enroll in structured training programmes for parents, teachers, counsellors, and schools. Guided modules with staged payment options.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="pf-glass-nav">
        <div class="pf-container flex items-center justify-between py-4">
            <a href="{{ route('home') }}" class="text-lg font-extrabold tracking-tight">Prafulta Care</a>
            <div class="hidden items-center gap-6 text-sm font-semibold md:flex">
                <a href="{{ route('home') }}#services" class="text-[color:var(--pf-muted)] hover:text-[color:var(--pf-text)]">Services</a>
                <a href="{{ route('home') }}#specialists" class="text-[color:var(--pf-muted)] hover:text-[color:var(--pf-text)]">Specialists</a>
                <a href="{{ route('training.index') }}" class="text-[color:var(--pf-text)]">Training</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="pf-btn-primary px-4 py-2">Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="pf-btn-primary px-4 py-2">Get Started</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="pb-20">
        {{-- Hero banner --}}
        <section class="pf-container mt-8">
            <div class="pf-hero overflow-hidden rounded-3xl px-6 py-10 text-white md:px-10 md:py-14">
                <div class="pf-fade-up">
                    <span class="pf-badge bg-white/20 text-white">Programmes</span>
                    <h1 class="pf-title mt-4">Build practical skills with guided training tracks.</h1>
                    <p class="mt-3 max-w-2xl text-sm text-cyan-50 md:text-base">
                        Parents, teachers, counsellors, and school leaders can enroll in structured programmes
                        with module-wise progression and staged payment flow.
                    </p>
                    <div class="mt-6 flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2 rounded-full bg-white/15 px-3 py-1.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            {{ $programmes->total() }} Programmes
                        </div>
                        <div class="flex items-center gap-2 rounded-full bg-white/15 px-3 py-1.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $categories->count() }} Categories
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Category filter pills --}}
        <section class="pf-container mt-8">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('training.index') }}"
                   class="rounded-full border px-4 py-2 text-sm font-semibold transition hover:-translate-y-0.5
                   {{ !request('category') ? 'border-[color:var(--pf-brand)] bg-[color:var(--pf-brand-soft)] text-[color:var(--pf-brand-dark)]' : 'border-[color:var(--pf-border)] bg-white text-[color:var(--pf-muted)] hover:border-[color:var(--pf-brand)]' }}">
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('training.index', ['category' => $cat]) }}"
                       class="rounded-full border px-4 py-2 text-sm font-semibold transition hover:-translate-y-0.5
                       {{ request('category') === $cat ? 'border-[color:var(--pf-brand)] bg-[color:var(--pf-brand-soft)] text-[color:var(--pf-brand-dark)]' : 'border-[color:var(--pf-border)] bg-white text-[color:var(--pf-muted)] hover:border-[color:var(--pf-brand)]' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Results count --}}
        <section class="pf-container mt-4">
            <p class="text-sm text-[color:var(--pf-muted)]">
                Showing {{ $programmes->firstItem() ?? 0 }}–{{ $programmes->lastItem() ?? 0 }} of {{ $programmes->total() }} programmes
                @if(request('category'))
                    in <strong class="text-[color:var(--pf-text)]">{{ request('category') }}</strong>
                @endif
            </p>
        </section>

        {{-- Programme cards grid --}}
        <section class="pf-container mt-6">
            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @forelse($programmes as $programme)
                    <a href="{{ route('training.show', $programme) }}" class="pf-card group flex h-full flex-col overflow-hidden transition hover:-translate-y-1 hover:shadow-md" id="programme-{{ $programme->id }}">
                        {{-- Colour accent bar --}}
                        <div class="h-1.5 w-full bg-gradient-to-r from-[color:var(--pf-brand)] to-teal-400"></div>

                        <div class="flex h-full flex-col p-5">
                            {{-- Top row: category + modules count --}}
                            <div class="flex items-center justify-between">
                                <span class="pf-badge max-w-[70%] truncate">{{ $programme->category }}</span>
                                @if(!empty($programme->modules))
                                    <span class="shrink-0 text-xs font-semibold text-[color:var(--pf-muted)]">
                                        {{ count($programme->modules) }} {{ Str::plural('module', count($programme->modules)) }}
                                    </span>
                                @endif
                            </div>

                            {{-- Title --}}
                            <h3 class="mt-3 min-h-[3.5rem] text-lg font-bold leading-snug group-hover:text-[color:var(--pf-brand-dark)]">
                                {{ $programme->title }}
                            </h3>

                            {{-- Description --}}
                            <p class="mt-2 min-h-[3.2rem] line-clamp-2 text-sm text-[color:var(--pf-muted)]">
                                {{ $programme->description ?: 'Focused programme with practical modules and follow-up support.' }}
                            </p>

                            {{-- Meta chips: location + dates --}}
                            <div class="mt-4 grid min-h-[4.5rem] grid-cols-2 gap-3">
                                <div class="flex items-start gap-2 text-xs text-[color:var(--pf-muted)]">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="line-clamp-2">{{ $programme->location ?: 'Online' }}</span>
                                </div>
                                <div class="flex items-start gap-2 text-xs text-[color:var(--pf-muted)]">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $programme->start_date?->format('d M') ?: 'TBA' }} – {{ $programme->end_date?->format('d M Y') ?: 'TBA' }}</span>
                                </div>
                            </div>

                            {{-- Price footer --}}
                            <div class="mt-auto flex items-center justify-between border-t border-[color:var(--pf-border)] pt-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--pf-muted)]">From</p>
                                    <p class="text-xl font-bold text-[color:var(--pf-brand-dark)]">₹{{ number_format((float) $programme->registration_fee, 0) }}</p>
                                </div>
                                <span class="inline-flex items-center gap-1 rounded-xl bg-[color:var(--pf-brand-soft)] px-3 py-1.5 text-xs font-bold text-[color:var(--pf-brand-dark)] transition group-hover:bg-[color:var(--pf-brand)] group-hover:text-white">
                                    View Details
                                    <svg class="h-3.5 w-3.5 transition group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <svg class="mx-auto h-12 w-12 text-[color:var(--pf-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/></svg>
                        <p class="mt-3 text-sm font-semibold text-[color:var(--pf-muted)]">No programmes found
                            @if(request('category'))
                                in "{{ request('category') }}"
                            @endif
                        </p>
                        @if(request('category'))
                            <a href="{{ route('training.index') }}" class="mt-3 inline-block text-sm font-semibold text-[color:var(--pf-brand-dark)] hover:underline">View all programmes →</a>
                        @endif
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($programmes->hasPages())
                @php
                    $currentPage = $programmes->currentPage();
                    $lastPage = $programmes->lastPage();
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);
                @endphp

                <div class="mt-10 rounded-2xl border border-[color:var(--pf-border)] bg-white/90 p-4 shadow-sm backdrop-blur md:p-5">
                    <div class="flex flex-col items-center justify-between gap-3 md:flex-row">
                        <p class="text-sm font-semibold text-[color:var(--pf-muted)]">
                            Page {{ $currentPage }} of {{ $lastPage }}
                        </p>

                        <nav class="inline-flex items-center gap-2" aria-label="Pagination">
                            @if($programmes->onFirstPage())
                                <span class="inline-flex h-10 items-center gap-2 rounded-xl border border-[color:var(--pf-border)] px-4 text-sm font-semibold text-[color:var(--pf-muted)]/50">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    Previous
                                </span>
                            @else
                                <a href="{{ $programmes->previousPageUrl() }}" class="inline-flex h-10 items-center gap-2 rounded-xl border border-[color:var(--pf-border)] bg-white px-4 text-sm font-semibold text-[color:var(--pf-text)] transition hover:-translate-y-0.5 hover:border-[color:var(--pf-brand)] hover:bg-[color:var(--pf-brand-soft)]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    Previous
                                </a>
                            @endif

                            <div class="hidden items-center gap-2 sm:inline-flex">
                                @if($startPage > 1)
                                    <a href="{{ $programmes->url(1) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[color:var(--pf-border)] bg-white text-sm font-semibold text-[color:var(--pf-text)] transition hover:border-[color:var(--pf-brand)] hover:bg-[color:var(--pf-brand-soft)]">1</a>
                                    @if($startPage > 2)
                                        <span class="px-1 text-sm font-semibold text-[color:var(--pf-muted)]">...</span>
                                    @endif
                                @endif

                                @for($page = $startPage; $page <= $endPage; $page++)
                                    @if($page === $currentPage)
                                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[color:var(--pf-brand-dark)] text-sm font-bold text-white shadow-sm">{{ $page }}</span>
                                    @else
                                        <a href="{{ $programmes->url($page) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[color:var(--pf-border)] bg-white text-sm font-semibold text-[color:var(--pf-text)] transition hover:border-[color:var(--pf-brand)] hover:bg-[color:var(--pf-brand-soft)]">{{ $page }}</a>
                                    @endif
                                @endfor

                                @if($endPage < $lastPage)
                                    @if($endPage < $lastPage - 1)
                                        <span class="px-1 text-sm font-semibold text-[color:var(--pf-muted)]">...</span>
                                    @endif
                                    <a href="{{ $programmes->url($lastPage) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[color:var(--pf-border)] bg-white text-sm font-semibold text-[color:var(--pf-text)] transition hover:border-[color:var(--pf-brand)] hover:bg-[color:var(--pf-brand-soft)]">{{ $lastPage }}</a>
                                @endif
                            </div>

                            @if($programmes->hasMorePages())
                                <a href="{{ $programmes->nextPageUrl() }}" class="inline-flex h-10 items-center gap-2 rounded-xl border border-[color:var(--pf-border)] bg-white px-4 text-sm font-semibold text-[color:var(--pf-text)] transition hover:-translate-y-0.5 hover:border-[color:var(--pf-brand)] hover:bg-[color:var(--pf-brand-soft)]">
                                    Next
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @else
                                <span class="inline-flex h-10 items-center gap-2 rounded-xl border border-[color:var(--pf-border)] px-4 text-sm font-semibold text-[color:var(--pf-muted)]/50">
                                    Next
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            @endif
                        </nav>
                    </div>

                    <div class="mt-3 text-center sm:hidden">
                        <span class="inline-flex items-center rounded-full bg-[color:var(--pf-brand-soft)] px-3 py-1 text-xs font-bold text-[color:var(--pf-brand-dark)]">
                            Page {{ $currentPage }}
                        </span>
                    </div>
                </div>
            @endif
        </section>

        {{-- Bottom CTA --}}
        <section class="pf-container mt-14">
            <div class="pf-card flex flex-col items-start justify-between gap-5 p-6 md:flex-row md:items-center">
                <div>
                    <h3 class="text-2xl">Can't find the right programme?</h3>
                    <p class="mt-2 text-sm text-[color:var(--pf-muted)]">
                        Create your free account and we'll notify you when new programmes are published in your area of interest.
                    </p>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="pf-btn-primary shrink-0">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="pf-btn-primary shrink-0">Create Free Account</a>
                @endauth
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-[color:var(--pf-border)] py-8">
        <div class="pf-container flex flex-col items-center justify-between gap-4 text-sm text-[color:var(--pf-muted)] md:flex-row">
            <p>&copy; {{ date('Y') }} Prafulta Care. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="{{ route('home') }}" class="hover:text-[color:var(--pf-text)]">Home</a>
                <a href="{{ route('training.index') }}" class="hover:text-[color:var(--pf-text)]">Training</a>
            </div>
        </div>
    </footer>
</body>
</html>
