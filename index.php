<html>
<?php
    include("header.html");
    require_once 'web/model/Medicamento.php';
    require_once 'web/model/Usuario.php';
    session_start();
?>
<head>
    <title>Scarmed - Evolução em Saúde</title>
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

    <div class="container-fluid">
        <div class="form-group">
            <br>
            <?php
                // Obtendo usuário da sessão, caso esteja logado
                $usuario = $_SESSION['usuario'];
                if ($usuario != null){
            ?>
                <form method="POST" action="web/controller/UsuarioController.php" class="form-group">
                    <div class="row col-sm-4">
                        <div class="col-sm-8">
                            <?php echo "Olá, ". $usuario->getNome();?>
                        </div>
                        <div class="col-sm-2">
                            <input type="submit" value="Sair" class="btn btn-link" name="btn-sair">
                        </div>
                    </div>
                </form>
            <?php
                }else{
            ?>
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
        <?php } ?>
            <br>
            <a href="cadastroUsuario.php">Cadastre-se</a>
            <a href="esqueciMinhaSenha.php">Esqueci minha senha</a>
        </div>
        <br><br>
            <form method="POST" action="web/controller/MedicamentoController.php" class="form-group">
                <div class="row">
                    <div class="row col-sm-12">
                        <h4>Consulta de medicamentos</h4>
                        <div class="col-lg-10">
                            <input type="text" name="consulta" class="form-control" required
                                   placeholder="Nome do medicamento ou substância...">
                        </div>
                        <div class="col-lg-2">
                            <input type="submit" class="btn btn-primary" value="Consultar" name="btn-consulta"/>
                        </div>
                        </div>
                </div>
            </form>
        <br>
        <?php
            $arrayMedicamentos = $_SESSION['consulta'];

        if ($arrayMedicamentos == null) {
            echo "<h4>Nenhum medicamento foi encontrado!</h4>";
        }else{
                foreach ($arrayMedicamentos as $item){
                    $ean = $item->getEAN1();
                    ?>
                    <div class="accordion" id="accordionMedicamento">
                        <div class="card">
                            <div class="card-title" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn" type="button" data-toggle="collapse" data-target="#<?php echo 'medicamento'.$ean;?>"
                                            aria-expanded="true" aria-controls="collapseOne">
                                        <?php echo utf8_encode($item->getNome()); ?>
                                    </button>
                                </h2>
                            </div>
                            <div id="<?php echo 'medicamento'.$ean;?>" class="collapse in" aria-labelledby="headingOne" data-parent="#accordionMedicamento">
                                <div class="card-body">
                                    <?php echo nl2br(utf8_encode($item->getBula())); ?>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
                }
            }

        ?>
    </div>
</body>
<script>
    $('.panel-collapse').collapse({
        toggle: false
    });

    let url = new URL(window.location.href);
    let msg = url.searchParams.get('message');
    if (msg != null) {
        if (msg == 'sucess') {

            Swal.fire(
                'Pronto!',
                'Usuário cadastrado!',
                'success'
            );
        } else if (msg == 'cadastroConfirmado'){
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