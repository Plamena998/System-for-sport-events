<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ⚽ Admin - Sport Types Management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6">
                <a href="{{ route('admin.sport_types.create') }}" 
                   class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 inline-block">
                    ➕ Add New Sport Type
                </a>
            </div>

            <!-- Search -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="flex gap-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search sport types..."
                               class="flex-1 border-gray-300 rounded-md shadow-sm">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sport Types Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="border p-3 text-left">Name</th>
                                    <th class="border p-3 text-left">Description</th>
                                    <th class="border p-3 text-left">Events Count</th>
                                    <th class="border p-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sportTypes as $type)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-3 font-semibold">{{ $type->name }}</td>
                                        <td class="border p-3">{{ $type->description ?? '—' }}</td>
                                        <td class="border p-3">{{ $type->events_count }} events</td>
                                        <td class="border p-3">
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.sport_types.edit', $type) }}" 
                                                   class="text-blue-600 hover:underline">Edit</a>
                                                
                                                @if($type->events_count == 0)
                                                    <form method="POST" action="{{ route('admin.sport_types.destroy', $type) }}"
                                                          onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400">Cannot delete</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border p-6 text-center text-gray-500">
                                            No sport types found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $sportTypes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>