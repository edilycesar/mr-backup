<?php


/*

VIDEO DEMO: https://youtu.be/m26sP7wTGIU

*/


require_once 'config.php';

/* ****** Lista dos clientes - inicio ******
*** Exemplos ***
//Site 1
$clientes[0] = array('originPath'=> 'http://atomicmail.com.br/mrBackupCli/tmp/',
                     'urlCli'=> 'http://atomicmail.com.br/mrBackupCli/index.php?token=banana');

//Site 2
$clientes[1] = array('originPath'=> 'http://localhost:8080/edily/mrBackup/mrBackupCli/tmp/',
                     'urlCli'=> 'http://localhost:8080/edily/mrBackup/mrBackupCli/index.php?token=banana');

****** Lista dos clientes - fim ******
*/

//Exemplo
$clientes[0] = array('originPath'=> 'http://atomicmail.com.br/mrBackupCli/tmp/',
                     'urlCli'=> 'http://atomicmail.com.br/mrBackupCli/index.php?token=banana');


$bkp = new Backup();
$bkp->destinationPath = FOLDER_DESTINATION;

foreach ($clientes as $cliente) {
    $bkp->originPath = $cliente['originPath'];
    $bkp->urlCli = $cliente['urlCli'];
    $bkp->pegaNomeArquivo();
    $bkp->destinationFileName = $bkp->originFileName;
    $bkp->destinationFullPath = $bkp->destinationPath . '/' . $bkp->destinationFileName;
    $bkp->pegaArquivo();
}
