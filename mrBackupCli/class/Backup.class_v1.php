<?php

/*
 * @param 
 *      String path PATH ONDE OS ARQUIVOS SERÃO GRAVADOS NO SERVIDOR;
 *      nome_arq_zip NOME DO ARQUIVO COMPACTADO PARA DOWNLOAD;
 *      dir_origem_path CAMINHO DO DIRETÓRIO QUAL SERÁ FEITO O BACKUP.
 * 
 */

class Backup extends FtpLoko
{

    public $path = "",
            $nome_arq = "",
            $nome_arq_zip = "",
            $super_query,
            $email = "",
            $erro,
            $banco = "",
            $usuario = "",
            $senha = "",
            $dir_origem_path,
            $email_destino = "",
            $email_padrao = "",
            $nome = "",
            $ignoreTabelas,
            $host

    ;

    public function __construct($name, $user, $password, $folder, $tablesIgnore, $host = 'localhost')
    {
        $this->setConfigs($name, $user, $password, $folder, $host);
    }

    public function setConfigs($name, $user, $password, $folder, $host)
    {
        $this->setCredenciais($name, $user, $password, $folder, $host);
        $this->path = $folder;
        $this->nome_arq = date("d-m-Y_H-i-s") . "_" . $this->banco . ".sql.bkp";
        $this->nome_arq_zip = $this->nome_arq . ".zip";
    }

    public function setCredenciais($name, $user, $password, $folder, $host)
    {
        $this->usuario = $user;
        $this->senha = $password;
        $this->banco = $name;
        $this->path = $folder;
        $this->host = $host;
    }

    public function dump()
    {
        $tIgnore = str_replace(",", " ", DB_TABLES_IGNORE);
        $cmd = "mysqldump -u{$this->usuario} -p'{$this->senha}' --databases {$this->banco} ";
        $cmd .= !empty($tIgnore) ? " --ignore-table={$this->banco}.{$tIgnore}" : "";
        $ret = shell_exec($cmd);
        $ret .= "-- Comando: " . $cmd;
        $file = $this->path . $this->nome_arq;
        return file_put_contents($file, $ret, FILE_APPEND);
    }

    public function ApagarArquivos()
    {
        if (file_exists($this->path . $this->nome_arq)) {
            unlink($this->path . $this->nome_arq);
        }
        if (file_exists($this->path . $this->nome_arq_zip)) {
            unlink($this->path . $this->nome_arq_zip);
        }
    }

    public function CompactaArquivo()
    {
        try
        {
            $arq = $this->path . $this->nome_arq;
            $arq_zip = $this->path . $this->nome_arq_zip;
            $zip = new ZipArchive();
            if ($zip->open($arq_zip, ZipArchive::CREATE)) {
                echo "<br/> Arquivo zip aberto com sucesso";
            } else {
                die("Erro ao abrir ou criar arquivo zip");
            }
            if ($zip->addFile($arq)) {
                echo "<br/> Arquivo zip add com sucesso";
            } else {
                die("Erro ao add arquivo zip " . $arq);
            }
            $zip->close();
            return $arq_zip;
        } catch (Exception $exc)
        {
            echo $exc->getTraceAsString();
            return 0;
        }
    }

    public function compactaArquivo2()
    {
        $destino = $this->path . "/" . $this->nome_arq_zip;
        $origem = $this->path . "/" . $this->nome_arq;
        $cmd = "zip {$destino} {$origem}";
        echo shell_exec($cmd);
    }

    public function CompactaDir()
    {
        try
        {
            $zip = new ZipArchive();
            if (!$zip->open($this->path . $this->nome_arq_zip, ZipArchive::CREATE)) {
                echo "<br/>Erro ao criar arquivo zip";
            }
            //$this->AddAttachment($this->path.$this->nome_arq_zip);
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->dir_origem_path));
            // itera cada pasta/arquivo contido no diretÃ³rio especificado
            foreach ($iterator as $key => $value) {
                // adiciona o arquivo ao .zip
                $zip->addFile(realpath($key), iconv('ISO-8859-1', 'IBM850', $key)) or die("ERRO: NÃ£o Ã© possÃ­vel adicionar o arquivo: $key");
            }
            $zip->close();
            return 1;
        } catch (Exception $exc)
        {
            echo $exc->getTraceAsString();
            return 0;
        }
    }

    public function enviaFtp($host, $username, $password, $destFolder)
    {

        //$local_file = $this->path.$this->nome_arq_zip;
        //$remote_file = $destFolder . "/" . $this->nome_arq_zip;

        $local_file = $this->path . $this->nome_arq;
        $remote_file = $destFolder . "/" . $this->nome_arq;

        $this->conecta($host, $username, $password);
        $sucesso = $this->envia_arquivo($local_file, $remote_file);
        $this->desconecta();
        return $sucesso;
    }

}
