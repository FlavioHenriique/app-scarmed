<?php

require_once '../model/Usuario.php';
require_once  '../connection/Connection.php';

class UsuarioDAO{

    function salvar(Usuario $usuario){
        if ($this->isUsuarioCadastrado($usuario->getCpf())) {
            throw new Exception("Usuário já cadastrado");
        }
        $conn = getConnection();
        try{

            $sql = "";
            $sql = "INSERT into USUARIO";
            $sql .= " (nome, email, senha, cpf)";
            $sql .= " values (";
            $sql .= "'" . $usuario->getNome() . "',";
            $sql .= "'" . $usuario->getEmail() . "',";
            $sql .= "'" . $usuario->getSenha() . "',";
            $sql .= "'" . $usuario->getCpf() . "'";
            $sql .= ")";

            mysqli_query($conn, $sql);
            if (mysqli_error($conn) != "") {
                throw  new Exception(mysqli_error($conn));
            }
        } finally {
            $conn->close();
        }
    }

    function isUsuarioCadastrado($cpf){
        $conn = getConnection();
        try{
            $sql = "SELECT * from USUARIO where CPF = '" . $cpf . "'";
            return ($conn->query($sql)->num_rows > 0);
        } finally {
            $conn->close();
        }
    }
}