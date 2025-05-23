<?php
require_once '../config/db_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

try {
    // Sanitize inputs
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $service = filter_var($_POST['service'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    $budget = filter_var($_POST['budget'], FILTER_SANITIZE_STRING);

    // Insert into database
    $stmt = $pdo->prepare("
        INSERT INTO quote_requests (
            name, email, phone, service, 
            message, budget, status
        ) VALUES (?, ?, ?, ?, ?, ?, 'new')
    ");

    $stmt->execute([
        $name, $email, $phone, $service, 
        $message, $budget
    ]);

    // Log the activity
    $stmt = $pdo->prepare("
        INSERT INTO activity_log (
            action, status, ip_address
        ) VALUES ('quote_request', 'new', ?)
    ");

    $stmt->execute([$_SERVER['REMOTE_ADDR']]);

    echo json_encode([
        'success' => true,
        'message' => 'Quote request submitted successfully'
    ]);

} catch (PDOException $e) {
    error_log("Quote submission error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while processing your request'
    ]);
}