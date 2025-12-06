<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <!-- Total Customers Card -->
                <x-stat-card 
                    label="Total Customers" 
                    :value="$totalCustomers"
                    subtitle="Active customers in system"
                    bgColor="bg-blue-100 dark:bg-blue-900"
                    iconColor="text-blue-600 dark:text-blue-400"
                >
                    <x-slot name="icon">
                        <path d="M10.5 1.5H3.75a2.25 2.25 0 00-2.25 2.25v12a2.25 2.25 0 002.25 2.25h12.5a2.25 2.25 0 002.25-2.25V11M6 7.5a2.25 2.25 0 104.5 0 2.25 2.25 0 00-4.5 0zM16.5 1.5v4m0 0h4m-4 0l3-3m-3 7a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </x-slot>
                </x-stat-card>

                <!-- Total Orders Card -->
                <x-stat-card 
                    label="Total Orders" 
                    :value="$totalOrders"
                    subtitle="All orders processed"
                    bgColor="bg-green-100 dark:bg-green-900"
                    iconColor="text-green-600 dark:text-green-400"
                >
                    <x-slot name="icon">
                        <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 01-1-1V5h-2V3h3a1 1 0 011 1v3a1 1 0 01-1 1z"/>
                    </x-slot>
                </x-stat-card>

                <!-- Total Revenue Card -->
                <x-stat-card 
                    label="Total Revenue" 
                    :value="'₹ ' . number_format($totalRevenue, 2)"
                    subtitle="Sum of all order amounts"
                    bgColor="bg-purple-100 dark:bg-purple-900"
                    iconColor="text-purple-600 dark:text-purple-400"
                >
                    <x-slot name="icon">
                        <path d="M8.5 10.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm6-3a.75.75 0 00-1.5 0v6.75h-3V5.75a.75.75 0 10-1.5 0v6.75H6V5.75a.75.75 0 10-1.5 0v6.75H2.5a1 1 0 01-1-1V3a1 1 0 011-1h15a1 1 0 011 1v8.5a1 1 0 01-1 1h-4v-6.75z"/>
                    </x-slot>
                </x-stat-card>

            </div>

            <!-- Recent Customers Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Recent Customers</h3>
                        <a 
                            href="{{ route('customers.index') }}" 
                            class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 text-sm font-medium"
                        >
                            View All →
                        </a>
                    </div>

                    @if($recentCustomers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-300 dark:border-gray-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left font-semibold">#</th>
                                        <th class="px-6 py-3 text-left font-semibold">Name</th>
                                        <th class="px-6 py-3 text-left font-semibold">Email</th>
                                        <th class="px-6 py-3 text-left font-semibold">Phone</th>
                                        <th class="px-6 py-3 text-center font-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentCustomers as $customer)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4">{{ $customer->id }}</td>
                                            <td class="px-6 py-4 font-medium">{{ $customer->name }}</td>
                                            <td class="px-6 py-4">{{ $customer->email }}</td>
                                            <td class="px-6 py-4">{{ $customer->phone }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <a 
                                                    href="{{ route('customers.show', $customer) }}" 
                                                    class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium"
                                                >
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            No customers found.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Recent Orders</h3>
                        <a 
                            href="{{ route('orders.index') }}" 
                            class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 text-sm font-medium"
                        >
                            View All →
                        </a>
                    </div>

                    @if($recentOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-300 dark:border-gray-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left font-semibold">#</th>
                                        <th class="px-6 py-3 text-left font-semibold">Customer</th>
                                        <th class="px-6 py-3 text-left font-semibold">Amount</th>
                                        <th class="px-6 py-3 text-left font-semibold">Date</th>
                                        <th class="px-6 py-3 text-left font-semibold">Status</th>
                                        <th class="px-6 py-3 text-center font-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentOrders as $order)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4">{{ $order->id }}</td>
                                            <td class="px-6 py-4 font-medium">{{ $order->customer?->name ?? '—' }}</td>
                                            <td class="px-6 py-4">₹{{ number_format($order->amount,2) }}</td>
                                            <td class="px-6 py-4">{{ optional($order->order_date)->toDateString() }}</td>
                                            <td class="px-6 py-4">{{ ucfirst($order->status) }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            No orders found.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Admin Quick Actions -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-3">Admin Quick Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('customers.create') }}" class="px-3 py-2 bg-green-600 text-white rounded">Add Customer</a>
                    <a href="{{ route('orders.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">Add Order</a>
                    <a href="{{ route('users.index') }}" class="px-3 py-2 bg-gray-800 text-white rounded">Manage Users</a>
                    <a href="{{ route('users.create') }}" class="px-3 py-2 bg-gray-600 text-white rounded">Add User</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
