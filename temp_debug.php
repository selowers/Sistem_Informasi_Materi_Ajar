<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Guru;
use App\Models\Materi;

foreach (Guru::with('user')->get() as $g) {
    $email = $g->user ? $g->user->email : 'null';
    echo "Guru {$g->id} | {$g->nama_guru} | user_id={$g->user_id} | user_email={$email}\n";
}

echo "---\n";
foreach (Materi::with('guru')->get() as $m) {
    $guruname = $m->guru ? $m->guru->nama_guru : 'null';
    echo "Materi {$m->id} | {$m->judul_materi} | guru_id={$m->guru_id} | guru_name={$guruname}\n";
}
