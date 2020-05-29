<?php
require_once __DIR__.'/../model/Usuario.php';
require_once __DIR__.'/../connection/Connection.php';
require_once __DIR__.'/../email/Email.php';
require_once __DIR__.'/../vendor/autoload.php';

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
            $sql .= " (ativo, momento_cadastro, nome, email, senha, cpf, cep, data_nascimento,";
            $sql .= " tipo_inscricao, numero_inscricao, telefone)";
            $sql .= " values (";
            $sql .= "false,"; // Usuário inicia como inativo, sendo necessário a confirmação no email
            $sql .= "current_timestamp,"; // Momento do cadastro
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

            if ($conn->query($sql)->num_rows > 0){
                return $this->getDadosUsuario($identificador);
            }

            // Verificando se o identificador é um CPF válido
            $sql = "SELECT * from USUARIO";
            $sql .= " where CPF =  '$identificador'";
            $sql .= " and SENHA = '$senha'";
            $sql .= " and ATIVO = true";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                $email = $result->fetch_array(MYSQLI_ASSOC)['EMAIL'];
                $result->close();
                return $this->getDadosUsuario($email);
            }

            // Verificando se o identificador é um TELEFONE válido
            $sql = "SELECT * from USUARIO";
            $sql .= " where TELEFONE = '$identificador'";
            $sql .= " and SENHA = '$senha'";
            $sql .= " and ATIVO = true";
            error_log($sql, 0);

            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                $email = $result->fetch_array(MYSQLI_ASSOC)['EMAIL'];
                $result->close();
                return $this->getDadosUsuario($email);
            }
            return null;
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

    /**
     * Esta função é responsável por retornar os dados de um usuário
     * através do EMAIL passado
     *
     * @param $email ' Email do usuário
     * @return bool
     * @throws Exception
     */
    public function getDadosUsuario($email){
        if ($email == "") {
            throw new Exception("Email inválido");
        }
        $conn = getConnection();
        try{
            $sql  = " SELECT *";
            $sql .= "\n from USUARIO";
            $sql .= "\n where EMAIL = '$email'";
            $sql .= "\n and ATIVO = true";
            $result = $conn->query($sql);
            if ($result->num_rows <= 0){
                throw new Exception("Usuário não encontrado com o email $email");
            }
            $row = $result->fetch_array(MYSQLI_ASSOC);

            // Montando objeto Usuario
            $usuario = new Usuario();
            $usuario->setCpf($row['CPF']);
            $usuario->setTelefone($row['TELEFONE']);
            $usuario->setTipoInscricao($row['TIPO_INSCRICAO']);
            $usuario->setInscricaoConselho($row['NUMERO_INSCRICAO']);
            $usuario->setDataNascimento($row['DATA_NASCIMENTO']);
            $usuario->setCep($row['CEP']);
            $usuario->setEmail($row['EMAIL']);
            $usuario->setNome($row['NOME']);

            $result->close();

            return $usuario;
        } finally {
            $conn->close();
        }
    }

    /**
     * Esta função é responsável por gerar um código de recuperação da senha para
     * o usuário que solicitou, inserindo um registro na tabela USUARIO_RECUPERACAO_SENHA
     *
     * @param $email ' Email do usuário para recuperação de senha
     * @return int ' Código gerado aleatoriamente
     * @throws Exception
     */
    public function getCodigoRecuperacaoSenha($email){
        if ($email == ""){
            throw new Exception("Email inválido para recuperação de senha");
        }
        $conn = getConnection();
        try{
            $conn->autocommit(false);
            // Código gerado aleatoriamente para recuperação
            $codigo = random_int(1000, 9999);

            $sql  = "INSERT INTO USUARIO_RECUPERACAO_SENHA";
            $sql .= "\n (EMAIL, CODIGO_RECUPERACAO, CODIGO_VALIDO)";
            $sql .= "\n values ('$email', $codigo, true)";
            $conn->query($sql);

            if (mysqli_error($conn) != "") {
                throw  new Exception(mysqli_error($conn));
            }
            $conn->commit();
            return $codigo;
        } finally {
            $conn->rollback();
            $conn->close();
        }
    }

    /**
     * Esta função é responsável por confirmar o código digitado para troca
     * da senha do usuário. Caso esteja correto, será alterado o registro de
     * USUARIO_RECUPERACAO_SENHA para invalidar o código.
     *
     * @param $codigo ' Código digitado para verificar se está correto
     * @param $email ' Email do usuário
     * @throws Exception
     */
    public function confirmaCodigoSenha($codigo, $email){
        if (($email == "") or ($codigo == 0)){
            throw new Exception("Dados inválidos para confirmação da troca de senha");
        }
        $conn = getConnection();
        try{
            $conn->autocommit(false);
            $sql  = " SELECT *";
            $sql .= "\n from USUARIO_RECUPERACAO_SENHA";
            $sql .= "\n where EMAIL = '$email' ";
            $sql .= "\n and CODIGO_RECUPERACAO = $codigo and CODIGO_VALIDO = true";
            error_log($sql);
            $result = $conn->query($sql);
            if ($result->num_rows <= 0){
                throw  new Exception("O código de recuperação $codigo "
                    ."para o email $email é inválido");
            }
            $id = $result->fetch_array(MYSQLI_ASSOC)['CODIGO'];

            // Se existe um registro deste código para este email, deve inválidar no banco de dados
            $sql  = " UPDATE USUARIO_RECUPERACAO_SENHA";
            $sql .= "\n set CODIGO_VALIDO = false";
            $sql .= "\n where CODIGO = $id";
            $conn->query($sql);
            $conn->commit();
            $result->close();
        } finally {
            $conn->rollback();
            $conn->close();
        }
    }

    /**
     *  Esta função é responsável por modificar a senha de um usuário
     *
     * @param $email ' Email do usuário para modificar a senha
     * @param $senha ' Nova senha do usuário
     * @throws Exception
     */
    public function modificaSenha($email, $senha){
        $conn = getConnection();
        try{
            $sql  = "UPDATE USUARIO";
            $sql .= "\n set SENHA = '$senha'";
            $sql .= "\n where EMAIL = '$email'";
            $conn->query($sql);
            if (mysqli_error($conn) <> "") {
                throw new Exception(mysqli_error($conn));
            }
        } finally {
            $conn->rollback();
            $conn->close();
        }
    }
}