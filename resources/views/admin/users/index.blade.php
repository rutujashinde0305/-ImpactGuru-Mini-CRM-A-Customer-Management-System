<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Users</h2>
            <a href="{{ route('users.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">+ New User</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 text-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-gray-300">Manage users in the system</div>
                        <div>
                            <a href="{{ route('users.create') }}" class="px-3 py-2 bg-green-600 text-white rounded">+ New User</a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-600 text-white rounded">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-300">
                                <tr>
                                    <th class="px-6 py-3 text-left font-medium">#</th>
                                    <th class="px-6 py-3 text-left font-medium">Name</th>
                                    <th class="px-6 py-3 text-left font-medium">Email</th>
                                    <th class="px-6 py-3 text-left font-medium">Role</th>
                                    <th class="px-6 py-3 text-center font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-800">
                                        <td class="px-6 py-4">{{ $user->id }}</td>
                                        <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($user->role) }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('users.edit', $user) }}" class="inline-block px-3 py-1 text-sm bg-yellow-500 text-white rounded mr-2">Edit</a>

                                            @if($user->role !== 'admin')
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="inline-block px-3 py-1 text-sm bg-red-600 text-white rounded">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">No users found.</td>
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
