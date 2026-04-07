<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Counsellor Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">{{ session('status') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <form method="POST" action="{{ route('counsellor.attendance.store') }}" class="bg-white border rounded-lg p-5">
                    @csrf
                    <h3 class="font-semibold mb-3">Daily Attendance</h3>
                    <div class="space-y-3">
                        <select name="status" class="w-full rounded-md border-gray-300" required>
                            <option value="present" @selected(optional($todayAttendance)->status === 'present')>Present</option>
                            <option value="absent" @selected(optional($todayAttendance)->status === 'absent')>Absent</option>
                        </select>
                        <input type="text" name="note" value="{{ old('note', optional($todayAttendance)->note) }}" class="w-full rounded-md border-gray-300" placeholder="Optional note">
                        <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Save Attendance</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('counsellor.availability.store') }}" class="bg-white border rounded-lg p-5">
                    @csrf
                    <h3 class="font-semibold mb-3">Update Availability</h3>
                    <div class="space-y-3">
                        <input type="date" name="available_date" class="w-full rounded-md border-gray-300" required>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="time" name="start_time" class="rounded-md border-gray-300" required>
                            <input type="time" name="end_time" class="rounded-md border-gray-300" required>
                        </div>
                        <select name="is_available" class="w-full rounded-md border-gray-300">
                            <option value="1">Available</option>
                            <option value="0">Unavailable</option>
                        </select>
                        <input type="text" name="reason" class="w-full rounded-md border-gray-300" placeholder="Optional reason">
                        <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Save Availability</button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-lg border overflow-x-auto">
                <div class="p-4 border-b">
                    <h3 class="font-semibold">Upcoming Sessions</h3>
                </div>
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">Client</th>
                            <th class="px-4 py-3 text-left">Service</th>
                            <th class="px-4 py-3 text-left">Mode</th>
                            <th class="px-4 py-3 text-left">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingSessions as $session)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $session->client->name }}</td>
                                <td class="px-4 py-3">{{ str_replace('_', ' ', $session->service_type) }}</td>
                                <td class="px-4 py-3">{{ $session->session_mode ? str_replace('_', ' ', $session->session_mode) : '-' }}</td>
                                <td class="px-4 py-3">{{ $session->scheduled_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No upcoming sessions.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
