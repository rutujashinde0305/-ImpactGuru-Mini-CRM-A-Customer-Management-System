<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header with Actions -->
                    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center">
                        <div class="flex-1 flex gap-2">
                            <form method="GET" class="flex gap-2 flex-1">
                                <select 
                                    name="status" 
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    onchange="this.form.submit()"
                                >
                                    <option value="">All Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        
                        <div class="flex gap-2">
                            <a 
                                href="{{ route('orders.create') }}" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition"
                            >
                                + New Order
                            </a>
                            <a 
                                href="{{ route('orders.export.csv') }}" 
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition"
                            >
                                Export CSV
                            </a>
                            <a 
                                href="{{ route('orders.export.pdf') }}" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition"
                            >
                                Export PDF
                            </a>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-300 dark:border-gray-600">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold">#</th>
                                    <th class="px-6 py-3 text-left font-semibold">Order Number</th>
                                    <th class="px-6 py-3 text-left font-semibold">Customer</th>
                                    <th class="px-6 py-3 text-right font-semibold">Amount</th>
                                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                                    <th class="px-6 py-3 text-left font-semibold">Date</th>
                                    <th class="px-6 py-3 text-center font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4">{{ $order->id }}</td>
                                        <td class="px-6 py-4 font-medium">{{ $order->order_number }}</td>
                                        <td class="px-6 py-4">
                                            @if($order->customer)
                                                <a href="{{ route('customers.show', $order->customer) }}" class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400">
                                                    {{ $order->customer->name }}
                                                </a>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400 italic">Customer deleted</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right font-medium">
                                            ${{ number_format($order->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4">
                                                <x-status-badge :status="$order->status" />
                                        </td>
                                        <td class="px-6 py-4">{{ optional($order->order_date)->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex gap-2 justify-center">
                                                <a 
                                                    href="{{ route('orders.show', $order) }}" 
                                                    class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400"
                                                >
                                                    View
                                                </a>
                                                <a 
                                                    href="{{ route('orders.edit', $order) }}" 
                                                    class="text-yellow-600 hover:text-yellow-800 dark:hover:text-yellow-400"
                                                >
                                                    Edit
                                                </a>
                                                @if(auth()->user()->role === 'admin')
                                                    <form 
                                                        action="{{ route('orders.destroy', $order) }}" 
                                                        method="POST" 
                                                        class="inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this order?');"
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
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            No orders found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
