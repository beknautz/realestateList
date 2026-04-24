<?php
return [
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3306',
        'name' => getenv('DB_NAME') ?: 'firmanpollen',
        'user' => getenv('DB_USER') ?: 'root',
        'pass' => getenv('DB_PASS') ?: '',
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'name' => 'Firman Pollen',
        'base_url' => getenv('APP_BASE_URL') ?: '',
    ],
    'admin' => [
        'username' => getenv('ADMIN_USER') ?: 'admin',
        'password' => getenv('ADMIN_PASS') ?: 'change-me-now',
    ],
];
