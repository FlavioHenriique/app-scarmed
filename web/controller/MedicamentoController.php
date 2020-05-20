<?php
require_once __DIR__.'/../dao/MedicamentoDAO.php';

if (isset($_POST['btn-consulta'])){
    processarRequisicaoConsultaMedicamento();
}
if (isset($_POST['bt-calcular'])){
    processarRequisicaoCalculadoraDose();
}

/**
 *
 */
function processarRequisicaoConsultaMedicamento(){
    $consulta = $_POST['consulta'];
    $filtro = $_POST['filtro'];
    try{
        session_start();
        $dao = new MedicamentoDAO();
        $arrayMedicamentos = $dao->consultaMedicamentos($consulta, $filtro);

        $_SESSION['consulta'] = $arrayMedicamentos;
        header('Location: ../../index.php');
    }catch (Exception $e){
        header('Location: ../../index.php?message=erro');
        //header('Location: ../../index.php?message='.$e->getMessage());
    }
}

/**
 * Esta função é responsável por processar a requisição da calculadora de dose.
 * Ela recebe a quantidade de comprimidos/líquido utlilizados, o período de horas
 * em que o remédio deve ser administrado (8 em 8 horas, 6 em 6 horas), a quantidade
 * de dias de se deve administrar e realiza o cálculo.
 *
 */
function processarRequisicaoCalculadoraDose(){
    try{
        $tipo = $_POST['tipo'];
        $quantidade = $_POST['quantidade'];
        $horas = $_POST['horas'];
        $dias = $_POST['dias'];
        if (($quantidade == 0) or ($horas == 0) or ($dias == 0)) {
            throw new Exception("Dados inválidos para o uso da calculadora de dose."
             . "Nenhum dos valores pode ser zero.");
        }

        $qtdPorDia = 24 / $horas;
        $resultado = 0;
        $resultado = $qtdPorDia * $quantidade * $dias;
        $msg = "";

        if ($tipo == 1){ // Comprimido
            $msg = "$resultado mg";
        }else if ($tipo == 2) { // Líquido
            $msg = "$resultado ml";
        }else{
            throw new Exception("Tipo inválido");
        }
        session_start();
        $_SESSION['resultado_calculadora'] = $msg;

        header('Location: ../../calculadoraDose.php?message=sucess');
    }catch (Exception $e){
       header('Location: ../../calculadoraDose.php?message='.$e->getMessage());
    }
}