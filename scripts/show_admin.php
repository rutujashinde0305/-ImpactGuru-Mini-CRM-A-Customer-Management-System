<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$u = User::where('email', 'rutujashinde0305@gmail.com')->first();
if ($u) {
    echo json_encode($u->only(['id','name','email','role'])) . PHP_EOL;
} else {
    echo "NOT_FOUND" . PHP_EOL;
}
