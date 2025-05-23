<?php
require_once '../config/db_config.php';
require_once '../includes/error_logger.php';

function testDatabaseConnection() {
    global $pdo;
    
    try {
        $pdo->query("SELECT 1");
        echo "Database connection successful!\n";
        return true;
    } catch(PDOException $e) {
        ErrorLogger::log("Database connection test failed: " . $e->getMessage());
        echo "Database connection failed. Check error logs.\n";
        return false;
    }
}

function testQuoteSubmission() {
    global $pdo;
    
    $testData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'service' => 'branding',
        'message' => 'Test message',
        'budget' => 'medium'
    ];
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO quote_requests (
                name, email, phone, service, 
                message, budget
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $testData['name'],
            $testData['email'],
            $testData['phone'],
            $testData['service'],
            $testData['message'],
            $testData['budget']
        ]);
        
        echo "Quote submission test successful!\n";
        return true;
    } catch(PDOException $e) {
        ErrorLogger::log("Quote submission test failed: " . $e->getMessage());
        echo "Quote submission test failed. Check error logs.\n";
        return false;
    }
}

// Run tests
testDatabaseConnection();
testQuoteSubmission();