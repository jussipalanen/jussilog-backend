#!/usr/bin/env bash
# Regenerates postman/collection.json from the live Laravel routes via Scribe.
# Requires PHP available on the host. For Docker-based dev use: ./dev generate-postman
# Must be run from the project root.
# Usage: bash scripts/generate-postman.sh
#   or:  composer generate:postman
set -e

echo "Running php artisan scribe:generate..."
php artisan scribe:generate

echo "Post-processing collection..."
php - << 'PHP'
$root = getcwd();
$src  = $root . '/storage/app/scribe/collection.json';
$dest = $root . '/postman/collection.json';

$data = json_decode(file_get_contents($src), true);

// Rename baseUrl variable to BASE_URL and reset default value to localhost
foreach ($data['variable'] as &$var) {
    if (in_array($var['id'] ?? '', ['baseUrl', 'BASE_URL'], true) ||
        in_array($var['key'] ?? '', ['baseUrl', 'BASE_URL'], true)) {
        $var['id']    = 'BASE_URL';
        $var['key']   = 'BASE_URL';
        $var['value'] = 'http://localhost:8000';
        $var['name']  = 'BASE_URL';
    }
}

// Add auth_token variable if not already present
$hasAuthToken = array_filter($data['variable'], fn($v) => ($v['key'] ?? '') === 'auth_token');
if (empty($hasAuthToken)) {
    $data['variable'][] = [
        'id'          => 'auth_token',
        'key'         => 'auth_token',
        'type'        => 'string',
        'name'        => 'auth_token',
        'value'       => '',
        'description' => 'Paste the token returned by Login here.',
    ];
}

// Set collection-level Bearer auth so authenticated requests can inherit it
$data['auth'] = [
    'type'   => 'bearer',
    'bearer' => [
        ['key' => 'token', 'value' => '{{auth_token}}', 'type' => 'string'],
    ],
];

// Replace {{baseUrl}} → {{BASE_URL}} everywhere in the JSON text
$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$json = str_replace('{{baseUrl}}', '{{BASE_URL}}', $json);

if (!is_dir(dirname($dest))) {
    mkdir(dirname($dest), 0755, true);
}
file_put_contents($dest, $json);

echo "Saved to postman/collection.json\n";
PHP
