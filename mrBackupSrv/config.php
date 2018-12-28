<?php
ini_set("display_errors", true);

define('FOLDER_DESTINATION',  __DIR__ . '/backups');//permissão de gravação

function __autoload($class){
    $file = "class/{$class}.class.php";
    require_once $file;
}