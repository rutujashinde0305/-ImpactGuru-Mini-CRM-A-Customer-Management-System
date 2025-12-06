<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Customer -->
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Customer <span class="text-red-600">*</span>
                            </label>
                            <select 
                                id="customer_id" 
                                name="customer_id" 
                                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('customer_id') ? 'border-red-600' : 'border-gray-300 dark:border-gray-600' }}"
                                required
                            >
                                <option value="">Select a customer</option>
                                @foreach($customers as $id => $name)
                                    <option value="{{ $id }}" {{ old('customer_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order Number -->
                        <div>
                            <label for="order_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Order Number <span class="text-red-600">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="order_number" 
                                name="order_number" 
                                value="{{ old('order_number') }}"
                                placeholder="e.g., ORD-2025-001"
                                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('order_number') ? 'border-red-600' : 'border-gray-300 dark:border-gray-600' }}"
                                required
                            >
                            @error('order_number')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Amount <span class="text-red-600">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="amount" 
                                name="amount" 
                                step="0.01"
                                min="0.01"
                                value="{{ old('amount') }}"
                                placeholder="0.00"
                                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('amount') ? 'border-red-600' : 'border-gray-300 dark:border-gray-600' }}"
                                required
                            >
                            @error('amount')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status <span class="text-red-600">*</span>
                            </label>
                            <select 
                                id="status" 
                                name="status" 
                                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('status') ? 'border-red-600' : 'border-gray-300 dark:border-gray-600' }}"
                                required
                            >
                                <option value="">Select a status</option>
                                <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ old('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order Date -->
                        <div>
                            <label for="order_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Order Date <span class="text-red-600">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="order_date" 
                                name="order_date" 
                                value="{{ old('order_date', date('Y-m-d')) }}"
                                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('order_date') ? 'border-red-600' : 'border-gray-300 dark:border-gray-600' }}"
                                required
                            >
                            @error('order_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-4 pt-4">
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-medium"
                            >
                                Create Order
                            </button>
                            <a 
                                href="{{ route('orders.index') }}" 
                                class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition font-medium"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
