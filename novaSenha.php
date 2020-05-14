<?php
include("header.php");
?>
<html>
<head>
    <title>Scarmed- Nova senha</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/icon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/view/scarmed.css" />

    <!-- JAVASCRIPT -->
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid">
    <h4 class="light">Definição da nova senha</h4>
    <br>
    <div class="row">
        <div class="col col-md-6">
            <form class="form-group" method="POST" action="web/controller/UsuarioController.php">
                Informe a nova senha para o usuário <b><?php echo $_GET['email'];?></b>
                <div class="row">
                    <div class="col-sm-4">
                        <input type="password" name="senha" class="form-control input-sm"
                               placeholder="Nova senha" required>
                        <input type="hidden" name="email" value="<?php echo $_GET['email'];?>"/>
                    </div>
                    <div class="col-sm-4">
                        <input type="password" name="confirmaSenha" class="form-control input-sm"
                               placeholder="Confirme a nova senha" required>
                    </div>
                    <div class="col-sm-4">
                        <input type="submit" value="Cadastrar senha" name="btn-nova-senha"
                               class="btn btn-primary btn-block">
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