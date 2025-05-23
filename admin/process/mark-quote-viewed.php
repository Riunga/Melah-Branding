<?php
require_once '../config/db_config.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$quoteId = filter_var($data['quoteId'], FILTER_SANITIZE_NUMBER_INT);

try {
    $stmt = $pdo->prepare("
        UPDATE quote_requests 
        SET viewed = 1 
        WHERE id = ?
    ");
    
    $stmt->execute([$quoteId]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    error_log("Mark quote viewed error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Failed to update quote']);
}