<html>
<?php
include("header.php");
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
        header('Location: index.php?message='.$e->getMessage());
    }
?>
<head>
    <title>Detalhes - <?php echo $medicamento->getNome();?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/icon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/view/scarmed.css" />

    <!-- JAVASCRIPT -->
    <script src="js/sweetalert.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
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
                                    <button class="btn " data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
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
                    <br><br>
                    <h4 class="light">Bula</h4>
                    <p class="card-text"><?php echo nl2br($medicamento->getBula());?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>