<?php

function getConnection(){
    // 1 = PRODUCAO , 2 = TESTES
    $versao = 1;
    if ($versao == 2) {
        $dbhost = 'localhost';
        $dbusername = "root";
        $dbpassword = "flavio22";
        $db = "teste";
    }else{
        $dbhost = 'scarmed.mysql.uhserver.com';
        $dbusername = "scarmed";
        $dbpassword = "Scar2k19@";
        $db = "scarmed";
    }

    $mysqli = mysqli_connect($dbhost, $dbusername, $dbpassword, $db);
    return $mysqli;
}