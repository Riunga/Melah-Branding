<?php
require_once 'csrf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $response = [
            'status' => 'error',
            'message' => 'Invalid request. Please try again.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Get form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $service = $_POST['service'] ?? '';
    $message = $_POST['message'] ?? '';
    $budget = $_POST['budget'] ?? '';

    // Email recipient
    $to = "your-email@melahbranding.com";
    $subject = "New Quote Request from $name";

    // Email content
    $email_content = "New Quote Request Details:\n\n";
    $email_content .= "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Service: $service\n";
    $email_content .= "Budget Range: $budget\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send email
    if (mail($to, $subject, $email_content, $headers)) {
        // Success response
        $response = [
            'status' => 'success',
            'message' => 'Thank you for your quote request. We will contact you soon!'
        ];
    } else {
        // Error response
        $response = [
            'status' => 'error',
            'message' => 'Sorry, there was an error sending your request. Please try again later.'
        ];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>