<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏆 Sports Events
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Search Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('events.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Date</label>
                            <input type="date" name="event_date" value="{{ request('event_date') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Organizer</label>
                            <select name="organizer_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Organizers</option>
                                @foreach($organizers as $organizer)
                                    <option value="{{ $organizer->id }}" 
                                        {{ request('organizer_id') == $organizer->id ? 'selected' : '' }}>
                                        {{ $organizer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sport Type</label>
                            <select name="sport_type_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Sports</option>
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
                                🔍 Search
                            </button>
                        </div>
                    </form>

                    @if(request()->hasAny(['event_date', 'organizer_id', 'sport_type_id']))
                        <div class="mt-4">
                            <a href="{{ route('events.index') }}" class="text-sm text-blue-600 hover:underline">
                                ✖ Clear filters
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if($event->photo_path)
                            <img src="{{ asset('storage/' . $event->photo_path) }}" 
                                 alt="{{ $event->name }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                <span class="text-white text-6xl">🏆</span>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->name }}</h3>
                            
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <span class="font-semibold w-24">📅 Date:</span>
                                    <span>{{ $event->event_date->format('d M Y, H:i') }}</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <span class="font-semibold w-24">⏱️ Duration:</span>
                                    <span>{{ $event->duration }} minutes</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <span class="font-semibold w-24">⚽ Sport:</span>
                                    <span>{{ $event->sportType->name }}</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <span class="font-semibold w-24">👥 Organizer:</span>
                                    <span>{{ $event->organizer->name }}</span>
                                </div>
                            </div>

                            @if($event->description)
                                <p class="mt-4 text-sm text-gray-700">
                                    {{ Str::limit($event->description, 100) }}
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                        <span class="text-6xl">🔍</span>
                        <p class="mt-4 text-gray-600">No events found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>