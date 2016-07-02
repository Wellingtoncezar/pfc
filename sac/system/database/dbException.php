<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class dbException extends PDOException{
	private $msg_error;
	private $dbmessage;
	private $dbcode;
	private $dbprevious;
	// Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message, $code = 0, Exception $previous = null) {
        	$this->dbmessage = $message;
			$this->dbcode = $code;
			$this->dbprevious = $previous;
        
    }

    public function getCodeError()
    {
    	if(is_object($this->dbmessage))
		{
    		return $this->dbmessage->getCode();
    	}else
    	{
    		return $this->dbmessage->getCode();
    	}
    }

	public function getMessageError()
	{
		$errors = array(
			'NULLSELECT' 	=> "Nenhum registro encontrado",
			'NULLINSERT' 	=> "Nenhum registro inserido",
			'NULLDELETE' 	=> "Nenhum registro excluído",
			'NULLUPDATE' 	=> "Nenhum registro alterado",
			'NULLQUERY' 	=> "Não foi possível executar",
			'23000' 		=> "duplicateKey",
			'1451' 			=> "Não é possível %s.Existem registros relacionados à ele.",
			'HY000' 		=> "notfound",
			'08004' 		=> "Excesso de conexões",
			'21S01' 		=> "Contagem de colunas não confere com a contagem de valores",
			'42S21' 		=> "Nome da coluna duplicado",
			'42000' 		=> "Você não tem permissão para executar esta ação",
			'OTHER' 		=> "Outro erro: %s",
			'DEFAULT' 		=> "Erro indefinido"
		);


		if(is_object($this->dbmessage))
		{
			if(array_key_exists($this->dbmessage->getCode(), $errors)){
				$str = $this->dbmessage->getMessage();
				preg_match_all("#\'(.*?)('?)\'#", $str, $matches);
				return $this->$errors[$this->dbmessage->getCode()]($matches);
			}
			else
				return sprintf($errors['OTHER'], $this->dbmessage->getMessage()); 
		}else
		{
			if(array_key_exists($this->dbcode, $errors))
				return $errors[$this->dbcode]; 
			else
				return $errors['DEFAULT'];
		}
	}


	private function duplicateKey($matches)
	{
		return 'O valor '.$matches[0][0].' já existe nos registros.';
	}
	private function notfound($matches)
	{	
		return "Não pode encontrar o registro";
	}	
}		
