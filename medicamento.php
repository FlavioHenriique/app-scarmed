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
            <div class="col-12" style="background-color: #43a047; color: white;">
                <?php echo "<h4 class='text-center'>".$medicamento->getNome()."</h4>"; ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12" style="background-color: #43a047; color: white;">
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
                        <th scope="col">O que é intercambialidade?</th>
                    </tr>
                    </thead>
                    <tr style="background-color:#b2ff59 ;">
                        <th scope="col">
                            <?php
                            if ($medicamento->getOriginal() != null) {
                                $original = $medicamento->getOriginal();
                                echo "<a href='medicamento.php?ean=".$original->getNome()
                                    ."'>".$original->getNome()."</a>";
                            }
                            ?>
                        </th>
                        <th scope="col">Princípio Ativo</th>
                        <th scope="col">
                            <?php
                            if ($medicamento->getSimilar() != null){
                                $similar = $medicamento->getSimilar();
                                echo "<a href='medicamento.php?ean=".$similar->getNome()
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
            <div class="col-12">
                <hr style="width: 100%; color: black; height: 0.5px; background-color:black;" />
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
                Termos de uso e condições gerais
            </div>
            <div class="col-2" style="text-align: center;">
                Scarmed | &#0169; 2020
            </div>
            <div class="col-5" style="text-align: right;">
                Política de privacidade
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="card col-sm-10">
                <div class="card-body">
                    <h5 class="card-title"><b><?php echo $medicamento->getNome();?></b></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Apresentação:
                        <?php echo $medicamento->getApresentacao(); ?> </h6>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Laboratório:
                        <?php echo $medicamento->getLaboratorio();?> </h6>
                    <br>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne" style="background-color: white;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Lista de substâncias
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse in" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <?php
                                    for ($i = 0; $i < count($medicamento->getSubstancias()); $i ++){
                                        echo '* '.$medicamento->getSubstancias()[$i]; ?> <br>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <br>
                    <h4 class="light">Bula</h4>
                    <p class="card-text"><?php echo nl2br($medicamento->getBula());?></p>
                    <br>
                    <?php
                    if (($_SESSION['usuario'] != null) and ($medicamento->getGrupoSubstancia() != null)){
                    ?>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne" style="background-color: white;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseGrupoSubstancia"
                                            aria-expanded="true" aria-controls="collapseGrupoSubstancia">
                                        Tipo de receita: <?php echo $medicamento->getGrupoSubstancia();?>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseGrupoSubstancia" class="collapse in"
                                 aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                <?php
                                echo "Tipo de receita: <b>".$medicamento->getGrupoSubstancia()."</b><br>";
                                $caminhoImg = "";

                                if (strtoupper($medicamento->getGrupoSubstancia())[0] == "A")
                                    $caminhoImg = "amarela.png";
                                else if (strtoupper($medicamento->getGrupoSubstancia()) == "B1")
                                    $caminhoImg = "azul_b1.jpg";
                                else if (strtoupper($medicamento->getGrupoSubstancia()) == "B2")
                                    $caminhoImg = "azul_b2.png";
                                else if (strtoupper($medicamento->getGrupoSubstancia()) == "C3")
                                    $caminhoImg = "branca_c3.jpeg";
                                else if (strtoupper($medicamento->getGrupoSubstancia())[0] == "C")
                                    $caminhoImg = "branca.png";

                                echo "<img src='img/receitas/$caminhoImg' data-toggle='popover' title='Teste - balão com informações' 
                                       data-content='Conteúdo das informações' data-trigger='hover'/>";
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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