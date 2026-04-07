<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Counsellor</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.counsellors.update', $counsellor) }}" class="bg-white border rounded-lg p-6 space-y-4">
                @csrf
                @method('PUT')
                @include('admin.counsellors._form', ['counsellor' => $counsellor])
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Update Counsellor</button>
            </form>
        </div>
    </div>
</x-app-layout>
