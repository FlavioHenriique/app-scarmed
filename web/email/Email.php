<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Esta função é responsável por montar a mensagem de email para confirmação de cadastro.
 * Após montada, é chamada a função enviaEmail para concluir o envio de email.
 *
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

/**
 * Esta função é responsável por montar a mensagem de email para recuperação
 * de senha. Após isso, chamar a função envia email com as informações necessárias.
 *
 * @param $destinatario 'Email de destino
 * @param $nome 'Nome do usuário do email enviado
 * @param $codigo 'Código de verificação para recuperar a senha
 * @throws Exception
 */
function enviaEmailEsqueciSenha($destinatario, $nome, $codigo){
    $assunto = "Recuperação de senha";

    $msg  = "<h3>Olá $nome, você solicitou a recuperação de sua senha</h3>";
    $msg .= "<br>O seu código de verificação é:<br>";
    $msg .= "<h1>$codigo</h1>";

    enviaEmail($destinatario, $assunto, $msg);
}

/**
 * Esta função é responsável por enviar um email para o destinatário informado,
 * utilizando a classe PHPMailer.
 *
 * @param $destinatario 'Destinatário do email
 * @param $assunto 'Assunto do email
 * @param $msg 'Mensagem formatada para ser enviada
 * @throws Exception
 */
function enviaEmail($destinatario, $assunto, $msg){
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $email = new PHPMailer();
        $email->SMTPDebug = 1;
        $email->isSMTP();
        $email->CharSet = 'UTF-8';
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
