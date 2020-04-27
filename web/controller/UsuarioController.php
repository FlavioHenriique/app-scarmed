<?php

require_once '../connection/Connection.php';
require_once '../model/Usuario.php';
require_once '../dao/UsuarioDAO.php';

if (isset($_POST['bt-cadastro-usuario'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    try{
        if (validaCPF($cpf) == false) {
            throw new Exception("O CPF " . $cpf . " é inválido!");
        }
        $senha = md5($senha);
        echo $senha;
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setCpf($cpf);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        insereUsuario($usuario);
        header('Location: ../../cadastroUsuario.php?message=sucess');
    }catch(exception $e){
        header('Location: ../../cadastroUsuario.php?message='.$e->getMessage());
    }
}

if (isset($_POST['btn-login'])){
    try{
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $senha = md5($senha);
        if (login($email, $senha)) {
            header('Location: ../../index.php?message=sucess');
        }else{
            header('Location: ../../index.php?message=error');
        }
    }catch (exception $e){
        header('Location: ../../index.php?message='.$e->getMessage());
    }
}

function insereUsuario(Usuario $usuario){
    $dao = new UsuarioDAO();
    $dao->salvar($usuario);
}

function login($email, $senha){
    $dao = new UsuarioDAO();
    return ($dao->login($email, $senha));
}

function validaCPF($cpf) {
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
