<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Edit Event - {{ $event->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($event->photo_path)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Photo</label>
                            <img src="{{ asset('storage/' . $event->photo_path) }}" 
                                 alt="{{ $event->name }}"
                                 class="w-64 h-64 object-cover rounded shadow">
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Name *</label>
                            <input type="text" name="name" value="{{ old('name', $event->name) }}" required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Event Date & Time *</label>
                                <input type="datetime-local" name="event_date" 
                                       value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Duration (minutes) *</label>
                                <input type="number" name="duration" value="{{ old('duration', $event->duration) }}" min="1" required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sport Type *</label>
                                <select name="sport_type_id" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Sport Type</option>
                                    @foreach($sportTypes as $type)
                                        <option value="{{ $type->id }}" 
                                            {{ old('sport_type_id', $event->sport_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Organizer *</label>
                                <select name="organizer_id" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Organizer</option>
                                    @foreach($organizers as $organizer)
                                        <option value="{{ $organizer->id }}" 
                                            {{ old('organizer_id', $event->organizer_id) == $organizer->id ? 'selected' : '' }}>
                                            {{ $organizer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="4"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Replace Event Photo (optional)</label>
                            <input type="file" name="photo" accept="image/*"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            <p class="text-sm text-gray-500 mt-1">Leave empty to keep current photo. Max size: 2MB</p>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                                Save Changes
                            </button>
                            <a href="{{ route('admin.events.index') }}" 
                               class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>