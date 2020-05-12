<?php
require_once __DIR__.'/../connection/Connection.php';
require_once __DIR__.'/../model/Medicamento.php';

class MedicamentoDAO{

    /**
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
                $medicamentos[] = $medicamento;
            }
            $result->close();
            return $medicamentos;
        } finally {
            $conn->close();
        }
    }
}