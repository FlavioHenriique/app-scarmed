<html>
<head>
    <title>Cadastro de usuário</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/icon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datepicker.min.css"/>
    <link rel="stylesheet" href="css/view/scarmed.css"/>


</head>
<body>
<!-- JAVASCRIPT -->
<script src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/datepicker.min.js"></script>
<script src="js/view/cadastroUsuario.js"></script>
<br>
    <div class="container">
        <div class="row">
            <div class="form-group col-md-8 col-sm-12 border rounded form-custom">
                <h3 class="light">Cadastro de usuário</h3>
                <!-- Form de cadastro de Usuário -->
                <form method="POST" action="web/controller/UsuarioController.php">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" required/>
                    <br>
                    <label class="control-label" for="data">Data de nascimento</label>
                    <input class="form-control" id="data" name="data" placeholder="DD/MM/YYYY"
                           required type="text" autocomplete="off"/>
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
                    <label for="telefone">Telefone</label>
                    <input type="text" required maxlength="15" name="telefone" id="telefone"
                           class="form-control" />
                    <br>
                    <label for="cep">Cep</label>
                    <input type="text" name="cep" id="cep" class="form-control" required/>
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ehProfissional"
                               onclick="marcaEhProfissional()">
                        <label class="form-check-label" for="ehProfissional">Sou um profissional</label>
                    </div>
                    <br>
                    <label for="numInscricao">Número de inscrição do Conselho</label>
                    <input type="text" class="form-control" name="numInscricao" id="numInscricao"/>
                    <br>
                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tipo de inscrição</label>
                    <select class="custom-select my-1 mr-sm-2" id="tipoInscricao" name="tipoInscricao">
                        <option value="0" selected>Selecione...</option>
                        <option value="1">CRF - Conselho Regional de Farmácia</option>
                        <option value="2">CFF - Conselho Federal de Farmácia</option>
                        <option value="3">CRM - Conselho Regional de Medicina</option>
                        <option value="4">CFM - Conselho Federal de Medicina</option>
                    </select>
                    <br><br>
                    <input type="submit" name="bt-cadastro-usuario" value="Cadastrar" class="btn btn-success" />
                    <a class="btn btn-secondary" href="inicial.php">Voltar ao login</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>