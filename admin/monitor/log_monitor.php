<?php
require_once '../includes/error_logger.php';

class LogMonitor {
    public static function checkErrors() {
        $logFile = '../logs/error.log';
        $errors = [];
        
        if (file_exists($logFile)) {
            $lines = file($logFile);
            $errors = array_slice($lines, -50); // Get last 50 errors
        }
        
        return $errors;
    }
    
    public static function checkQuoteSubmissions() {
        global $pdo;
        
        try {
            $stmt = $pdo->query("
                SELECT COUNT(*) as count 
                FROM quote_requests 
                WHERE submission_date > DATE_SUB(NOW(), INTERVAL 24 HOUR)
            ");
            return $stmt->fetch()['count'];
        } catch(PDOException $e) {
            ErrorLogger::log("Quote monitoring failed: " . $e->getMessage());
            return 0;
        }
    }
}