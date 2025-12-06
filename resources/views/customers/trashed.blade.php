<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Deleted Customers') }}
            </h2>
            <a 
                href="{{ route('customers.index') }}" 
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
            >
                ← Back to Customers
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Information Box -->
                    <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            <strong>Note:</strong> These customers have been soft-deleted. You can restore them or permanently delete them.
                        </p>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-300 dark:border-gray-600">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold">#</th>
                                    <th class="px-6 py-3 text-left font-semibold">Name</th>
                                    <th class="px-6 py-3 text-left font-semibold">Email</th>
                                    <th class="px-6 py-3 text-left font-semibold">Phone</th>
                                    <th class="px-6 py-3 text-left font-semibold">Deleted</th>
                                    <th class="px-6 py-3 text-center font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($customers as $c)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4">{{ $c->id }}</td>
                                        <td class="px-6 py-4 font-medium">{{ $c->name }}</td>
                                        <td class="px-6 py-4">{{ $c->email }}</td>
                                        <td class="px-6 py-4">{{ $c->phone }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $c->deleted_at->format('M d, Y - H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex gap-2 justify-center">
                                                <!-- Restore Button -->
                                                <form 
                                                    action="{{ route('customers.restore', $c->id) }}" 
                                                    method="POST" 
                                                    class="inline"
                                                >
                                                    @csrf
                                                    @method('PATCH')
                                                    <button 
                                                        type="submit" 
                                                        class="text-green-600 hover:text-green-800 dark:hover:text-green-400 font-medium"
                                                        title="Restore customer"
                                                    >
                                                        Restore
                                                    </button>
                                                </form>

                                                <!-- Force Delete Button -->
                                                <form 
                                                    action="{{ route('customers.force-delete', $c->id) }}" 
                                                    method="POST" 
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure? This will permanently delete the customer and cannot be undone.');"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button 
                                                        type="submit" 
                                                        class="text-red-600 hover:text-red-800 dark:hover:text-red-400 font-medium"
                                                        title="Permanently delete customer"
                                                    >
                                                        Delete Permanently
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            No deleted customers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $customers->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
