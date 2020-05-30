<html>
<head>
    <title>Scarmed - Evolução em Saúde</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/icon2.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>

    <!-- JAVASCRIPT -->
    <script src="js/sweetalert.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script src="js/pooper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <script>
        let url = new URL(window.location.href);
        let msg = url.searchParams.get('message');
        if (msg != null){
            Swal.fire(
                'Erro...',
                msg,
                'error'
            );
        }
    </script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- ACESSO A PAGINA -->
                <div class="text-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark"
                        data-toggle="modal" data-target="#acessoRestritoModal">Acesso restrito</button>
                    </div>
                </div>

                <!-- LOGO E MENSAGEM -->
                <br><br><br>
                <img src="img/logo-construcao-min.jpeg" class="img-fluid rounded mx-auto d-block"
                     alt="Responsive image" style="display:block; margin: 0 auto; width: 300; height: 180;"/>
                <br><br>


                <!-- acessoRestritoModal -->
                <div class="modal fade" id="acessoRestritoModal" tabindex="-1" role="dialog" aria-labelledby="acessoRestritoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="acessoRestritoModalLabel">Acesso Restrito</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="web/controller/UsuarioController.php">
                                <div class="modal-body">
                                    <div class="row">
                                        <input id="usuario" name="usuario" type="text" required
                                               class="form-control form-control-sm" placeholder="Informe seu usuário"/>
                                        <br><br>
                                        <input id="senha" name="senha" type="password" required
                                               class="form-control form-control-sm" placeholder="Informe sua Senha"/>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <input type="submit" class="btn btn-success" value="Entrar" name="btn-acesso-restrito">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>