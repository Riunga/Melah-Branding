<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'melah_branding');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Connection failed. Please try again later.");
}