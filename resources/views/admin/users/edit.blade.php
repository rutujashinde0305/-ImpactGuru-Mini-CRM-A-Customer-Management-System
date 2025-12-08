<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit User</h2>
            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded">Back</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 text-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($errors->any())
                        <div class="mb-4 bg-red-600 text-white p-3 rounded">
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs text-gray-300 mb-2">Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded px-4 py-3 bg-white text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-xs text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded px-4 py-3 bg-white text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-xs text-gray-300 mb-2">Role</label>
                                <select name="role" class="w-full rounded px-4 py-3 bg-white text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs text-gray-300 mb-2">Password (leave blank to keep)</label>
                                <input type="password" name="password" class="w-full rounded px-4 py-3 bg-white text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-xs text-gray-300 mb-2">Profile Image</label>
                            @if($user->profile_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="w-20 h-20 rounded-full object-cover">
                                </div>
                            @endif
                            <input type="file" name="profile_image" accept="image/*" class="w-full">
                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded shadow">Update</button>
                            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded border border-gray-600">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
