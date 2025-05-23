<?php
class LoginMonitor {
    public static function recordAttempt($username, $success) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO login_attempts (
                username, 
                ip_address, 
                success, 
                attempt_time
            ) VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([
            $username,
            $_SERVER['REMOTE_ADDR'],
            $success
        ]);
    }

    public static function isAccountLocked($username) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM login_attempts 
            WHERE username = ? 
            AND success = 0 
            AND attempt_time > DATE_SUB(NOW(), INTERVAL 30 MINUTE)
        ");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() >= 5;
    }
}