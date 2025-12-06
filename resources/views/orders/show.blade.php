<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Order: ') . $order->order_number }}
            </h2>
            <div class="flex gap-2">
                <a 
                    href="{{ route('orders.edit', $order) }}" 
                    class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition text-sm font-medium"
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
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm font-medium"
                        >
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Order ID -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Order ID
                            </label>
                            <p class="text-lg font-semibold">
                                #{{ $order->id }}
                            </p>
                        </div>

                        <!-- Order Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Order Number
                            </label>
                            <p class="text-lg font-semibold">
                                {{ $order->order_number }}
                            </p>
                        </div>

                        <!-- Customer -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Customer
                            </label>
                            <p class="text-lg">
                                <a href="{{ route('customers.show', $order->customer) }}" class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium">
                                    {{ $order->customer->name }}
                                </a>
                            </p>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Amount
                            </label>
                            <p class="text-lg font-semibold">
                                ${{ number_format($order->amount, 2) }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Status
                            </label>
                            <p class="text-lg">
                                <x-status-badge :status="$order->status" />
                            </p>
                        </div>

                        <!-- Order Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Order Date
                            </label>
                            <p class="text-lg">
                                {{ optional($order->order_date)->format('M d, Y') }}
                            </p>
                        </div>

                        <!-- Created At -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Created
                            </label>
                            <p class="text-lg">
                                {{ $order->created_at->format('M d, Y H:i A') }}
                            </p>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-8 pt-6 border-t border-gray-300 dark:border-gray-700">
                        <a 
                            href="{{ route('orders.index') }}" 
                            class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium"
                        >
                            ← Back to Orders
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
