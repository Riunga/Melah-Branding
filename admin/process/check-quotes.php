<?php
require_once '../config/db_config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT COUNT(*) as count 
        FROM quote_requests 
        WHERE status = 'new' AND viewed = 0
    ");
    
    $result = $stmt->fetch();
    echo json_encode(['success' => true, 'newQuotes' => $result['count']]);
} catch (PDOException $e) {
    error_log("Quote check error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Failed to check quotes']);
}