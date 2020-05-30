<?php
    include("header.php");

?>
<html>
<head>
    <title>Scarmed- Recuperação de senha</title>
    <meta charset="UTF-8">
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
</head>
<body>
    <div class="container">
        <h4 class="light">Recuperação de Senha</h4>
        <br>
        <div class="row">
            <div class="col col-md-6">
                <form class="form-group" method="POST" action="web/controller/UsuarioController.php">
                    <div class="row">
                        Para recuperar a sua senha, informe o email cadastrado.
                        <br>
                        Será enviado um código de verificação para o seu email.
                        <br><br>
                        <div class="col-sm-8">
                            <input type="email" name="email" class="form-control input-sm"
                                   placeholder="Email">
                        </div>
                        <div class="col-sm-4">
                            <input type="submit" value="Enviar email" name="btn-esqueci-senha"
                                   class="btn btn-success btn-block">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    let url = new URL(window.location.href);
    let msg = url.searchParams.get('message');
    if (msg != null) {
        Swal.fire({
            icon: 'error',
            title: 'Opa...',
            text: msg
        });
    }
</script>
</html>