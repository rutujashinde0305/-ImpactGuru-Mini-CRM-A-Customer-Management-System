<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Customer: ') . $customer->name }}
            </h2>
            <div class="flex gap-2">
                <a 
                    href="{{ route('customers.edit', $customer) }}" 
                    class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition text-sm font-medium"
                >
                    Edit
                </a>
                <form 
                    action="{{ route('customers.destroy', $customer) }}" 
                    method="POST" 
                    class="inline"
                    onsubmit="return confirm('Are you sure you want to delete this customer?');"
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
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Profile Image -->
                    @if($customer->profile_image)
                        <div class="mb-6 text-center">
                            <img 
                                src="{{ asset('storage/' . $customer->profile_image) }}" 
                                alt="{{ $customer->name }}"
                                class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-blue-200 dark:border-blue-700"
                            >
                        </div>
                    @else
                        <div class="mb-6 text-center">
                            <img 
                                src="{{ asset('images/default-avatar.png') }}" 
                                alt="Default Avatar"
                                class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-200 dark:border-gray-700"
                            >
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- ID -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Customer ID
                            </label>
                            <p class="text-lg font-semibold">
                                #{{ $customer->id }}
                            </p>
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Name
                            </label>
                            <p class="text-lg font-semibold">
                                {{ $customer->name }}
                            </p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Email
                            </label>
                            <p class="text-lg">
                                <a href="mailto:{{ $customer->email }}" class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400">
                                    {{ $customer->email }}
                                </a>
                            </p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Phone
                            </label>
                            <p class="text-lg">
                                <a href="tel:{{ $customer->phone }}" class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400">
                                    {{ $customer->phone }}
                                </a>
                            </p>
                        </div>

                        <!-- Address -->
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Address
                            </label>
                            <p class="text-lg">
                                {{ $customer->address ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Created At -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Created
                            </label>
                            <p class="text-lg">
                                {{ $customer->created_at->format('M d, Y - H:i') }}
                            </p>
                        </div>

                        <!-- Updated At -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Last Updated
                            </label>
                            <p class="text-lg">
                                {{ $customer->updated_at->format('M d, Y - H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-8 pt-6 border-t border-gray-300 dark:border-gray-700">
                        <a 
                            href="{{ route('customers.index') }}" 
                            class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium"
                        >
                            ← Back to Customers
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
