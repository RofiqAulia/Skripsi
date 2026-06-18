<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::role('mentor')->doesntHave('mentor')->get();
foreach ($users as $u) {
    App\Models\Mentor::create([
        'user_id' => $u->id,
        'current_position' => $u->position ?? 'Mentor',
        'company' => $u->company ?? '-',
        'quota' => 3
    ]);
    echo "Created mentor profile for User ID: " . $u->id . "\n";
}
echo "Done.\n";
