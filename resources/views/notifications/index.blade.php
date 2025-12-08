<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Notifications') }}
            </h2>
            <form method="POST" action="{{ route('notifications.readAll') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Mark all as read</button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($notifications->count())
                    <ul class="space-y-3">
                        @foreach($notifications as $note)
                            <li class="p-3 bg-gray-50 dark:bg-gray-700 rounded flex justify-between items-start">
                                <div>
                                    <div class="font-medium">{{ $note->data['message'] ?? 'Notification' }}</div>
                                    <div class="text-sm text-gray-500">{{ $note->created_at->diffForHumans() }}</div>
                                    @if(!empty($note->data['created_by_name']))
                                        <div class="text-sm text-gray-500">Created by: {{ $note->data['created_by_name'] }}</div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    @if(isset($note->data['order_id']))
                                        <a href="{{ url('/orders/' . $note->data['order_id']) }}" class="text-blue-600 hover:text-blue-800">Open</a>
                                    @elseif(isset($note->data['customer_id']))
                                        <a href="{{ url('/customers/' . $note->data['customer_id']) }}" class="text-blue-600 hover:text-blue-800">Open</a>
                                    @endif

                                    @if(is_null($note->read_at))
                                        <form method="POST" action="{{ route('notifications.read', $note->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-sm text-green-600 hover:text-green-800">Mark read</button>
                                        </form>
                                    @else
                                        <span class="text-sm text-gray-400">Read</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-6">{{ $notifications->links() }}</div>
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">No notifications found.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
