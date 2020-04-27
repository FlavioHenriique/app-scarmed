<html>
<head>
    <title>Cadastro de usuário</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h3 class="light">Cadastro de usuário</h3>
        <div class="form-group">
            <form method="POST" action="web/controller/UsuarioController.php">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required />
                <br>
                <label for="cpf">CPF</label>
                <input type="number" name="cpf" id="cpf" class="form-control"
                       required  maxlength="15"/>
                <br>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required/>
                <br>
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" required/>
                <br>
                <input type="submit" name="bt-cadastro-usuario" value="Cadastrar" class="btn btn-secondary" />
            </form>
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
                'Usuário cadastrado com sucesso!',
                'success'
            );
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
