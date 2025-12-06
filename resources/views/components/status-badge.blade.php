<span @class([
    'px-3 py-1 rounded-full text-xs font-semibold',
    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' => $status === 'Completed',
    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' => $status === 'Pending',
    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' => $status === 'Cancelled',
])>
    {{ $status }}
</span>
