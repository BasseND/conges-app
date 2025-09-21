<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\AttestationType;

echo "Types d'attestations disponibles :\n";
echo "================================\n";

$types = AttestationType::all(['name', 'system_name', 'type', 'template_file']);

foreach ($types as $type) {
    echo "- {$type->name} ({$type->system_name})\n";
    echo "  Type: {$type->type}\n";
    echo "  Template: {$type->template_file}\n";
    echo "\n";
}

echo "Total: " . $types->count() . " types d'attestations\n";