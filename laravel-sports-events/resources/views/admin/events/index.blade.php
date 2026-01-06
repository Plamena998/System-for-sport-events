<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏆 Admin - Events Management
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
                <a href="{{ route('admin.events.create') }}" 
                   class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 inline-block">
                    ➕ Add New Event
                </a>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Search Name</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Search events..."
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Event Date</label>
                            <input type="date" name="event_date" value="{{ request('event_date') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Organizer</label>
                            <select name="organizer_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All</option>
                                @foreach($organizers as $organizer)
                                    <option value="{{ $organizer->id }}" 
                                        {{ request('organizer_id') == $organizer->id ? 'selected' : '' }}>
                                        {{ $organizer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Sport Type</label>
                            <select name="sport_type_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All</option>
                                @foreach($sportTypes as $type)
                                    <option value="{{ $type->id }}" 
                                        {{ request('sport_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Events Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @php
                        $direction = request('direction') === 'asc' ? 'desc' : 'asc';
                    @endphp

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="border p-3 text-left">Photo</th>
                                    <th class="border p-3 text-left">
                                        <a href="?sort=name&direction={{ $direction }}&{{ http_build_query(request()->except(['sort', 'direction'])) }}">
                                            Name
                                            @if(request('sort') === 'name')
                                                {{ request('direction') === 'asc' ? '▲' : '▼' }}
                                            @endif
                                        </a>
                                    </th>
                                    <th class="border p-3 text-left">
                                        <a href="?sort=event_date&direction={{ $direction }}&{{ http_build_query(request()->except(['sort', 'direction'])) }}">
                                            Event Date
                                            @if(request('sort') === 'event_date')
                                                {{ request('direction') === 'asc' ? '▲' : '▼' }}
                                            @endif
                                        </a>
                                    </th>
                                    <th class="border p-3 text-left">
                                        <a href="?sort=duration&direction={{ $direction }}&{{ http_build_query(request()->except(['sort', 'direction'])) }}">
                                            Duration
                                            @if(request('sort') === 'duration')
                                                {{ request('direction') === 'asc' ? '▲' : '▼' }}
                                            @endif
                                        </a>
                                    </th>
                                    <th class="border p-3 text-left">Sport Type</th>
                                    <th class="border p-3 text-left">Organizer</th>
                                    <th class="border p-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events as $event)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-3">
                                            @if($event->photo_path)
                                                <img src="{{ asset('storage/' . $event->photo_path) }}" 
                                                     alt="{{ $event->name }}"
                                                     class="w-16 h-16 object-cover rounded">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                    🏆
                                                </div>
                                            @endif
                                        </td>
                                        <td class="border p-3 font-semibold">{{ $event->name }}</td>
                                        <td class="border p-3">{{ $event->event_date->format('d M Y, H:i') }}</td>
                                        <td class="border p-3">{{ $event->duration }} min</td>
                                        <td class="border p-3">{{ $event->sportType->name }}</td>
                                        <td class="border p-3">{{ $event->organizer->name }}</td>
                                        <td class="border p-3">
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.events.edit', $event) }}" 
                                                   class="text-blue-600 hover:underline">Edit</a>
                                                
                                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}"
                                                      onsubmit="return confirm('Are you sure you want to delete this event?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="border p-6 text-center text-gray-500">
                                            No events found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>