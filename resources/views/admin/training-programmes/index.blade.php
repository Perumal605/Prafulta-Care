<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Training Programmes</h2>
            <a href="{{ route('admin.training-programmes.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Add Programme</a>
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
                            <th class="px-4 py-3 text-left">Title</th>
                            <th class="px-4 py-3 text-left">Category</th>
                            <th class="px-4 py-3 text-left">Registration Fee</th>
                            <th class="px-4 py-3 text-left">Balance Fee</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programmes as $programme)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $programme->title }}</td>
                                <td class="px-4 py-3">{{ $programme->category }}</td>
                                <td class="px-4 py-3">₹{{ number_format((float) $programme->registration_fee, 2) }}</td>
                                <td class="px-4 py-3">₹{{ number_format((float) $programme->balance_fee, 2) }}</td>
                                <td class="px-4 py-3">{{ $programme->is_active ? 'Active' : 'Inactive' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No programmes yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $programmes->links() }}</div>
        </div>
    </div>
</x-app-layout>
