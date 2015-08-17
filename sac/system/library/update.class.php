<?php
/**
* Classe para update do banco. Pode ser utilizada diretamete ou através da classe db
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 1.0
*
*/
class update
{
	private $rows_affected;
	private $pdo;
	private $statement;
	private $sql;
	public function __construct($pdo, $table,$value, $cond = '')
	{
		//parent::__construct();
		$this->pdo = $pdo;
		$this->update($table,$value,$cond);
	}



	public function update($table, $value, $cond = '')
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
				$param .= "".$key." = :".$key.", ";
			}
			else
			{
				$campos .= $key."";
				$param .= "".$key." = :".$key."";
			}
			$paramArray[":".$key.""]= filter_var(trim($val));
			$i++;
		}

		$this->sql  = "UPDATE ".$table." SET ".$param."";
		if($cond != '')
			$this->sql .= " WHERE ".$cond;
		$this->statement = $this->pdo->prepare($this->sql);


		$this->statement->execute($paramArray);

		$this->rows_affected = $this->statement->rowCount();
		if($this->rows_affected > 0)
		{
			return true;
		}else
			return false;


	}

	public function rows_affected()
	{
		return $this->rows_affected;
	}

	public function getSql()
	{
		return $this->sql;
	}
}
