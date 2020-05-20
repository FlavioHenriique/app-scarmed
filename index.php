<html>
<?php
    require_once 'web/model/Medicamento.php';
    require_once 'web/model/Usuario.php';

    include("header.php");
    session_start();
    if ($_GET['operation'] == "sair"){
        $_SESSION['usuario'] = null;
        header("Location: index.php");
    }
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
</head>
<body>
    <div class="container">
        <div class="form-group">
            <br>
            <?php
                // Obtendo usuário da sessão, caso esteja logado
                session_start();
                $usuario = $_SESSION['usuario'];
                if ($usuario == null) {
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
            <?php
                }
            ?>

            <a href="cadastroUsuario.php">Cadastre-se</a>
            <br>
            <a href="esqueciMinhaSenha.php">Esqueci minha senha</a>
        </div>
        <br><br>
            <form method="POST" action="web/controller/MedicamentoController.php" class="form-group">
                <div class="row">
                    <h4>Consulta de medicamentos</h4>
                    <div class="row col-sm-12">
                        <div class="col-lg-2">
                            <select class="custom-select my-1 mr-sm-2" id="filtro" name="filtro">
                                <option value="0" selected>Filtros...</option>
                                <option value="1">Laboratório</option>
                                <option value="2">Substância</option>
                                <option value="3">Sintomas</option>
                            </select>
                        </div>
                        <div class="col-lg-8">
                            <input type="search" name="consulta" class="form-control" required
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
        if ($arrayMedicamentos == null){
            exit();
        }
            if (count($arrayMedicamentos) > 0) {
                echo "<h5>Número de medicamentos encontrados: (". count($arrayMedicamentos) .")</h5>";
            }
        ?>
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