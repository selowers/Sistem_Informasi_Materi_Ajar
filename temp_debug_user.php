<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

$user = User::where('role', 'guru')->first();
if (! $user) {
    echo "No guru user found\n";
    exit;
}

$guru = $user->guru;
echo "User id={$user->id} role={$user->role} name={$user->nama} / {$user->name} email={$user->email}\n";
if ($guru) {
    echo "Linked guru: id={$guru->id} nama_guru={$guru->nama_guru} user_id={$guru->user_id}\n";
} else {
    echo "No linked guru profile\n";
}
