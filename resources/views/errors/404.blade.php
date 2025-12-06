<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Page Not Found') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    
                    <!-- Error Code -->
                    <div class="mb-6">
                        <p class="text-6xl font-bold text-red-600 dark:text-red-400">404</p>
                    </div>

                    <!-- Error Message -->
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                        Page Not Found
                    </h1>

                    <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">
                        Sorry, we couldn't find the page you're looking for. It may have been moved or deleted.
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 justify-center">
                        <a 
                            href="{{ url('/') }}" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium"
                        >
                            Go Home
                        </a>
                        <a 
                            href="javascript:history.back()" 
                            class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition font-medium"
                        >
                            Go Back
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
