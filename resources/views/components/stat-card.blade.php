<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                    {{ $label }}
                </p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                    {{ $value }}
                </p>
                @isset($subtitle)
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        {{ $subtitle }}
                    </p>
                @endisset
            </div>
            @isset($icon)
                <div class="p-3 rounded-lg {{ $bgColor ?? 'bg-blue-100 dark:bg-blue-900' }}">
                    <svg class="w-8 h-8 {{ $iconColor ?? 'text-blue-600 dark:text-blue-400' }}" fill="currentColor" viewBox="0 0 20 20">
                        {{ $icon }}
                    </svg>
                </div>
            @endisset
        </div>
    </div>
</div>
