<?php
    require_once 'web/model/Medicamento.php';
    require_once 'web/dao/MedicamentoDAO.php';

    session_start();
    $ean = $_GET['ean'];
    try{
        if ($ean == "")
            throw new Exception("Produto inválido.");
        $dao = new MedicamentoDAO();
        $medicamento = $dao->getDadosMedicamento($ean);
        unset($_SESSION['consulta']);
    }catch(Exception $e){
        header('Location: inicial.php?message='.$e->getMessage());
    }
?>
<html>
<head>
    <title>Detalhes - <?php echo $medicamento->getNome();?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/icon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/view/scarmed.css" />

    <!-- JAVASCRIPT -->
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script src="js/pooper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<style>
    .medicamentos{
        background-color: #43a047;
        color: white;
    }

    .linha{
        width: 100%;
        color: black;
        height: 0.5px;
        background-color:black;
    }
</style>
<body>
<?php
    include("header.php");
?>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8 col-sm-8 col-xs-8">
            <a href="index.php">
                <img src="img/logo2-min.jpeg" class="img-fluid rounded mx-auto d-block"
                     alt="Responsive image" style="display:block; margin: 0 auto; width: 200; height: 120;"/>
            </a>
            <br>
        </div>
        <div class="col-md-2">
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 medicamentos">
                <?php echo "<h4 class='text-center'>".$medicamento->getNome()."</h4>"; ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 medicamentos">
                <h6 class="text-center">Remédios equivalentes</h6>
            </div>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color: green; color: white;">
                    <tr>
                        <th scope="col">Referência</th>
                        <th scope="col">Princípio Ativo</th>
                        <th scope="col">Equivalente intercambiável</th>
                        <th scope="col">
                            <a href="intercambialidade.php" style="color: white;">
                                O que é intercambialidade?
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tr style="background-color:#b2ff59 ;">
                        <th scope="col">
                            <?php
                            if ($medicamento->getOriginal() != null) {
                                $original = $medicamento->getOriginal();
                                echo "<a href='medicamento.php?ean=".$original->getEan1()
                                    ."'>".$original->getNome()."</a>";
                            }
                            ?>
                        </th>
                        <th scope="col">
                            <?php
                            if ($medicamento->getGenerico() != null){
                                $similar = $medicamento->getGenerico();
                                echo "<a href='medicamento.php?ean=".$similar->getEan1()
                                    ."'>".$similar->getNome()."</a>";
                            }
                            ?>
                        </th>
                        <th scope="col">
                            <?php
                            if ($medicamento->getSimilar() != null){
                                $similar = $medicamento->getSimilar();
                                echo "<a href='medicamento.php?ean=".$similar->getEan1()
                                    ."'>".$similar->getNome()."</a>";
                            }
                            ?>
                        </th>
                        <th scope="col">Listar todos</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 medicamentos">
                <h6 class="text-center">Bula</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <?php echo "<h4><b>".$medicamento->getNome()."</b></h4>"; ?>
            </div>
            <div class="col-md-2">
                <a href="#" class="btn btn-success">Bula do profissional</a>
            </div>
        </div>

        <hr class="linha">

        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Produto</th>
                        <th scope="col">Fabricante</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Precisa de Receita</th>
                        <th scope="col">Tipo de Receita</th>
                        <th scope="col">Categoria</th>
                    </tr>
                    </thead>
                    <tr>
                        <th><?php echo $medicamento->getNome(); ?></th>
                        <th><?php echo $medicamento->getLaboratorio(); ?></th>
                        <!-- TIPO DE RECEITA -->
                        <th>
                            <?php
                                if ($medicamento->getOriginal() == null){
                                    echo "Referência";
                                }else if ($medicamento->getSimilar() == null){
                                    echo "Similar";
                                }else if ($medicamento->getGenerico() == null){
                                    echo "Genérico";
                                }
                            ?>
                        </th>
                        <!-- PRECISA DE RECEITA? -->
                        <th>
                            <?php
                                $grupos = array("A1","A2","A3","B1","B2","C1","C2","C3","C4","C5","D1","D2");
                                $precisaDeReceita = in_array(strtoupper($medicamento->getGrupoSubstancia()), $grupos);
                                if ($precisaDeReceita == true){
                                    echo "SIM";
                                }else{
                                    echo "NÃO";
                                }
                            ?>
                        </th>
                        <!--TIPO DE RECEITA -->
                        <th>
                            <?php
                            $grupo = strtoupper($medicamento->getGrupoSubstancia());
                                if ($precisaDeReceita == true){
                                    if ($grupo[0] = "A"){
                                        echo "Amarela";
                                    }else if ($grupo == "B1"){
                                        echo "Azul B1";
                                    }else if ($grupo == "B2"){
                                        echo "Azul B2";
                                    }else if ($grupo == "C3"){
                                        echo "Branca C3";
                                    }
                                }else{
                                    echo "-";
                                }
                            ?>
                        </th>
                        <th>-</th>
                    </tr>
                </table>
            </div>
        </div>

        <hr class="linha">

        <div class="row">
            <div class="col-12">
                <?php echo "<h5><b>".$medicamento->getNome().", para o que é indicado e para que serve?</b></h5>"; ?>
                <br>
                Informações da bula aqui ...
            </div>
        </div>

        <div class="row">
            <div class="col-12" align="justify">
                <hr class="linha" />
                <h5 class="text-center"><b>SE PERSISTIREM OS SINTOMAS, PROCURE O <br>
                        MÉDICO E O FARMACÊUTICO. LEIA A BULA.</b></h5><br>
                <h6 class="text-center">Todas as informações contidas neste site têm a intenção de informar e educar, não pretendendo, de forma alguma,<br>
                substituir as orientações de um profissional médico ou servir como recomendação para qualquer tipo de tratamento.<br>
                Decisões relacionadas ao tratamento de pacientes devem ser tomadas por profissionais autorizados, considerando <br>
                    as características particulares de cada pessoa.</h6><br>

                <h6 class="text-center">Farmacêutico responsável: Dr. Antônio Paulo da Nóbrega Neto CRF/PB 5901 | Grupo APPNOBR ME | CNPJ/MF 01.001/0001-01 | <br>
                Av. Ministro José Américo de Almeida, nº 1153, Sala 201, 1º Andar, Residencial Manoel Paulo da Costa | CEP 58040-300</h6>
            </div>
        </div>
        <div id="footer" class="row">
            <div class="col-5">
                <a href="termosECondicoes.php" style="color: white;">Termos de uso e condições gerais</a>
            </div>
            <div class="col-2" style="text-align: center;">
                Scarmed | &#0169; 2020
            </div>
            <div class="col-5" style="text-align: right;">
                <a href="politicaPrivacidade.php" style="color: white;">Política de privacidade</a>
            </div>
        </div>
    </div>

</body>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>

</html>