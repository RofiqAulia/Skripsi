<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('email', 'pimpinan@test.com')->first();
echo "PHOTO=[" . $u->photo . "]\n";
echo "ASSET=[" . asset('storage/' . $u->photo) . "]\n";
echo "STORAGE=[" . Illuminate\Support\Facades\Storage::disk('public')->url($u->photo) . "]\n";
