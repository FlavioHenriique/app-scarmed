<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'web/vendor/autoload.php';

$email = new PHPMailer();
$email->SMTPDebug = 2;
$email->isSMTP();
$email->SMTPAuth = true;
$email->Port = "587";
$email->Host = "smtp.scarmed.com.br";
$email->Username = "contato@scarmed.com.br";
$email->Password = "Scar2k19";
$email->SetFrom("contato@scarmed.com.br" , "teste");

$email->AddAddress("jaquelira4@gmail.com" , "teste"); //Já troquei aqui pra outra pessoa e também nada !
$email->Subject = "Testando o envio";
$email->MsgHTML("<h1>Enviando Email</h1>");

if($email->Send())
echo "pegou";

else
echo "não pegou". $email->ErrorInfo;
