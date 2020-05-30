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
        .bouton-image:before {
            content: "";
            width: 50px;
            height: 50px;
            background-size: 100% 100%;
            display: inline-block;
            margin-right: 5px;
            vertical-align: text-top;
            background-position : center center;
            background-repeat:no-repeat;
        }

        .monBouton:before{
            background-image : url("img/icon2.png");
        }

        .btn-rounded {
            font-family: Verdana;
            font-size: 20px;
            color: white;
            letter-spacing: 1px;
            line-height: 15px;
            border-radius: 40px;
            background: transparent;
            transition: all 0.3s ease 0s;
            padding: 5% 0;
        }

        #footer {
            position:absolute;
            bottom:0;
            width:100%;
            height:auto;
            background: #0b2e13;
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="text-right">
                    <div class="btn-group">

                        <button type="button" class="btn btn-lg btn-success float-right btn-rounded bouton-image monBouton"
                        style="background-color: #D2DE38;">Olá, faça seu login</button>
                        <button type="button" class="btn btn-lg btn-success dropdown-toggle dropdown-toggle-split
                        float-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                data-trigger="hover" style="background-color: #D2DE38;">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>

                        <div class="dropdown-menu pull-right">
                            <a class="dropdown-item btn-primary" data-toggle="modal"
                               data-target="#loginModal">Login</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="cadastroUsuario.php">Cadastre-se</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="esqueciMinhaSenha.php">Esqueceu sua senha?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8 col-sm-8 col-xs-8">
                <br><br>
                <img src="img/logo2-min.jpeg" class="img-fluid rounded mx-auto d-block"
                     alt="Responsive image" style="display:block; margin: 0 auto; width: 300; height: 180;"/>
                <br>
                <!--form method="POST" action="web/controller/MedicamentoController.php" class="form-group">
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
                                <input type="submit" class="btn btn-success btn-lg float-right" value="Consultar"
                                       name="btn-consulta"/>
                            </div>
                        </div>
                    </div>
                </form-->
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <div class="row">
            <div class="col-12 btn-success">
                <br>
                <p class="text-center" style="font-family: Verdana; font-size: 30px;">
                    <b>Sintomas, Substâncias, Intercambialidade? Qual sua dúvida?</b>
                </p>
                <br>
            </div>
        </div>
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

        <!-- Modal login -->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Login</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="web/controller/UsuarioController.php">
                        <div class="modal-body">
                                <div class="row">
                                    <input id="identificador" name="identificador" type="text" required
                                           class="form-control form-control-sm" placeholder="Informe Email, CPF ou telefone"/>
                                    <br><br>
                                    <input id="senha" name="senha" type="password" required
                                           class="form-control form-control-sm" placeholder="Senha"/>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-success" value="Login" name="btn-login">
                        </div>
                    </form>
                </div>
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