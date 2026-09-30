<?php
function groupSecret(string $name): string {
    $path = '/run/secrets/' . $name;
    $value = is_readable($path) ? trim(file_get_contents($path)) : '';
    if (!preg_match('/^[a-f0-9]{64}$/D', $value)) {
        throw new RuntimeException('Missing or invalid runtime secret: ' . $name);
    }
    return $value;
}
define('DB_HOST', getenv('DB_HOST') ?: 'database');
define('DB_USERNAME', 'mutillidae');
define('DB_PASSWORD', groupSecret('db_password'));
define('DB_NAME', 'mutillidae');
define('DB_PORT', 3306);
