<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'web/vendor/autoload.php';

$email = new PHPMailer();
$email->SMTPDebug = 2;
$email->isSMTP();
$email->SMTPAuth = true;
$email->Port = 587;
$email->Host = "smtp.gmail.com";
$email->Username = "flaviohenrique638@gmail.com";
$email->SMTPSecure = PhpMailer::ENCRYPTION_STARTTLS;
$email->Password = "rasenshuriken";
$email->SetFrom("flaviohenrique638@gmail.com" , "teste");

$email->AddAddress("jaquelira4@gmail.com" , "teste"); //Já troquei aqui pra outra pessoa e também nada !
$email->Subject = "Testando o envio";
$email->MsgHTML("<h1>Enviando Email</h1>");

if($email->Send())
echo "pegou";

else
echo "não pegou". $email->ErrorInfo;
