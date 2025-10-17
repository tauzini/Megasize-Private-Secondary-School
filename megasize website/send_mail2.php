<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If using Composer
// Or manually include:
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';
// require 'path/to/PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Collect and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.html?status=invalid_email");
        exit;
    }

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Use your SMTP host
    $mail->SMTPAuth   = true;
    $mail->Username   = 'megasizeschool@gmail.com'; // Your Gmail address
    $mail->Password   = 'wzqm fbzm ibwx zysa';   // Use Gmail App Password (not your Gmail password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Email setup
    $mail->setFrom($email, $name);
    $mail->addAddress('meegasizeschool@gmail.com'); // Your receiving email

    $mail->Subject = "Contact Form: $subject";
    $mail->Body    = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\n\nMessage:\n$message";

    $mail->send();
    header("Location: index.html?status=success");
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
    header("Location: index.html?status=error");
}
exit;
?>

