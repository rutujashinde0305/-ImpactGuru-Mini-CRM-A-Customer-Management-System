<!-- Partial table for AJAX search results -->
<table class="w-full text-sm">
    <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-300 dark:border-gray-600">
        <tr>
            <th class="px-6 py-3 text-left font-semibold">#</th>
            <th class="px-6 py-3 text-left font-semibold">Image</th>
            <th class="px-6 py-3 text-left font-semibold">Name</th>
            <th class="px-6 py-3 text-left font-semibold">Email</th>
            <th class="px-6 py-3 text-left font-semibold">Phone</th>
            <th class="px-6 py-3 text-center font-semibold">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($customers as $c)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-6 py-4">{{ $c->id }}</td>
                <td class="px-6 py-4">
                    @if($c->profile_image)
                        <img src="{{ asset('storage/' . $c->profile_image) }}" 
                             alt="{{ $c->name }}" 
                             class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-400 dark:bg-gray-600 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($c->name, 0, 1) }}
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 font-medium">{{ $c->name }}</td>
                <td class="px-6 py-4">{{ $c->email }}</td>
                <td class="px-6 py-4">{{ $c->phone }}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex gap-2 justify-center">
                        <a 
                            href="{{ route('customers.show', $c) }}" 
                            class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400"
                        >
                            View
                        </a>
                        <a 
                            href="{{ route('customers.edit', $c) }}" 
                            class="text-yellow-600 hover:text-yellow-800 dark:hover:text-yellow-400"
                        >
                            Edit
                        </a>
                        @if(auth()->user()->role === 'admin')
                            <form 
                                action="{{ route('customers.destroy', $c) }}" 
                                method="POST" 
                                class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this customer?');"
                            >
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="text-red-600 hover:text-red-800 dark:hover:text-red-400"
                                >
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                    No customers found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
