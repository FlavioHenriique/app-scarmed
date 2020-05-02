<?php

require_once '../model/Usuario.php';
require_once  '../connection/Connection.php';

class UsuarioDAO{

    // Método responsável por salvar um usuário no banco de dados
    function salvar(Usuario $usuario){
        if ($this->isUsuarioCadastrado($usuario->getCpf())) {
            throw new Exception("Usuário já cadastrado");
        }
        $conn = getConnection();
        try{
            $sql = "";
            $sql = "INSERT into USUARIO";
            $sql .= " (nome, email, senha, cpf, cep, data_nascimento,";
            $sql .= " tipo_inscricao, numero_inscricao, telefone)";
            $sql .= " values (";
            $sql .= "'" . $usuario->getNome() . "',";
            $sql .= "'" . $usuario->getEmail() . "',";
            $sql .= "'" . $usuario->getSenha() . "',";
            $sql .= "'" . $usuario->getCpf() . "',";
            $sql .= "'" . $usuario->getCep() . "',";
            $sql .= "'" . $usuario->getDataNascimento() . "',";
            $sql .= $usuario->getTipoInscricao() . ",";
            $sql .= $usuario->getInscricaoConselho() . ",";
            $sql .= "'" . $usuario->getTelefone() . "'";
            $sql .= ")";

            mysqli_query($conn, $sql);
            if (mysqli_error($conn) != "") {
                throw  new Exception(mysqli_error($conn));
            }
        } finally {
            $conn->close();
        }
    }

    // Função responsável por identificar se um usuário já foi cadastrado através do CPF
    function isUsuarioCadastrado($cpf){
        $conn = getConnection();
        try{
            $sql = "SELECT * from USUARIO where CPF = '" . $cpf . "'";
            return ($conn->query($sql)->num_rows > 0);
        } finally {
            $conn->close();
        }
    }

    // Função responsável por verificar se um usuário está cadastrado através do email e senha
    function login($identificador, $senha){
        $conn = getConnection();
        try{
            $sql = "SELECT * from USUARIO ";
            $sql .= "where EMAIL = '". $identificador ."' ";
            $sql .= "and SENHA = '". $senha ."'";
            if ($conn->query($sql)->num_rows > 0){
                return true;
            }

            $sql = "SELECT * from USUARIO";
            $sql .= " where CPF =  '$identificador'";
            $sql .= " and SENHA = '$senha'";
            if ($conn->query($sql)->num_rows > 0){
                return true;
            }

            $sql = "SELECT * from USUARIO";
            $sql .= " where TELEFONE = '$identificador'";
            $sql .= " and SENHA = '$senha'";
            return ($conn->query($sql)->num_rows > 0);
        } finally {
            $conn->close();
        }
    }
}