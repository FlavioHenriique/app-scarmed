<?php
require_once __DIR__.'/../model/Usuario.php';
require_once __DIR__.'/../connection/Connection.php';
require_once __DIR__.'/../email/Email.php';

class UsuarioDAO{

    /**
     * Método responsável por salvar um usuário no banco de dados
     *
     * @param Usuario $usuario Usuário a ser persistido
     * @throws Exception
     */
    public function salvar(Usuario $usuario){
        $this->validaUsuario($usuario);

        $conn = getConnection();
        try{
            $sql = "";
            $sql = "INSERT into USUARIO";
            $sql .= " (ativo, nome, email, senha, cpf, cep, data_nascimento,";
            $sql .= " tipo_inscricao, numero_inscricao, telefone)";
            $sql .= " values (";
            $sql .= "false,";
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

            $conn->autocommit(false);

            // Inserindo o usuário
            mysqli_query($conn, $sql);
            if (mysqli_error($conn) != "") {
                throw  new Exception(mysqli_error($conn));
            }

            $this->insereConfirmacaoUsuario($usuario, $conn);

            $conn->commit();
        } finally {
            $conn->rollback();
            $conn->close();
        }
    }

    /**
     * Esta função é responsável por inserir um registro na tabela USUARIO_CONFIRMACAO
     * e chamar o método para enviar um email de confirmação para o email cadastrado
     *
     * @param Usuario $usuario Objeto do usuário que está se cadastrando
     * @param $conn  'Conexao' com o banco de dados passada como parâmetro
     * @throws Exception
     */
    private function insereConfirmacaoUsuario(Usuario $usuario, $conn){
        try{
            // O id de confirmação será, inicialmente, o email como MD5
            $idConfirmacao = md5($usuario->getEmail());

            // Inserindo um registro na tabela USUARIO_CONFIRMACAO
            $sql = "INSERT INTO USUARIO_CONFIRMACAO (EMAIL, ID_CONFIRMACAO, CONFIRMADO)";
            $sql .= " values ('".$usuario->getEmail()."', '". $idConfirmacao ."', false);";

            $conn->query($sql);
            if (mysqli_error($conn) != "") {
                throw  new Exception(mysqli_error($conn));
            }
            // Enviando email de confirmação
            enviaEmailConfirmacaoCadastro($usuario->getEmail(), $usuario->getNome(), $idConfirmacao);
        }catch (Exception $e){
            throw new Exception("Erro ao preparar email de confirmação: " . $e->getMessage());
        }
    }

    /**
     * Função responsável por validar se um usuário pode ser cadastrado, verificando
     * Se o CPF, telefone ou Email já foram cadastrados
     *
     * @param Usuario $usuario Usuário a ser validado
     * @throws Exception
     */
    private function validaUsuario(Usuario $usuario){
        $conn = getConnection();
        try{
            // Consultando por Email
            $sql = "SELECT * from USUARIO where EMAIL = '" . $usuario->getEmail() . "'";
            if ($conn->query($sql)->num_rows > 0){
                throw new Exception("Já existe um usuário com este Email!");
            }

            // Consultando por CPF
            $sql = "SELECT * from USUARIO where CPF = '" . $usuario->getCpf() . "'";
            if ($conn->query($sql)->num_rows > 0){
                throw new Exception("Já existe um usuário com este CPF!");
            }
            // Consultando por telefone
            $sql = "SELECT * from USUARIO where TELEFONE = '" . $usuario->getTelefone() . "'";
            if ($conn->query($sql)->num_rows > 0){
                throw new Exception("Já existe um usuário com este telefone!");
            }
        } finally {
            $conn->close();
        }
    }

    /**
     * Função responsável por verificar se um usuário está cadastrado através do email e senha
     *
     * @param $identificador 'variavel passada como identificador, pode ser CPF, Email ou telefone'
     * @param $senha
     * @return bool
     */
    public function login($identificador, $senha){
        $conn = getConnection();
        try{
            // Verificando se o identificador é um EMAIL válido
            $sql = "SELECT * from USUARIO ";
            $sql .= "where EMAIL = '". $identificador ."' ";
            $sql .= "and SENHA = '". $senha ."' ";
            $sql .= " and ATIVO = true";
            error_log($sql, 0);
            if ($conn->query($sql)->num_rows > 0){
                return true;
            }

            // Verificando se o identificador é um CPF válido
            $sql = "SELECT * from USUARIO";
            $sql .= " where CPF =  '$identificador'";
            $sql .= " and SENHA = '$senha'";
            $sql .= " and ATIVO = true";
            error_log($sql, 0);
            if ($conn->query($sql)->num_rows > 0){
                return true;
            }

            // Verificando se o identificador é um TELEFONE válido
            $sql = "SELECT * from USUARIO";
            $sql .= " where TELEFONE = '$identificador'";
            $sql .= " and SENHA = '$senha'";
            $sql .= " and ATIVO = true";
            error_log($sql, 0);

            return ($conn->query($sql)->num_rows > 0);
        } finally {
            $conn->close();
        }
    }

    /**
     * Esta função é resposável por validar se o id Informado pertence a uma confirmação de email
     * que está pendente
     *
     * @param $id Id de confirmação do usuário que foi enviado por email
     * @return bool
     * @throws Exception
     */
    public function validaConfirmacaoEmail($id){
        $conn = getConnection();
        try{
            $sql  = "SELECT";
            $sql .= "\n EMAIL, ID_CONFIRMACAO";
            $sql .= "\n from USUARIO_CONFIRMACAO";
            $sql .= "\n where ID_CONFIRMACAO = '$id'";
            $sql .= "\n and CONFIRMADO = false";

            // Consultando se existe registro com este id de confirmação
            $result = $conn->query($sql);

            if ($conn->error <> "") {
                throw new Exception($conn->error);
            }
            if ($result->num_rows <= 0) {
                throw new Exception("Este id de confirmação é inválido.");
            }

            $row = $result->fetch_array(MYSQLI_ASSOC);
            $email = $row['EMAIL'];
            if(md5($email) <> $id) {
                throw new Exception("Este id de confirmação não pertence a "
                . "nenhum cadastro pendente");
            }
            // O id de confirmação enviado está válido, então deve setar CONFIRMADO = true
            $sql = "UPDATE USUARIO_CONFIRMACAO";
            $sql .= "\n set CONFIRMADO = true";
            $sql .= "\n where ID_CONFIRMACAO = '$id'";
            $sql .= "\n and CONFIRMADO = false;";
            $conn->query($sql);

            // Setando ATIVO = true para o USUARIO
            $sql  = "\n UPDATE USUARIO";
            $sql .= "\n set ATIVO = true";
            $sql .= "\n where EMAIL = '$email';";
            $conn->query($sql);

            $conn->commit();
            return true;
        } finally {
            $conn->rollback();
            $conn->close();
        }
    }
}