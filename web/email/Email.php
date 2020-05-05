<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader

require_once 'web/vendor/autoload.php';
function enviaEmail($destinatario, $nome){
    $mail = new PHPMailer(true);

    try {
        //Server settings
        echo "enviando email";
        $mail->SMTPDebug = 2;
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'flaviohenrique638@gmail.com';                     // SMTP username
        $mail->Password   = 'rasenshuriken';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('flaviohenrique638@gmail.com', 'Scarmed');
        $mail->addAddress($destinatario);     // Add a recipient

        $body = "Olá, $nome. Você acabou de se cadastrar no Scarmed, seja bem vindo!";
        $mail->Body = $body;
        $mail->isHTML(true);
        $mail->Subject = "Cadastro no site Scarmed";
        $mail->AltBody = strip_tags($body);

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
