<?php
require_once 'config/database.php';
require_once 'middleware/auth_check.php';

try {
    $stmt = $pdo->query("
        SELECT 
            id,
            name,
            email,
            service,
            budget,
            status,
            submission_date
        FROM quote_requests
        ORDER BY submission_date DESC
    ");

    $quotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($quotes);
} catch (PDOException $e) {
    error_log("Quote fetch error: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to fetch quotes']);
}