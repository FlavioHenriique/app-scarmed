<?php
require_once 'web/model/Medicamento.php';
include("header.php");
    session_start();
    if ($_GET['operation'] == "sair"){
        $_SESSION['usuario'] = null;
        header("Location: index.php");
}
?>
<html>
<head>
    <title>Scarmed - Evolução em Saúde</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/icon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/view/scarmed.css" />

    <!-- JAVASCRIPT -->
    <script src="js/pooper.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

        $('.panel-collapse').collapse({
            toggle: false
        });

        let url = new URL(window.location.href);
        let msg = url.searchParams.get('message');
        if (msg != null) {
            if (msg == 'sucess') {
                console.log("Usuário logado");
            }else if (msg == 'cadastroConfirmado'){
                Swal.fire(
                    'Pronto!',
                    'Seu cadastro foi confirmado com sucesso!',
                    'success'
                );
            } else if(msg == 'senhaCadastrada'){
                Swal.fire(
                    'Pronto!',
                    'Sua nova senha foi cadastrada!',
                    'success'
                );
            }else if (msg == 'error'){
                Swal.fire({
                    icon: 'error',
                    title: 'Erro...',
                    text: 'Usuário não cadastrado'
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Erro...',
                    text: msg
                });
            }
        }
    </script>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-7 col-sm-7 col-xs-7">
                    <br><br>
                    <img src="img/scarmed.png" class="img-fluid rounded mx-auto d-block" alt="Responsive image"
                         style="display:block; margin: 0 auto;">
                    <br>
                    <form method="POST" action="web/controller/MedicamentoController.php" class="form-group">
                        <div class="row">
                            <div class="row col-sm-12">
                                <div class="col-lg-3">
                                    <select class="custom-select my-1 mr-sm-2 form-control form-control-lg"
                                            id="filtro" name="filtro">
                                        <option value="0" selected>Filtros...</option>
                                        <option value="1">Laboratório</option>
                                        <option value="2">Substância</option>
                                        <option value="3">Sintomas</option>
                                    </select>
                                </div>
                                <div class="col-lg-9">
                                    <input type="search" name="consulta" class="form-control"
                                           required placeholder="Consulta">
                                </div>
                                <div class="col-lg-12">
                                    <input type="submit" class="btn btn-primary btn-lg float-right" value="Consultar"
                                           name="btn-consulta"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                </div>
            </div>
            <?php
            $arrayMedicamentos = $_SESSION['consulta'];
            if ($arrayMedicamentos == null){
                exit();
            }
            if (count($arrayMedicamentos) > 0) {
                echo "<h5>Número de medicamentos encontrados: (". count($arrayMedicamentos) .")</h5><br>";
            }
            ?>
            <a name="secaoConsulta"></a>
            <div class="row">
            <?php
            if ($arrayMedicamentos != null){
                foreach ($arrayMedicamentos as $item) {
                    $ean = $item->getEAN1();
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-6" style="margin-bottom:20px;">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item->getNome(); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Apresentação:
                                    <?php echo utf8_encode($item->getApresentacao()); ?></h6>
                                <a href="medicamento.php?ean=<?php echo $ean; ?>" class="card-link">Visualizar detalhes e bula</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            unset($_SESSION['consulta']);
            ?>
        </div>
        </div>
    </body>
</html>
