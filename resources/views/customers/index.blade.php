<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Customers') }}
            </h2>
            @if(auth()->user()->role === 'admin')
                <a 
                    href="{{ route('customers.trashed') }}" 
                    class="text-sm px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded transition"
                >
                    View Deleted
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header with Actions -->
                    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center">
                        <div class="flex-1">
                            <input 
                                type="text" 
                                id="searchInput"
                                placeholder="Search customers by name, email, or phone..." 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <small class="text-gray-500 dark:text-gray-400 mt-1 block">
                                Search is instant - no need to press enter
                            </small>
                        </div>
                        
                        <div class="flex gap-2">
                            <a 
                                href="{{ route('customers.create') }}" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition"
                            >
                                + Add Customer
                            </a>
                            <a 
                                href="{{ route('customers.export.csv') }}" 
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition"
                            >
                                Export CSV
                            </a>
                            <a 
                                href="{{ route('customers.export.pdf') }}" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition"
                            >
                                Export PDF
                            </a>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto" id="tableContainer">
                        @include('customers._table', ['customers' => $customers])
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $customers->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- AJAX Search Script -->
    <script>
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            const searchTerm = this.value;
            
            searchTimeout = setTimeout(() => {
                if (searchTerm.trim() === '') {
                    // Reset to original page
                    location.reload();
                    return;
                }

                fetch(`{{ route('customers.search') }}?search=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('tableContainer').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                    });
            }, 300); // Wait 300ms after user stops typing
        });
    </script>
</x-app-layout>
