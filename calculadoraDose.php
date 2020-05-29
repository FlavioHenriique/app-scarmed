<?php
    include("header.php");
?>
<html>
    <head>
        <title>Calculadora de Dose</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="img/icon-min.png">

        <!-- CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/view/scarmed.css" />

        <!-- JAVASCRIPT -->
        <script src="js/pooper.js"></script>
        <script src="js/sweetalert.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="card col-sm-10">
                    <div class="card-body">
                        <h5 class="card-title"><b>Calculadora de doses</b></h5>

                        <form class="form-group" method="POST" action="web/controller/MedicamentoController.php">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="exampleRadios1" value="1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Comprimido (mg)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="exampleRadios2" value="2">
                                <label class="form-check-label" for="exampleRadios2">
                                    Líquido (ml)
                                </label>
                            </div>
                            <br>
                            <label for="quantidade"><b>Quantidade (mg/ml):</b></label>
                            <input type="number" class="form-control" required name="quantidade" id="quantidade"
                                   step="0.01" min="0" >

                            <label for="horas"><b>Horas:</b></label>
                            <input type="number" class="form-control" required name="horas" id="horas"
                            placeholder="Ex: 8 em 8, 12 em 12">

                            <label for="dias"><b>Dias:</b></label>
                            <input type="number" class="form-control" required name="dias" id="dias">

                            <br>
                            <input type="submit" value="Calcular" name="bt-calcular" id="bt-calcular"
                                   class="btn btn-success">
                        </form>
                        <?php
                        if ($_SESSION['resultado_calculadora'] <> ""){
                            $msg = str_replace(".", ",", $_SESSION['resultado_calculadora']);
                            echo "<h4 class='light' style='text-align: center;'>Você precisa de "
                                . $msg .".</h4>";
                            unset($_SESSION['resultado_calculadora']);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        let url = new URL(window.location.href);
        let msg = url.searchParams.get('message');
        if (msg != null) {
            if (msg != "sucess") {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro...',
                    text: msg
                });
            }
        }
    </script>
</html>