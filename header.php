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
        font-size: 15px;
        color: white;
        letter-spacing: 1px;
        line-height: 15px;
        border-radius: 40px;
        background: transparent;
        transition: all 0.3s ease 0s;
        padding: 5% 0;
    }

    #footer {
        width:100%;
        height:auto;
        background: #0b2e13;
        color: white;
    }
</style>
<?php
    require 'web/model/Usuario.php';
    session_start();
    $usuario = unserialize(serialize($_SESSION['usuario']));
?>

<div class="row">
    <div class="col-12">
        <div class="text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-lg btn-success float-right btn-rounded bouton-image monBouton"
                        style="background-color: #D2DE38;">
                    <?php
                    if ($usuario != null){
                        echo 'Olá, '.$usuario->getNome();
                    }else {
                        echo "Olá, faça seu login";
                    }
                    ?>
                </button>
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
                    <div class="dropdown-divider"></div>
                    <?php
                      if ($usuario != null){
                    ?>
                      <form method="POST" action="web/controller/UsuarioController.php" id="formSair">
                          <input type="submit" style="visibility: hidden;" name="btn-sair" id="btSair"/>
                          <a class="dropdown-item" href="#"
                             onclick="btSair.click();">Sair</a>
                      </form>
                    <?php
                      }
                    ?>
                </div>
            </div>
        </div>
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