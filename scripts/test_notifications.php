<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use App\Notifications\NewCustomerNotification;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

// Ensure admin exists
$admin = User::where('role','admin')->first();
if (! $admin) {
    echo "No admin found. Seeding admin...\n";
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'rutujashinde0305@gmail.com',
        'password' => bcrypt('admin123'),
        'role' => 'admin',
    ]);
}

// Create a test customer
$customer = Customer::create([
    'name' => 'Test Customer ' . time(),
    'email' => 'test+' . time() . '@example.com',
]);

// Notify admins exactly as controller does (send now to avoid queued jobs). Use $admin as creator for the test.
Notification::sendNow(User::where('role','admin')->get(), new NewCustomerNotification($customer, $admin));

// Create a test order for that customer
$order = Order::create([
    'customer_id' => $customer->id,
    'order_number' => 'T' . time(),
    'amount' => 123.45,
    'status' => 'Pending',
    'order_date' => date('Y-m-d H:i:s'),
]);

Notification::sendNow(User::where('role','admin')->get(), new NewOrderNotification($order, $admin));

// Show last notifications from DB
$notifications = DB::select('select id, notifiable_id, type, data, created_at, read_at from notifications order by created_at desc limit 10');

echo "---- Latest notifications (DB) ----\n";
foreach ($notifications as $n) {
    echo json_encode([ 'id' => $n->id, 'notifiable_id' => $n->notifiable_id, 'type' => $n->type, 'data' => json_decode($n->data, true), 'created_at' => $n->created_at, 'read_at' => $n->read_at ]) . "\n";
}

// Show recent mail log entries
$logFile = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logFile)) {
    echo "---- Mail log (last 200 lines) ----\n";
    $lines = file($logFile);
    $last = array_slice($lines, -200);
    echo implode('', $last);
} else {
    echo "No mail log found at storage/logs/laravel.log\n";
}

echo "\nDone.\n";
