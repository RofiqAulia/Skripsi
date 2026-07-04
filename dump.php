<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo json_encode(\App\Models\PspApplication::select('id', 'approval_stage')->get()->toArray(), JSON_PRETTY_PRINT);
