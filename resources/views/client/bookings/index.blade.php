<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-2xl">My Bookings</h2>
                <p class="mt-1 text-sm text-[color:var(--pf-muted)]">Track upcoming sessions, payment status, and past consultations.</p>
            </div>
            <a href="{{ route('client.bookings.create') }}" class="pf-btn-primary px-4 py-2">New Booking</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">{{ session('status') }}</div>
            @endif

            <div class="mb-5 grid gap-4 md:grid-cols-3">
                <div class="pf-card p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--pf-muted)]">Total Bookings</p>
                    <p class="mt-2 text-3xl font-extrabold">{{ $bookings->total() }}</p>
                </div>
                <div class="pf-card p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--pf-muted)]">Upcoming</p>
                    <p class="mt-2 text-3xl font-extrabold">{{ $bookings->where('scheduled_at', '>=', now())->count() }}</p>
                </div>
                <div class="pf-card p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--pf-muted)]">Paid Sessions</p>
                    <p class="mt-2 text-3xl font-extrabold">{{ $bookings->where('payment_status', 'paid')->count() }}</p>
                </div>
            </div>

            <div class="pf-card overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-[color:var(--pf-brand-soft)]/35">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Reference</th>
                            <th class="px-4 py-3 text-left font-semibold">Counsellor</th>
                            <th class="px-4 py-3 text-left font-semibold">Service</th>
                            <th class="px-4 py-3 text-left font-semibold">Schedule</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                            <th class="px-4 py-3 text-left font-semibold">Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr class="border-t border-[color:var(--pf-border)]">
                                <td class="px-4 py-3 font-semibold">{{ $booking->booking_reference }}</td>
                                <td class="px-4 py-3">{{ $booking->counsellor->name }}</td>
                                <td class="px-4 py-3 capitalize">{{ str_replace('_', ' ', $booking->service_type) }}</td>
                                <td class="px-4 py-3">{{ $booking->scheduled_at->timezone(config('app.timezone'))->format('d M Y, h:i A') }}</td>
                                <td class="px-4 py-3">
                                    <span class="pf-badge">{{ ucfirst($booking->status) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="pf-badge">{{ ucfirst($booking->payment_status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-[color:var(--pf-muted)]">
                                    No bookings found.
                                    <a href="{{ route('client.bookings.create') }}" class="ml-2 font-semibold text-teal-700 hover:text-teal-900">Create your first booking</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-5">{{ $bookings->links() }}</div>
        </div>
    </div>
</x-app-layout>
