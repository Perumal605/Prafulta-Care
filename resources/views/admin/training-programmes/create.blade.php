<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Training Programme</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.training-programmes.store') }}" class="bg-white rounded-lg border p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('title') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <input type="text" name="category" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('category') }}" placeholder="Parents / Teachers / International" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4" class="mt-1 w-full rounded-md border-gray-300">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('location') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Modules (comma separated)</label>
                        <input type="text" name="modules" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('modules') }}" placeholder="Module 1, Module 2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('start_date') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('end_date') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Registration Fee</label>
                        <input type="number" step="0.01" name="registration_fee" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('registration_fee', 0) }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Balance Fee</label>
                        <input type="number" step="0.01" name="balance_fee" class="mt-1 w-full rounded-md border-gray-300" value="{{ old('balance_fee', 0) }}" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" checked>
                            <span>Active</span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Create Programme</button>
            </form>
        </div>
    </div>
</x-app-layout>
