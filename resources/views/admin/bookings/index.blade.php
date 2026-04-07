<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Booking Management</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg border overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">Reference</th>
                            <th class="px-4 py-3 text-left">Client</th>
                            <th class="px-4 py-3 text-left">Counsellor</th>
                            <th class="px-4 py-3 text-left">Service</th>
                            <th class="px-4 py-3 text-left">Date & Time</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $booking->booking_reference }}</td>
                                <td class="px-4 py-3">{{ $booking->client->name }}</td>
                                <td class="px-4 py-3">{{ $booking->counsellor->name }}</td>
                                <td class="px-4 py-3">{{ str_replace('_', ' ', $booking->service_type) }}</td>
                                <td class="px-4 py-3">{{ $booking->scheduled_at->timezone(config('app.timezone'))->format('d M Y, h:i A') }}</td>
                                <td class="px-4 py-3">{{ ucfirst($booking->status) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No bookings found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $bookings->links() }}</div>
        </div>
    </div>
</x-app-layout>
