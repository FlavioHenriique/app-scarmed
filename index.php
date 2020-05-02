<html>
<?php
include("header.html");
?>
<head>
    <title>Scarmed - Evolução em Saúde</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="icon" href="img/icon.png">
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
        <div class="form-group">
            <br>
            <form method="POST" action="web/controller/UsuarioController.php">
                <div class="row col-sm-6">
                    <div class="col-sm-5">
                        <input id="identificador" name="identificador" type="text" required class="form-control"
                               placeholder="Email, CPF ou telefone"/>
                    </div>
                    <div class="col-sm-5">
                        <input id="senha" name="senha" type="password" required class="form-control"
                               placeholder="Senha"/>
                    </div>
                    <div class="col-sm-2">
                        <input name="btn-login" type="submit" value="Login" class="btn btn-primary" />
                    </div>
                </div>
            </form>
            <a href="cadastroUsuario.php">Cadastre-se</a>
        </div>

    </div>

</body>
<script>
    let url = new URL(window.location.href);
    let msg = url.searchParams.get('message');
    if (msg != null) {
        if (msg == 'sucess') {
            Swal.fire(
                'Pronto!',
                'Usuário cadastrado!',
                'success'
            );
        }else if (msg == 'error'){
            Swal.fire({
                icon: 'error',
                title: 'Opa...',
                text: 'Usuário não cadastrado'
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Opa...',
                text: msg
            });
        }
    }
</script>

</html>