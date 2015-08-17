<?php
/**
* Classe para insert do banco. Pode ser utilizada diretamete ou através da classe db
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 1.0
*
*/

class insert{
	private $rows_affected;
	private $pdo;
	private $statement;
	private $sql;

	public function __construct($pdo,$table,$value)
	{
		//parent::__construct();
		$this->pdo = $pdo;
		$this->insert($table,$value);
	}

	public function __destruct()
	{
		$this->statement->closeCursor();
	}
	public function insert($table, $value)
	{
		$campos='';
		$valores = '';
		$param = '';
		$n = count($value);
		$i = 0;

		foreach($value AS $key => $val)
		{
			$key = trim($key);
			if( $i < $n-1 )
			{
				$campos .= $key.", ";
				$param .= ":".$key.", ";
			}
			else
			{
				$campos .= $key."";
				$param .= ":".$key."";
			}
			$paramArray[":".$key.""]= filter_var(trim($val));
			$i++;
		}

		$this->sql  = "INSERT INTO ".$table." (".$campos.") VALUES (".$param.")";
		$this->statement = $this->pdo->prepare($this->sql);
		$this->statement->execute($paramArray);

		$this->rows_affected = $this->statement->rowCount();

		if($this->rows_affected > 0){
			$this->ultimoId = $this->pdo->lastInsertId();
			return true;
		}
		else{
			return false;
		}
	}

	public function rows_affected()
	{
		return $this->rows_affected;
	}

	public function getUltimoId(){
		return intval($this->ultimoId);
	}



}
