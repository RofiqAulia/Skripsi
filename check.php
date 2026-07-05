<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$r = App\Models\StudyProgressReport::latest()->first();
echo "Type: " . gettype($r->completed_courses) . "\n";
echo "Value: " . json_encode($r->completed_courses) . "\n";

