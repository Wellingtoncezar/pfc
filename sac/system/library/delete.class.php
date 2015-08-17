<?php
/**
* Classe para delete do banco. Pode ser utilizada diretamete ou através da classe db
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 1.0
*
*/
class delete
{
	private $rows_affected;
	private $errorCode;
	private $pdo;
	private $sql;

	public function __construct($pdo,$table, $cond = '')
	{
		//parent::__construct();
		$this->pdo = $pdo;
		$this->delete($table,$cond);
	}
	public function __destruct()
	{
		$this->statement->closeCursor();
	}

	public function delete($table, $cond = '')
	{
		$this->sql  = "DELETE  FROM ".$table."";
		if($cond != '')
			$this->sql .= " WHERE ".$cond;
		$this->statement = $this->pdo->prepare($this->sql);
		$this->statement->execute();
		$this->rows_affected = $this->statement->rowCount();
		if($this->rows_affected > 0)
			return true;
		else
		{
			$this->errorCode = $this->statement->errorInfo();
			return false;
		}
	}

	public function rows_affected()
	{
		return $this->rows_affected;
	}


	public function getErrors()
	{
		return $this->errorCode;
	}

	public function getSql()
	{
		return $this->sql;
	}
}
