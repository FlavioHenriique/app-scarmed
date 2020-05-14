<?php
    require_once 'web/model/Usuario.php';
    session_start();
    $usuario = $_SESSION['usuario'];
?>
<nav class="navbar navbar-dark bg-primary">
    <a class="navbar-brand" href="index.php">
        <img src="img/icon.png" width="35" height="30" class="d-inline-block align-top" alt="">
        <b>Scarmed</b>
    </a>
    <ul style="list-style: none;">
        <li class="nav-item">
            <?php
            if ($usuario != null){
                ?>
                <label style="color: white;"><b><?php echo "Olá, " . $usuario->getNome();?></b></label>
                &nbsp;&nbsp;
            <a style="color: white;" href="index.php?operation=sair">   Sair</a>
            <?php
            }
            ?>
        </li>
    </ul>
</nav>