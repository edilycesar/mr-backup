<?php
ini_set("display_errors", true);

define('FOLDER_DESTINATION', 'backups');//permissão de gravação

function __autoload($class){
    $file = "class/{$class}.class.php";
    require_once $file;
}