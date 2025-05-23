<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$db = new PDO('mysql:host=localhost;dbname=melah_branding', 'username', 'password');

// Get recent activity
$query = $db->query("
    SELECT 
        created_at as date,
        name,
        email,
        action,
        status
    FROM activity_log
    ORDER BY created_at DESC
    LIMIT 10
");

$activities = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($activities);