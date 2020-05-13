<?php
require_once __DIR__.'/../connection/Connection.php';
require_once __DIR__.'/../model/Medicamento.php';

class MedicamentoDAO{

    /**
     * Esta função é responsável por consultar os medicamentos que se encaixam na
     * consulta feita, que pode ser o nome do medicamento ou a substância
     *
     * @param $consulta
     * @return array
     * @throws Exception
     */
    public function consultaMedicamentos($consulta){
        $conn = getConnection();
        $consulta = strtoupper($consulta);
        try{
            $sql  = " SELECT *";
            $sql .= " from MEDICAMENTO";
            $sql .= " where upper(NOME) like '%$consulta%'";
            $sql .= " and BULA is not null";
            $result = $conn->query($sql);
            if (mysqli_error($conn)) {
                throw new Exception(mysqli_error($conn));
            }

            $medicamentos = array();
            while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                $medicamento = new Medicamento();
                $medicamento->setNome($row['NOME']);
                $medicamento->setApresentacao($row['APRESENTACAO']);
                $medicamento->setBula($row['BULA']);
                $medicamento->setEan1($row['EAN1']);
                $medicamento->setLaboratorio($row['LABORATORIO']);
                $medicamentos[] = $medicamento;
            }
            $result->close();
            return $medicamentos;
        } finally {
            $conn->close();
        }
    }

    /**
     * @param $ean ' Código de barras do medicamento a ser consultado
     *
     * @return Medicamento
     * @throws Exception
     */
    function getDadosMedicamento($ean){
        if ($ean == ""){
            throw new Exception("EAN inválido");
        }
        $conn = getConnection();
        try{
            $sql  = " SELECT *";
            $sql .= " from MEDICAMENTO";
            $sql .= " where EAN1 = '$ean'";
            $result = $conn->query($sql);
            if (mysqli_error($conn)) {
                throw new Exception(mysqli_error($conn));
            }
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $medicamento = new Medicamento();
            $medicamento->setNome($row['NOME']);
            $medicamento->setApresentacao($row['APRESENTACAO']);
            $medicamento->setBula($row['BULA']);
            $medicamento->setEan1($row['EAN1']);
            $medicamento->setLaboratorio($row['LABORATORIO']);

            $result->close();

            return $medicamento;
        }catch (Exception $e){
            throw new Exception("Erro consultando dados do medicamento: ".$e->getMessage());
        }
}
}