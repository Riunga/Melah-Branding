<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!$username || !$email || !$password || !$confirm_password) {
        $_SESSION['register_error'] = 'All fields are required.';
        header('Location: ../register.html');
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = 'Passwords do not match.';
        header('Location: ../register.html');
        exit;
    }

    try {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $_SESSION['register_error'] = 'Username or email already exists.';
            header('Location: ../register.html');
            exit;
        }

        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password_hash]);

        // Redirect to login page after successful registration
        header('Location: ../login.html');
        exit;
    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        $_SESSION['register_error'] = 'An error occurred. Please try again.';
        header('Location: ../register.html');
        exit;
    }
} else {
    header('Location: ../register.html');
    exit;
}
?>
