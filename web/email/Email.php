<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__.'/../vendor/autoload.php';

/**
 * @param $destinatario 'email de destino
 * @param $nome 'nome do usuário que se cadastrou
 * @param $idCadastro 'id de confirmação gerado no cadastro do usuário
 * @throws Exception
 */
function enviaEmailConfirmacaoCadastro($destinatario, $nome, $idCadastro){
        $assunto = "Cadastro no site Scarmed";

        $msg = "<h3>Olá $nome, você acabou de se cadastrar no site Scarmed</h3>";
        $msg .= "<br> Para confirmar seu cadastro, clique no link abaixo <br>";

        $host = $_SERVER['HTTP_HOST'];
        if ($host == 'localhost'){
            $host .= '/app-scarmed';
        }
        $host .= '/confirmacaoEmail.php?id=';
        $host .= $idCadastro;

        $msg .= "<a href='".$host."'>Confirmação de cadastro no site Scarmed</a>";

        enviaEmail($destinatario, $assunto, $msg);
}

function enviaEmailEsqueciSenha($destinatario, $nome){
    $assunto = "Recuperação de senha";

    $msg = "";
}

function enviaEmail($destinatario, $assunto, $msg){
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $email = new PHPMailer();
        $email->SMTPDebug = 1;
        $email->isSMTP();
        $email->SMTPAuth = true;
        $email->Port = 587;
        $email->Host = "smtp.gmail.com";
        $email->Username = "scarmedpb@gmail.com";
        $email->SMTPSecure = PhpMailer::ENCRYPTION_STARTTLS;
        $email->Password = "apvvijdbcqavwyxm";
        $email->SetFrom("flaviohenrique638@gmail.com" , "Scarmed");

        $email->AddAddress($destinatario , '');
        $email->Subject = $assunto;
        $email->MsgHTML($msg);

        $email->Send();
    } catch (Exception $e) {
        throw new Exception("Erro enviando email: " . $e->getMessage());
    } finally {
        $email->smtpClose();
    }
}

