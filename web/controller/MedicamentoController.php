<?php
require_once __DIR__.'/../dao/MedicamentoDAO.php';

if (isset($_POST['btn-consulta'])){
    processarRequisicaoConsultaMedicamento();
}

/**
 *
 */
function processarRequisicaoConsultaMedicamento(){
    $consulta = $_POST['consulta'];
    try{
        session_start();
        $dao = new MedicamentoDAO();
        $arrayMedicamentos = $dao->consultaMedicamentos($consulta);

        $_SESSION['consulta'] = $arrayMedicamentos;
        header('Location: ../../index.php');
    }catch (Exception $e){
        header('Location: ../../index.php?message='.$e->getMessage());
    }
}