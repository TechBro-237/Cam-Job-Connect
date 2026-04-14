<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'electronicelecamm@gmail.com'; // your Gmail
        $mail->Password = 'etaz agsu ndzm btaj';   // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('electronicelecamm@gmail.com', 'e-ELECAMM');
        $mail->addAddress('electronicelecamm@gmail.com'); // where message goes

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Message";
        $mail->Body = "
            <h3>New Message from Website</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong><br>$message</p>
        ";

        $mail->send();

echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Message Sent</title>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background: url("uploads/allworkers.jpg") no-repeat center center fixed;
        background-size: cover;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .box {
        background: #ffffff;
        padding: 40px;
        border-radius: 12px;
        text-align: center;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .box h2 {
        color: #28a745;
        margin-bottom: 15px;
    }

    .box p {
        color: #333;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background: #FCA311;
        color: #000;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
    }

    .btn:hover {
        background: #000;
        color: #FCA311;
    }
</style>
</head>

<body>

<div class="overlay">
    <div class="box">
        <h2>✅ Message Sent Successfully</h2>
        <p>Thank you for contacting CamJobConnect. We will get back to you shortly.</p>
        <a href="home.html" class="btn">Go Back Home</a>
    </div>
</div>

</body>
</html>
';

    } catch (Exception $e) {
        echo "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>

