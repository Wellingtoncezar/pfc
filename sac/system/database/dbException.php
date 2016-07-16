<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class dbException extends PDOException{
	private $dbmessage;
	private $dbcode;
	private $dbExceptionPrevious;
	private $matches = array();
	private $db_error;

    public function __construct($message, $code = 'DEFAULT', Exception $previous = null) {
    	$this->dbmessage = $message;
		$this->dbcode = $code;
		$this->dbExceptionPrevious = $previous;
		
		if(SHOWDBERROR == true && !empty($this->dbExceptionPrevious))
		{
			$this->db_error = ' [ERROR : '.$this->dbExceptionPrevious->getMessage().']';
		}
    }

	public function getMessageError()
	{
		$errors = array(
			'NULLSELECT' 	=> "noSelect",
			'NULLINSERT' 	=> "noInsert",
			'NULLDELETE' 	=> "noDelete",
			'NULLUPDATE' 	=> "noUpdate",
			'NULLQUERY' 	=> "noQuery",
			'23000' 		=> "duplicateKey",
			'1451' 			=> "dependentRecords",
			'HY000' 		=> "notfound",
			'08004' 		=> "excessConnection",
			'21S01' 		=> "columnsNotCorrespondingValues",
			'42S21' 		=> "duplicateColumn",
			'42000' 		=> "withoutPermission",
			'1064'			=> "sqlSyntax",
			'DEFAULT' 		=> "defaultError"
		);


		if(array_key_exists($this->dbcode, $errors)){
			$str = $this->dbmessage;
			$e = preg_match_all("#\'(.*?)('?)\'#", $str, $matches);
			$this->matches = $matches;
			return $this->$errors[$this->dbcode]($matches);
		}else{

			$this->dbcode = $this->dbExceptionPrevious->getCode();
			return $this->defaultError('');
		}
	}




	public function getDbCode()
	{
		return $this->dbcode;
	}

	public function getMatches()
	{
		return $this->matches;
	}

	private function duplicateKey($matches)
	{
		return 'O valor '.$matches[0][0].' já existe nos registros.'.$this->db_error;
	}

	private function notfound($matches)
	{	
		return "Não pode encontrar o registro".$this->db_error;
	}	

	private function noUpdate($matches)
	{
		return 'Nenhum registro alterado'.$this->db_error;
	}

	private function noDelete($matches)
	{
		return 'Nenhum registro excluído'.$this->db_error;
	}

	private function noInsert($matches)
	{
		return 'Nenhum registro inserido'.$this->db_error;
	}

	private function noSelect($matches)
	{
		return 'Nenhum registro encontrado'.$this->db_error;
	}

	private function noQuery($matches)
	{
		return 'Não foi possível executar'.$this->db_error;
	}
	
	private function duplicateColumn($matches)
	{
		return "Nome da coluna duplicado".$this->db_error;
	}

	private function defaultError($matches)
	{
		return "Erro indefinido: ". $this->dbExceptionPrevious->getMessage();
	}

	private function withoutPermission($matches)
	{
		return "Você não tem permissão para executar esta ação".$this->db_error;
	}

	
	private function excessConnection($matches)
	{
		return "Excesso de conexão".$this->db_error;
	}
	
	private function dependentRecords($matches)
	{
		return "Há registros dependentes".$this->db_error;
	}

	private function columnsNotCorrespondingValues($matches)
	{
		return "Os valores não correspondem ao número de campos".$this->db_error;
	}

	private function sqlSyntax($matches)
	{
		return $this->dbmessage;
	}
	
}		
