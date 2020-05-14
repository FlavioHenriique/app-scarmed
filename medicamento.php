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
    }catch(Exception $e){
        header('Location: index.php?message='.$e->getMessage());
    }

?>
<head>
    <title>Detalhes - <?php echo utf8_encode($medicamento->getNome());?></title>
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
                    <h5 class="card-title"><b><?php echo utf8_encode($medicamento->getNome());?></b></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Apresentação:
                        <?php echo $medicamento->getApresentacao();?> </h6>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Laboratório:
                        <?php echo utf8_encode($medicamento->getLaboratorio());?> </h6>
                    <br>
                    <p class="card-text"><?php echo nl2br(utf8_encode($medicamento->getBula()));?></p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>