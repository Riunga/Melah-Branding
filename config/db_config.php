<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'melah_branding');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    die("Connection failed. Please try again later.");
}