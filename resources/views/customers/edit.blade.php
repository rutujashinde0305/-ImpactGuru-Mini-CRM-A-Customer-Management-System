<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Name <span class="text-red-600">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $customer->name) }}"
                                placeholder="Enter customer name"
                                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('name') ? 'border-red-600' : 'border-gray-300 dark:border-gray-600' }}"
                                required
                            >
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email <span class="text-red-600">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $customer->email) }}"
                                placeholder="Enter email address"
                                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('email') ? 'border-red-600' : 'border-gray-300 dark:border-gray-600' }}"
                                required
                            >
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Phone <span class="text-red-600">*</span>
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone', $customer->phone) }}"
                                placeholder="Enter phone number"
                                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('phone') ? 'border-red-600' : 'border-gray-300 dark:border-gray-600' }}"
                                required
                            >
                            @error('phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Address
                            </label>
                            <textarea 
                                id="address" 
                                name="address" 
                                rows="3"
                                placeholder="Enter customer address"
                                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('address') ? 'border-red-600' : 'border-gray-300 dark:border-gray-600' }}"
                            >{{ old('address', $customer->address) }}</textarea>
                            @error('address')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Profile Image -->
                        <div>
                            <label for="profile_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Profile Image
                            </label>
                            
                            @if($customer->profile_image)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $customer->profile_image) }}" 
                                         alt="{{ $customer->name }}" 
                                         class="w-24 h-24 rounded-lg object-cover border border-gray-300 dark:border-gray-600">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Current Image</p>
                                </div>
                            @endif
                            
                            <input type="file" id="profile_image" name="profile_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700">
                            <small class="text-gray-500 dark:text-gray-400 mt-1 block">Max size: 2MB (JPEG, PNG, JPG, GIF)</small>
                            @error('profile_image')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-4 pt-4">
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium"
                            >
                                Update Customer
                            </button>
                            <a 
                                href="{{ route('customers.index') }}" 
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
