<?php
require_once 'web/model/Medicamento.php';
//include("header.php");
    session_start();
    if ($_SESSION['acessoRestrito'] == null){
        header("Location: construcao.php");
    }
    /*if ($_GET['operation'] == "sair"){
        $_SESSION['usuario'] = null;
        header("Location: index.php");
}*/
?>
<html>
<head>
    <title>Scarmed - Evolução em Saúde</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/icon2.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/view/scarmed.css"/>
    <style>
        #footer {
            width:100%;
            height:auto;
            background: #0b2e13;
            color: white;
        }

        #consulta{
            font-family: Verdana;
            font-size: 30px;
            background-color: green;
            color: white;
            width: 100%;
            border: 0;
            outline: none;
        }

        ::placeholder {
            color: white;
        }

    </style>
<body>
    <!-- JAVASCRIPT -->
    <script src="js/sweetalert.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script src="js/pooper.min.js"></script>
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
    <?php
        $arrayMedicamentos = $_SESSION['consulta'];
        if ($arrayMedicamentos == null){
            echo "<div class='container-fluid'>";
        }else{
            echo "<div class='container-fluid' style='position: relative;'>";
        }
    include("header.php");
    ?>

    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8 col-sm-8 col-xs-8">
            <a href="index.php"><img src="img/logo2-min.jpeg" class="img-fluid rounded mx-auto d-block"
                 alt="Responsive image" style="display:block; margin: 0 auto; width: 300; height: 180;"/></a>
            <br>
        </div>
        <div class="col-md-2">
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="background-color: green;">
            <br>
            <form action="web/controller/MedicamentoController.php" method="POST" id="formConsulta">
                <div class="row">
                    <div class="col-md-10">
                        <input placeholder="Sintomas, Substâncias, Intercambialidade? Qual sua dúvida?"
                               name="consulta" type="text" id="consulta"/>
                        <input type="submit" name="btn-consulta" id="btn-consulta" style="visibility: hidden;"/>
                    </div>
                    <div class="col-md-2">
                        <img src="img/lupa.png" id="imgLupa"/>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
    <script>
        imgLupa.onclick = function (){
            let bt = document.getElementById('btn-consulta');
            bt.click();
        }
    </script>
        <br>



        <?php
        if ($arrayMedicamentos == null){
            ?>
            <div id="footer" class="row" style="position: absolute; bottom: 0;">
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
        <?php
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
            ?>
                <br><br>
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
            <?php
            }
            unset($_SESSION['consulta']);
            ?>
        </div>
    </div>
</body>
</html>