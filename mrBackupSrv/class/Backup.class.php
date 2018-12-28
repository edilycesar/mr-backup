<?php

/**
 * Description of Backup
 *
 * @author edily
 */
class Backup
{

    public $destinationFileName;
    public $destinationPath;
    public $destinationFullPath;
    private $urlCli;
    public $originFileName;
    private $originPath;
    public $originFullPath;
    private $name;

    public function __construct()
    {
        
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setOriginPath($originPath)
    {
        $this->originPath = $originPath;
        return $this;
    }

    public function setUrlCli($urlCli)
    {
        $this->urlCli = $urlCli;
        return $this;
    }

    public function pegaNomeArquivo()
    {
        //$this->originFileName = file_get_contents($this->urlCli);
        $this->originFileName = $this->acessaUrl($this->urlCli);
        $this->originFullPath = $this->originPath . '/' . $this->originFileName;
    }

    public function pegaArquivo()
    {
        $this->destinationFileName = $this->originFileName;
        $this->destinationFullPath = $this->destinationPath . '/' . $this->destinationFileName;
        if (empty($this->destinationFileName)) {
            echo "\n Arquivo destino não foi criado \n";
            return false;
        }
        $this->destinationFullPath = $this->destinationPath . '/' . $this->destinationFileName;
        echo "\n Arquivo: " . $this->originFullPath;
        $conteudo = $this->acessaUrl($this->originFullPath);
        file_put_contents($this->destinationFullPath, $conteudo);
        if (!is_file($this->destinationFullPath) || !file_exists($this->destinationFullPath)) {
            echo "\nArquivo não encontrado :( " . $this->destinationFullPath . "\n";
            return false;
        }
        return $this->destinationFullPath;
    }

    public function executa()
    {
        echo "\n ===== " . $this->name . " ===== ";
        $this->pegaNomeArquivo();    
        $this->pegaArquivo();
    }

    public function acessaUrl($url)
    {
        //$userAgent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
        $userAgent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:48.0) Gecko/20100101 Firefox/48.0';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

}
