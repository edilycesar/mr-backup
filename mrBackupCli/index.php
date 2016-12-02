<?php


/*

VIDEO DEMO: https://youtu.be/m26sP7wTGIU

*/


if(sha1($_GET['token']) !== "566236f2404c9e9b3bdcc5fbdf1f1b05f4da56c6"){
    die("Token inválido!!!");
}
require_once 'config.php';
function __autoload($class){
    $file = "class/{$class}.class.php";
    require_once $file;
}
$bkp = new Backup(DB_NAME, DB_USER, DB_PASSWORD, DB_FOLDER_WRITE, DB_TABLES_IGNORE);
$bkp->dump();
echo $bkp->nome_arq;
