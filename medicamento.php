<html>
<?php
include("header.html");
require_once 'web/model/Medicamento.php';
require_once 'web/dao/MedicamentoDAO.php';

    session_start();
    $ean = $_GET['ean'];
    $dao = new MedicamentoDAO();
    $medicamento = $dao->getDadosMedicamento($ean);
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
                    <h5 class="card-title"><?php echo $medicamento->getNome();?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Apresentação:
                        <?php echo $medicamento->getApresentacao();?> </h6>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Laboratório:
                        <?php echo $medicamento->getLaboratorio()?> </h6>
                    <br>
                    <p class="card-text"><?php echo utf8_encode($medicamento->getBula());?></p>
                    <a href="index.php? $ean; ?>" class="card-link">Visualizar medicamento</a>
                </div>
            </div>

        </div>
    </div>
</body>
</html>