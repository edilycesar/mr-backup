<?php
/**
 * Description of Backup
 *
 * @author edily
 */
class Backup {
    
    public $destinationFileName;
    public $destinationPath;
    public $destinationFullPath;
    
    public $urlCli;
    
    public $originFileName;
    public $originPath;
    public $originFullPath;


    public function pegaNomeArquivo() 
    {
        $this->originFileName = file_get_contents($this->urlCli);
        $this->originFullPath = $this->originPath . '/' . $this->originFileName;
    }
    
    public function pegaArquivo() 
    {
        $this->destinationFullPath = $this->destinationPath . '/' . $this->destinationFileName;
        $conteudo = file_get_contents($this->originFullPath);
        file_put_contents($this->destinationFullPath, $conteudo);
        return file_exists($this->destinationFullPath);
    }    
    
    public function executa() 
    {
        
    }
    
}
