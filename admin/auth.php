<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT id, username, password_hash FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_logged_in'] = true;

            header('Location: dashboard.html');
            exit;
        } else {
            header('Location: login.html');
            exit;
        }
    } catch(PDOException $e) {
        header('Location: login.html');
        exit;
    }
}
?>