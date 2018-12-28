<?php

/*

  VIDEO DEMO: https://youtu.be/m26sP7wTGIU

 */


require_once 'config.php';

/* * ***** Lista dos clientes - inicio ******
 * ** Exemplos ***
  //Site 1
  $clientes[0] = array('originPath'=> 'http://atomicmail.com.br/mrBackupCli/tmp/',
  'urlCli'=> 'http://atomicmail.com.br/mrBackupCli/index.php?token=banana');

  //Site 2
  $clientes[1] = array('originPath'=> 'http://localhost:8080/edily/mrBackup/mrBackupCli/tmp/',
  'urlCli'=> 'http://localhost:8080/edily/mrBackup/mrBackupCli/index.php?token=banana');

 * ***** Lista dos clientes - fim ******
 */

//Exemplo
$clientes = [
    [
        'name' => 'Komail',
        'originPath' => 'http://korumweb.ddns.net/mrBackupCliKomail/tmp/',
        'urlCli' => 'http://korumweb.ddns.net/mrBackupCliKomail/index.php?token=yhgfetrsbfpridgfj125'
    ],
    [
        'name' => 'Korum comercial',
        'originPath' => 'http://korumweb.ddns.net/mrBackupCliComercial/tmp/',
        'urlCli' => 'http://korumweb.ddns.net/mrBackupCliComercial/index.php?token=yhgfetrsbfpridgfj125'
    ],
    [
        'name' => 'CPFagora',
        'originPath' => 'https://cpfagora.com.br/mrBackupCli/tmp/',
        'urlCli' => 'https://cpfagora.com.br/mrBackupCli/index.php?token=bananaloka'
    ],
    [
        'name' => 'Psycare',
        'originPath' => 'https://psycare.gestordecliente.com.br/mrBackupCli/tmp/',
        'urlCli' => 'https://psycare.gestordecliente.com.br/mrBackupCli/index.php?token=566236f2404c9r9b3bdcc5fbdf1f1b05f4da56c6'
    ]
];

$bkp = new Backup();
$bkp->destinationPath = FOLDER_DESTINATION;

foreach ($clientes as $cliente) {
    $bkp->setName($cliente['name'])
            ->setOriginPath($cliente['originPath'])
            ->setUrlCli($cliente['urlCli'])
            ->executa();
}

echo "\n";
