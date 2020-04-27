<html>

<head>
    <title>Scarmed</title>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo.jpeg">
    <link rel="stylesheet" href="css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</head>
<body>
    <h3 class="light">Integração </h3>
    <div class="container-fluid">
        <div class="row">
            <div class="form-group">
                <form method="POST" action="web/controller/UsuarioController.php">
                    <div class="row">
                        <div class="col">
                            <label for="email">Email, telefone ou CPF</label>
                            <input id="email" name="email" type="email" required class="form-control"/>
                        </div>
                        <div class="col">
                            <label for="senha">Senha</label>
                            <input id="senha" name="senha" type="password" required class="form-control"/>
                        </div>
                        <div class="col">
                            <br>
                            <input name="btn-login" type="submit" value="Login" class="btn btn-primary" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <a href="cadastroUsuario.php" class="btn btn-primary">Cadastrar</a>
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