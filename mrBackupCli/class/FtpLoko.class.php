<?php
class FtpLoko {
	
    public $conexao, $host, $username, $password;

    public function conecta($host, $username, $password){	

        $this->host = $host;
        $this->username = $username;
        $this->password = $password;

        echo "<br/>Host: " . $this->host;
        echo "<br/>Usu:  " . $this->username;
        echo "<br/>Pass: " . $this->password;

        $this->conexao = ftp_connect($this->host, 21, 30);
        if(!$this->conexao){
            echo "<br/>Não foi possível conectar ";		
        }
        if(!ftp_login($this->conexao, $this->username, $this->password)){
                echo "<br/>Erro de login";
        }else{			
                echo "<br/>Conectado ao servidor FTP com sucesso! ";
        }		
    }

    public function listar($dir = "/"){
        echo "<h4>Enviados para servidor de Backup</h4>";
        $lista = ftp_nlist($this->conexao, $dir);	
        $lista = array_reverse($lista);	
        foreach ($lista as $arq){
                if(!empty($arq)){
                        echo "<br/>[".$arq."]";
                }
        }
        echo "<br/>=============</br>";
    }

    public function envia_arquivo($local_file, $remote_file){

        ftp_pasv($this->conexao, TRUE);

        $sucesso = FALSE;

        //ftp_mkdir($this->conexao, "teste");

        if(!file_exists($local_file)){
                echo "<br/>Arquivo local não encontrado";
        }else{
                echo "<br/>Arquivo local OK";
        }		

        if(!ftp_put($this->conexao, $remote_file, $local_file, FTP_ASCII)){
                echo "<br/>Erro de envio. ";
        }else{
                echo "<br/>Enviado para servidor FTP com sucesso";
                $sucesso = TRUE;
        }	 

        $this->listar();

        return $sucesso;			
    }

    public function desconecta(){		
        ftp_close($this->conexao);			
    }
}