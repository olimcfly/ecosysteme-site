<?php
return [
    'db' => [
        'host' => getenv('DB_HOST'),
        'name' => getenv('DB_NAME'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
    ],
    'admin' => [
        'email' => getenv('ADMIN_EMAIL'),
        'password_hash' => getenv('ADMIN_PASSWORD'),
    ],
];
