<?php
require_once 'admin/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Insert quote request into database
        $stmt = $pdo->prepare("
            INSERT INTO quote_requests (
                name, email, phone, service, 
                message, budget, status, 
                submission_date
            ) VALUES (?, ?, ?, ?, ?, ?, 'new', NOW())
        ");

        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['service'],
            $_POST['message'],
            $_POST['budget']
        ]);

        // Log the activity
        $stmt = $pdo->prepare("
            INSERT INTO activity_log (
                action, name, email, status
            ) VALUES ('quote_request', ?, ?, 'new')
        ");

        $stmt->execute([
            $_POST['name'],
            $_POST['email']
        ]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        error_log("Quote submission error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred']);
    }
}