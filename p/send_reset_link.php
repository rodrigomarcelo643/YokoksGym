<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

header('Content-Type: application/json');

function sendVerificationEmail($email, $encodedEmail) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mage.rodrigo.swu@phinmaed.com';
        $mail->Password   = 'voyerzwqqfegxnwf';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('mage.rodrigo.swu@phinmaed.com', 'Yokoks Gym');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Verification';

        // Generate a token with timestamp
        $token = base64_encode($encodedEmail . '|' . time());

        // Stylish and amusing email body
        $mail->Body = '
    <html>
    <head>
        <style>
            body {
                font-family: "Plus Jakarta Sans", sans-serif;
                color: #333;
                background-color: #e9f5e9;
                text-align: center;
                padding: 20px;
                margin: 0;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            }
            h1 {
                color: #2e8b57;
                font-size: 24px;
                margin-bottom: 10px;
            }
            p {
                font-size: 16px;
                line-height: 1.6;
                color: #333;
                margin-bottom: 20px;
            }
            .button {
                display: inline-block;
                padding: 12px 25px;
                font-size: 18px;
                color: #2e8b57;
                font-weight: bold;
                background-color: #ffffff;
                border: 2px solid #2e8b57;
                text-decoration: none;
                border-radius: 5px;
                transition: background-color 0.3s ease, color 0.3s ease;
            }
            .button:hover {
                background-color: #2e8b57;
                color: #ffffff;
            }
            .footer {
                margin-top: 20px;
                font-size: 14px;
                color: #777;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Yokoks Gym</h1>
            <p>It looks like you’ve requested a password reset. We’re here to help you get back on track.</p>
            <p>Click the button below to reset your password:</p>
            <a href="https://lemonchiffon-ape-979463.hostingersite.com/p/reset_password.php?token=' . $token . '" class="button">Reset Password</a>
            <p class="footer">If you did not request a password reset, please ignore this email. Your account is safe with us!</p>
        </div>
    </body>
    </html>';
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function getLastSentTimestamp($email) {
    $file = 'reset_links.txt';
    if (!file_exists($file)) {
        return null;
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($storedEmail, $timestamp) = explode('|', $line);
        if ($storedEmail === $email) {
            return (int)$timestamp;
        }
    }
    return null;
}

function updateLastSentTimestamp($email) {
    $file = 'reset_links.txt';
    $timestamp = time();
    $lines = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
    $found = false;

    foreach ($lines as &$line) {
        list($storedEmail, $storedTimestamp) = explode('|', $line);
        if ($storedEmail === $email) {
            $line = "$email|$timestamp";
            $found = true;
            break;
        }
    }

    if (!$found) {
        $lines[] = "$email|$timestamp";
    }

    file_put_contents($file, implode(PHP_EOL, $lines));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    $cooldown = 120; // 2 minutes in seconds

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array('message' => 'Invalid email format.');
        echo json_encode($response);
        exit;
    }

    $lastSent = getLastSentTimestamp($email);
    $currentTime = time();

    if ($lastSent && ($currentTime - $lastSent) < $cooldown) {
        $response = array('message' => 'A reset link has already been sent. Please wait before requesting another.');
    } else {
        $encodedEmail = base64_encode($email);
        if (sendVerificationEmail($email, $encodedEmail)) {
            updateLastSentTimestamp($email);
            $response = array('message' => 'Verification email sent. Check your inbox (and spam folder).');
        } else {
            $response = array('message' => 'Failed to send verification email. Please try again later.');
        }
    }
    echo json_encode($response);
}
?>