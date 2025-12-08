<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Both Admin and Staff can view/create/edit customers and orders
Route::middleware(['auth', 'staff.or.admin'])->group(function() {
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::get('customers/export/csv', [CustomerController::class,'exportCsv'])->name('customers.export.csv');
    Route::get('customers/export/pdf', [CustomerController::class,'exportPdf'])->name('customers.export.pdf');
    Route::get('customers/search/ajax', [CustomerController::class,'ajaxSearch'])->name('customers.search');
    Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::match(['put', 'patch'], 'customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::match(['put', 'patch'], 'orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('orders/export/csv', [OrderController::class,'exportCsv'])->name('orders.export.csv');
    Route::get('orders/export/pdf', [OrderController::class,'exportPdf'])->name('orders.export.pdf');
});

// Only Admins can delete customers/orders and manage soft deletes
Route::middleware(['auth', 'admin'])->group(function() {
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('customers/trashed', [CustomerController::class, 'trashed'])->name('customers.trashed');
    Route::patch('customers/{id}/restore', [CustomerController::class, 'restore'])->name('customers.restore');
    Route::delete('customers/{id}/force', [CustomerController::class, 'forceDelete'])->name('customers.force-delete');
    
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    
    // Admin only: Manage users
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
});

// Notifications (admin)
Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

// AJAX/Realtime-like notification polling (authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('notifications/unread/json', [\App\Http\Controllers\AjaxNotificationController::class, 'unreadJson'])->name('notifications.unread.json');
    Route::post('notifications/{id}/mark-read', [\App\Http\Controllers\AjaxNotificationController::class, 'markRead'])->name('notifications.markRead');
});

// Temporary debug: catch stray POSTs to orders/{order} in local environment
if (app()->environment('local')) {
    Route::post('orders/{order}', function (\Illuminate\Http\Request $request, $order) {
        \Log::warning('Debug POST to orders/{order} captured', [
            'uri' => $request->getRequestUri(),
            'method' => $request->method(),
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'user_id' => optional($request->user())->id,
        ]);

        // Respond with 405 to indicate method not allowed but avoid 404 noise
        return response()->json(['message' => 'Unexpected POST captured for orders/{order}'], 405);
    })->name('orders.debug.post');
}


require __DIR__.'/auth.php';
