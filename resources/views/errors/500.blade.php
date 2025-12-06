<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Server Error') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    
                    <!-- Error Code -->
                    <div class="mb-6">
                        <p class="text-6xl font-bold text-red-600 dark:text-red-400">500</p>
                    </div>

                    <!-- Error Message -->
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                        Server Error
                    </h1>

                    <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">
                        Oops! Something went wrong on our end. Our team has been notified and is working to fix it.
                    </p>

                    <!-- Error Details (shown in development) -->
                    @if(app()->environment('local'))
                        <div class="mb-8 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg text-left">
                            <p class="text-sm font-mono text-gray-700 dark:text-gray-300">
                                An error has been logged. Check storage/logs/laravel.log for details.
                            </p>
                        </div>
                    @endif

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
