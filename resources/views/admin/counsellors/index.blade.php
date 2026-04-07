<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Counsellor Management</h2>
            <a href="{{ route('admin.counsellors.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Add Counsellor</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">{{ session('status') }}</div>
            @endif
            <div class="bg-white rounded-lg border overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Specializations</th>
                            <th class="px-4 py-3 text-left">Price</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($counsellors as $counsellor)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $counsellor->name }}</td>
                                <td class="px-4 py-3">{{ $counsellor->email }}</td>
                                <td class="px-4 py-3">{{ implode(', ', $counsellor->counsellorProfile->specializations ?? []) ?: '-' }}</td>
                                <td class="px-4 py-3">₹{{ number_format((float) optional($counsellor->counsellorProfile)->session_price, 2) }}</td>
                                <td class="px-4 py-3">{{ optional($counsellor->counsellorProfile)->is_active ? 'Active' : 'Inactive' }}</td>
                                <td class="px-4 py-3">
                                    <a class="text-indigo-600 font-semibold" href="{{ route('admin.counsellors.edit', $counsellor) }}">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No counsellors yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $counsellors->links() }}</div>
        </div>
    </div>
</x-app-layout>
