<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::whereHas('roles', function($q) {
    $q->where('name', 'pimpinan');
})->first();

file_put_contents('debug.json', json_encode([
    'direktorats' => \App\Models\Direktorat::all()->toArray(),
    'groups' => \App\Models\Group::all()->toArray(),
    'depts' => \App\Models\Department::all()->toArray(),
    'users' => \App\Models\User::with('roles')->get()->toArray()
], JSON_PRETTY_PRINT));
