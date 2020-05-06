<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

function enviaEmail($destinatario, $nome){
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $email = new PHPMailer();
        $email->SMTPDebug = 1;
        $email->isSMTP();
        $email->SMTPAuth = true;
        $email->Port = 587;
        $email->Host = "smtp.gmail.com";
        $email->Username = "flaviohenrique638@gmail.com";
        $email->SMTPSecure = PhpMailer::ENCRYPTION_STARTTLS;
        $email->Password = "vowepcqqegxqihlp";
        $email->SetFrom("flaviohenrique638@gmail.com" , "Scarmed");

        $email->AddAddress($destinatario , $nome); //Já troquei aqui pra outra pessoa e também nada !
        $email->Subject = "Cadastro no site Scarmed";
        $email->MsgHTML("<h3>Olá $nome, você acabou de se cadastrar no site Scarmed</h3>");

        $email->Send();
    } catch (Exception $e) {
        throw new Exception("Erro enviando email: " . $e->getMessage());
    } finally {
        $email->smtpClose();
    }
}

