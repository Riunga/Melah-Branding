<?php
class PasswordPolicy {
    public static function requirePasswordChange($userId) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT password_last_changed 
            FROM admin_users 
            WHERE id = ?
        ");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        
        $daysSinceChange = (time() - strtotime($result['password_last_changed'])) / (60 * 60 * 24);
        return $daysSinceChange >= 90;
    }

    public static function isPasswordStrong($password) {
        return strlen($password) >= 12 &&
               preg_match('/[A-Z]/', $password) &&
               preg_match('/[a-z]/', $password) &&
               preg_match('/[0-9]/', $password) &&
               preg_match('/[^A-Za-z0-9]/', $password);
    }
}