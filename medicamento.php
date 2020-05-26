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
        header('Location: inicial.php?message='.$e->getMessage());
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
                    <?php
                    // Lista de intercambialidade só deve ser liberada pra usuários logados
                    if ($_SESSION['usuario'] != null){
                        if (strtoupper($medicamento->getStatus()) == "NOVO"){
                            echo "<h5 class='light'>Este medicamento é de Referência</h5>";
                        }else{
                            echo "<h5 class='light'>Este medicamento é um ".$medicamento->getStatus()."</h5>";
                        }

                        if ($medicamento->getOriginal() != null){

                            $original = $medicamento->getOriginal();
                            echo "Referência: ";
                            ?>
                            <a href="medicamento.php?ean=<?php echo $original->getEan1(); ?>">
                                <?php echo $original->getNome(); ?><br>
                            </a>
                            <?php
                        }else{
                            if (strtoupper($medicamento->getStatus()) != "NOVO"){
                                echo "Não foi encontrado um medicamento de Referência.<br>";
                            }
                        }
                        ?>

                        <?php
                        if ($medicamento->getGenerico() != null){

                            $generico = $medicamento->getGenerico();
                            echo "Genérico - Princípio ativo: ";
                        ?>
                        <a href="medicamento.php?ean=<?php echo $generico->getEan1(); ?>">
                            <?php echo $generico->getNome(); ?></a><br>
                        <?php
                        }else{
                            if (strtoupper($medicamento->getStatus()) != "GENÉRICO"){
                                echo "Não foi encontrado um medicamento Genérico.<br>";
                            }
                        }

                        if ($medicamento->getSimilar() != null){
                            $similar = $medicamento->getSimilar();
                            echo "Similar - Equivalente Intercambiável: ";
                        ?>
                            <a href="medicamento.php?ean=<?php echo $similar->getEan1(); ?>">
                                <?php echo $similar->getNome(); ?><br><br>
                            </a>
                        <?php
                        }else{
                            if (strtoupper($medicamento->getStatus()) != "SIMILAR"){
                                echo "Não foi encontrado um equivalente intercambiável.<br>";
                            }
                        }
                    }
                    ?>
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
                                    $caminhoImg = "branca_c3.jpg";
                                else if (strtoupper($medicamento->getGrupoSubstancia())[0] == "C")
                                    $caminhoImg = "branca.png";

                                echo "<img src='img/receitas/$caminhoImg'/>";
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
</html>