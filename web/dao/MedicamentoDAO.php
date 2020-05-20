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
    public function consultaMedicamentos($consulta, $filtro){
        $consulta = strtoupper($consulta);
        if (is_numeric($consulta)){
            $medicamentos = array();
            $medicamentos[] = $this->getDadosMedicamento($consulta);
            return $medicamentos;
        }
        try{
            $conn = getConnection();
            if ($filtro == 0){
                $sql  = "( SELECT *";
                $sql .= " from MEDICAMENTO";
                $sql .= " where upper(NOME) like '%$consulta%'";
                $sql .= " and APRESENTACAO like '% INJ %'"; // Consultando um item injetável (INJ)
                $sql .= " limit 1)";
                $sql .= "union";
                $sql .= "( SELECT *";
                $sql .= " from MEDICAMENTO";
                $sql .= " where upper(NOME) like '%$consulta%'";
                $sql .= " and APRESENTACAO like '% X %'"; // Consultando um item de comprimido (X 14, X 18)
                $sql .= " limit 1)";
            }else if($filtro == 1){
                // Laboratório
                $sql  = "SELECT *";
                $sql .= " from MEDICAMENTO";
                $sql .= " where upper(LABORATORIO) like '%$consulta%'";
            }else if ($filtro == 2){
                $sql  = "SELECT * ";
                $sql .= " from MEDICAMENTO";
                $sql .= " where upper(SUBSTANCIA) like '%$consulta%'";
            }
            error_log($sql);
            $result = $conn->query($sql);
            if (mysqli_error($conn)) {
                throw new Exception(mysqli_error($conn));
            }

            $medicamentos = array();
            while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                $medicamento = $this->montaObjetoMedicamento($row);
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
            if ($result->num_rows <= 0)
                throw new Exception("Produto com código de barras $ean não encontrado!");
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $medicamento = $this->montaObjetoMedicamento($row);
            $medicamento->setSubstancias(explode(';', utf8_encode($row['SUBSTANCIA'])));
            $this->preencheDadosIntercambialidade($medicamento, $conn);
            $result->close();

            return $medicamento;
        }catch (Exception $e){
            throw new Exception("Erro consultando dados do medicamento: ".$e->getMessage());
        }
}

    public function montaObjetoMedicamento($row){
        $medicamento = new Medicamento();
        $medicamento->setNome(utf8_encode($row['NOME']));
        $medicamento->setApresentacao(utf8_encode($row['APRESENTACAO']));
        $medicamento->setBula(utf8_encode($row['BULA']));
        $medicamento->setEan1($row['EAN1']);
        $medicamento->setLaboratorio(utf8_encode($row['LABORATORIO']));
        $medicamento->setStatus(utf8_encode($row['STATUS']));
        if ($medicamento->getStatus()[0] == "G"){
            $medicamento->setStatus("GENÉRICO");
        }
        return $medicamento;
    }

    /**
     *
     *
     * @param $ean
     * @param $conn
     * @throws Exception
     */
    public function preencheDadosIntercambialidade(Medicamento $medicamento, $conn){
        try{
            if ($medicamento == null){
                throw new Exception("Código de barras inválido");
            }
            $sql  = " SELECT SUBSTANCIA, STATUS";
            $sql .= " from MEDICAMENTO";
            $sql .= " where EAN1 = '". $medicamento->getEan1() . "'";

            $result = $conn->query($sql);
            if ($result->num_rows <= 0)
                throw new Exception("Produto com código de barras "
                    .$medicamento->getEan1()." não encontrado!");
            $row = $result->fetch_array(MYSQLI_ASSOC);

            // Obtendo substâncias e o status do medicamento consultado
            $substancia = $row['SUBSTANCIA'];
            $status = $row['STATUS'];

            $tipo1 = "";
            $tipo2 = "";

            if ($status[0] == "G"){
                $status = "GENÉRICO";
            }

            if (strtoupper($status) == "NOVO"){
                // É um medicamento Original, deve ser consultado um similar e um genérico
                $tipo1 = " and upper(STATUS) = 'SIMILAR'";
                $tipo2 = " and upper(STATUS) = 'GENÉRICO'";

            }else if (strtoupper($status) == "GENÉRICO"){
                // É um medicamento Genérico, deve ser consultado um similar e um original
                $tipo1 = " and upper(STATUS) = 'SIMILAR'";
                $tipo2 = " and upper(STATUS) = 'NOVO'";

            }else if (strtoupper($status) == "SIMILAR"){
                // É um medicamento Similar, deve ser consultado um genérico e um original
                $tipo1 = " and upper(STATUS) = 'NOVO'";
                $tipo2 = " and upper(STATUS) = 'GENÉRICO'";
            }

            $sql  = " (SELECT *";
            $sql .= " from MEDICAMENTO";
            $sql .= " where upper(SUBSTANCIA) = '$substancia'";
            $sql .= $tipo1;
            $sql .= " limit 1)";
            $sql .= " union";
            $sql .= " (SELECT *";
            $sql .= " from MEDICAMENTO";
            $sql .= " where upper(SUBSTANCIA) = '$substancia'";
            $sql .= $tipo2;
            $sql .= " limit 1)";
            $sql = utf8_decode($sql);
            $result = $conn->query($sql);

            if ($result->num_rows > 0){
                $intercambialidade = array();
                while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $upperStatus = strtoupper($row["STATUS"]);

                    if ($upperStatus[0] == "G"){
                        $upperStatus = "GENÉRICO";
                    }
                    if ($upperStatus == "NOVO"){
                        $medicamento->setOriginal($this->montaObjetoMedicamento($row));

                    }else if($upperStatus == "SIMILAR"){
                        $medicamento->setSimilar($this->montaObjetoMedicamento($row));

                    }else if ($upperStatus == "GENÉRICO"){
                        $medicamento->setGenerico($this->montaObjetoMedicamento($row));
                    }
                }
            }
            $result->close();
        }catch (Exception $e){
            throw new Exception("Erro consultando dados de intercambialidade: "
                .$e->getMessage());
        }
    }
}