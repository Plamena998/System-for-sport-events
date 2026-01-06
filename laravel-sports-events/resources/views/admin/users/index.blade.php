<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👤 Admin - Users Management
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
                <a href="{{ route('admin.users.create') }}" 
                   class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 inline-block">
                    ➕ Add New User
                </a>
            </div>

            <!-- Users Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="border p-3 text-left">Name</th>
                                    <th class="border p-3 text-left">Email</th>
                                    <th class="border p-3 text-left">Role</th>
                                    <th class="border p-3 text-left">Created At</th>
                                    <th class="border p-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-3 font-semibold">{{ $user->name }}</td>
                                        <td class="border p-3">{{ $user->email }}</td>
                                        <td class="border p-3">
                                            @if($user->is_admin)
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Admin</span>
                                            @else
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">User</span>
                                            @endif
                                        </td>
                                        <td class="border p-3">{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="border p-3">
                                            @if($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">You</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border p-6 text-center text-gray-500">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>