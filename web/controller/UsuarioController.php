<?php
require_once __DIR__.'/../connection/Connection.php';
require_once __DIR__.'/../model/Usuario.php';
require_once __DIR__.'/../dao/UsuarioDAO.php';

if (isset($_POST['bt-cadastro-usuario'])){
    processarRequisicaoCadastro();
}

if (isset($_POST['btn-login'])){
    processarRequisicaoLogin();
}

if (isset($_POST['btn-esqueci-senha'])){
    processarRequisicaoEsqueciSenha();
}

if (isset($_POST['btn-recupera-senha'])){
    processarRequisicaoConfirmacaoCodigo();
}

if (isset($_POST['btn-nova-senha'])){
    processarRequisicaoNovaSenha();
}

if (isset($_POST['btn-sair'])){
    processarRequisicaoSair();
}

/**
 * Esta função é responsável por processar a requisição do cadastro de um usuário,
 * Montando o objeto do usuário para chamar a função insereUsuario
 *
 */
function processarRequisicaoCadastro(){
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $cep = $_POST['cep'];
    $data = $_POST['data'];
    $data = date_create($data);
    $data = date_format($data, "Y-m-d");
    $numeroInscricao = ($_POST['numInscricao'] == null) ? 0 : $_POST['numInscricao'];
    $tipoInscricao = ($_POST['tipoInscricao'] == null) ? 0 : $_POST['tipoInscricao'];
    $telefone = $_POST['telefone'];

    try{
        $senha = md5($senha);
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setCpf($cpf);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $usuario->setCep($cep);
        $usuario->setDataNascimento($data);
        $usuario->setInscricaoConselho($numeroInscricao);
        $usuario->setTipoInscricao($tipoInscricao);
        $usuario->setTelefone($telefone);
        insereUsuario($usuario);
        header('Location: ../../cadastroUsuario.php?message=sucess');
    }catch(exception $e){
            header('Location: ../../cadastroUsuario.php?message='.$e->getMessage());
    }
}

/**
 * Esta função é responsável por processar a requisição de um login
 *
 */
function processarRequisicaoLogin(){
    try{
        $identificador = $_POST['identificador'];
        $senha = $_POST['senha'];
        $senha = md5($senha);
        $user = login($identificador, $senha);
        if ($user != null){
            session_start();
            $_SESSION['usuario'] = $user;

            header('Location: ../../index.php?message=sucess');
        }else{
            header('Location: ../../index.php?message=error');
        }
    }catch (exception $e){
        header('Location: ../../index.php?message='.$e->getMessage());
    }
}

/**
 * Esta função é responsável por processar a requisição para recuperação de senha
 */
function processarRequisicaoEsqueciSenha(){
    $email = $_POST['email'];
    try{
        $dao = new UsuarioDAO();

        // Consultando dados do usuário, caso exista
        $usuario = $dao->getDadosUsuario($email);
        if ($usuario == null) {
            throw new Exception("Usuário não encontrado");
        }
        // Obtendo o código de recuperação da senha
        $codigo = $dao->getCodigoRecuperacaoSenha($usuario->getEmail());

        enviaEmailEsqueciSenha($usuario->getEmail(), $usuario->getNome(), $codigo);

        header('Location: ../../recuperacaoSenha.php?email='.$usuario->getEmail());
    }catch (Exception $e){
        header('Location: ../../esqueciMinhaSenha.php?message='.$e->getMessage());
    }
}

/**
 * Esta função é responsável por processar a requisição para confirmação
 * do código para troca de senha
 *
 */
function processarRequisicaoConfirmacaoCodigo(){
    $codigo = $_POST['codigo'];
    $email = $_POST['email'];
    $dao = new UsuarioDAO();
    try{
        $dao->confirmaCodigoSenha($codigo, $email);
        header('Location: ../../novaSenha.php?email='.$email);
    }catch (Exception $e){
        header('Location: ../../recuperacaoSenha.php?message='.$e->getMessage());
    }

}

/**
 * Esta função é responsável por processar a requisição do cadastro de uma nova senha
 *
 */
function processarRequisicaoNovaSenha(){
    $novaSenha = $_POST['senha'];
    $confirmaSenha = $_POST['confirmaSenha'];
    $email = $_POST['email'];
    try{
        if ($novaSenha <> $confirmaSenha){
            throw new Exception("As senhas digitadas não são iguais");
        }
        $novaSenha = md5($novaSenha);
        $dao = new UsuarioDAO();
        $dao->modificaSenha($email, $novaSenha);

        header("Location: ../../index.php?message=senhaCadastrada");
    }catch (Exception $e){
        header("Location: ../../novaSenha.php?email=$email&message=".$e->getMessage());
    }
}

function processarRequisicaoSair(){
    session_start();
    $_SESSION['usuario'] = null;
    header("Location: ../../index.php");
}


/**
 * Esta função é responsável por validar CPF e CEP do usuário e, caso estejam válidos,
 * chamar o Dao de Usuário para cadastrá-lo no banco de dados
 *
 * @param Usuario $usuario ' objeto do Usuário que está sendo inserido
 * @throws Exception
 */
function insereUsuario(Usuario $usuario){
    if (!isCPFValido($usuario->getCpf())) {
        throw new Exception("O CPF " . $usuario->getCpf() . " é inválido!");
    }
    if (!isCepValido($usuario->getCep())) {
        throw  new Exception("O cep " . $usuario->getCep() . " é inválido");
    }
    $dao = new UsuarioDAO();
    $dao->salvar($usuario);
}

/**
 * Esta função é responsável por realizar o login através do método login da classe UsuarioDAO
 *
 * @param $identificador ' Identificador passado para o login, pode ser Email, CPF ou telefone
 * @param $senha ' Senha para o login
 * @return bool
 */
function login($identificador, $senha){
    $dao = new UsuarioDAO();
    return ($dao->login($identificador, $senha));
}

/**
 * Esta função é responsável por validar um CPF
 *
 * @param $cpf ' CPF para ser validado
 * @return bool
 */
function isCPFValido($cpf) {
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf{$c} * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf{$c} != $d) {
            return false;
        }
    }
    return true;
}

/**
 * Esta função é responsável por validar um CEP
 *
 * @param $cep 'CEP para ser validado
 * @return bool
 */
function isCepValido($cep){
    if (($cep == "") or (strlen($cep) <> 8)) {
        return false;
    }
    $cep = $_POST['cep'];
    $url = "https://viacep.com.br/ws/$cep/json/";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    $result = strtoupper($result);
    return (strpos($result, "ERRO") === false);
}