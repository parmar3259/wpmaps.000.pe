<?php

require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the email address entered by the user
    $email = $_POST['email'];

    // Instantiate PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Specify SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'parmar3259@gmail.com';
        $mail->Password = 'leughvmjolmgrlyo';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('parmar3259@gmail.com', 'hardik parmar');
        $mail->addAddress($email);

        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = function ($str, $level) {
            // Output the debug information as needed
            echo "Debug level $level; message: $str";
        };
        
        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Test Email';
        $mail->Body = 'This is a test email sent from PHPMailer.';

        // Send the email
        $mail->send();
        echo 'Email sent successfully!';
    } catch (Exception $e) {
        echo 'Error: ' . $mail->ErrorInfo;
    }
}

?>

<!-- HTML Form -->
<form method="POST" action="">
    <input type="email" name="email" placeholder="Enter Email Address" required>
    <button type="submit">Send Email</button>
</form>
