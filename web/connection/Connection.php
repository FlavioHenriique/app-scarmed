<?php
/**
 * Esta função é responsável por retornar uma conexão com um
 * banco de dados mysql.
 *
 * @return false|mysqli
 */
function getConnection(){
    // 1 = PRODUCAO , 2 = TESTES
    $versao = ($_SERVER['HTTP_HOST'] == 'localhost') ? 2 : 1;

    if ($versao == 2) {
        $dbhost = 'localhost';
        $dbusername = "root";
        $dbpassword = "flavio22";
        $db = "scarmed";
    }else{
        $dbhost = 'scarmed.mysql.uhserver.com';
        $dbusername = "scarmed";
        $dbpassword = "Scar2k19@";
        $db = "scarmed";
    }

    $mysqli = mysqli_connect($dbhost, $dbusername, $dbpassword, $db);
    return $mysqli;
}