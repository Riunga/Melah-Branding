<?php
return [
    'database' => [
        'host' => 'localhost',
        'name' => 'melah_branding',
        'user' => 'melah_admin',
        'pass' => 'YourStrongPassword123!',
        'charset' => 'utf8mb4'
    ],
    'security' => [
        'password_expiry_days' => 90,
        'max_login_attempts' => 5,
        'lockout_time' => 30, // minutes
        'require_2fa' => true
    ]
];