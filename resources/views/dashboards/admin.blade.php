<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm border">
                    <p class="text-sm text-gray-500">Clients</p>
                    <p class="text-2xl font-bold">{{ $totalClients }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border">
                    <p class="text-sm text-gray-500">Counsellors</p>
                    <p class="text-2xl font-bold">{{ $totalCounsellors }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border">
                    <p class="text-sm text-gray-500">Total Bookings</p>
                    <p class="text-2xl font-bold">{{ $totalBookings }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.counsellors.index') }}" class="bg-white p-5 rounded-lg border hover:shadow-sm">
                    <p class="font-semibold">Manage Counsellors</p>
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="bg-white p-5 rounded-lg border hover:shadow-sm">
                    <p class="font-semibold">Manage Bookings</p>
                    <p class="text-sm text-gray-600 mt-1">Pending: {{ $pendingBookings }}</p>
                </a>
                <a href="{{ route('admin.training-programmes.index') }}" class="bg-white p-5 rounded-lg border hover:shadow-sm">
                    <p class="font-semibold">Training Programmes</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $trainingProgrammes }} programmes, {{ $trainingRegistrations }} registrations</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
