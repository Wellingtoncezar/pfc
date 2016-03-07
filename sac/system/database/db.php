<?php
/**
* Classe de instancialização dos eventos.
* @author Wellington cézar
* @version 2.3
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class db extends activeRecord{
	private $res;
	private $pdo = null;
	private $statement = null;
	private $sql;
	private $error;
	private $errorCode;
	private $errorCodeName;


	public function __construct() 
	{
		require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php');
		if(	!defined('HOSTNAME') 
			|| !defined('USERNAME') 
			|| !defined('PASSWORD') 
			|| !defined('DBNAME') 
			|| !defined('MYSQLPORT')
		){
			foreach ($_db['default'] as $key => $value)
			{
				$key = strtoupper($key);
				define($key,$value);
			}
			//die('Arquivo de configuração não está configurado corretamente. Configure o caminho do servidor mysql, com porta login e senha.');
		}


		$this->pdo = Conn::connect();
		$this->error = new error_db();
	}

	public function __destruct()
	{
		if($this->statement != NULL)
			$this->statement->closeCursor();
	}
	
	

	public function insert($values = NULL)
	{
		if(!is_string($values))
		{
			if(!is_array($values))
			{
				$this->setValores($this->prepare_values($this->campos, $values));
			}else
			{
				$this->setValores($values);
			}
		}else
		{
			die('Parâmetros do insert passados incorretamente');
		}


		$this->res = new insert($this->getElementQuery());
		$this->sql = $this->res->getQuery();
		$this->errorCode = 'NULLINSERT';
		$this->errorCodeName = 'inserir';
		return $this->prepareQuery($this->sql);
	}


	public function update($values = NULL)
	{
		if(!is_string($values))
		{
			if(!is_array($values))
			{
				$this->setValores($this->prepare_values($this->campos, $values));
			}else
			{
				$this->setValores($values);
			}
		}else
		{
			die('Parâmetros do insert passados incorretamente');
		}
		$this->res = new update($this->getElementQuery());

		$this->sql = $this->res->getQuery();
		$this->errorCode = 'NULLUPDATE';
		$this->errorCodeName = 'editar';
		return $this->prepareQuery($this->sql);
	}


	public function select($campos = NULL)
	{
		if($campos != NULL)
		{
			if(is_array($campos))
			{
				$this->setCampos($campos);
			}else
			{
				die('Parâmetros passados incorretamente. Informe um tipo array para o método select');
			}
		}
		
		$this->res = new select($this->getElementQuery());
		$this->sql = $this->res->getQuery();
		$this->errorCode = 'NULLSELECT';
		$this->errorCodeName = 'selecionar';
		return $this->prepareQuery($this->sql);
	}


	public function delete()
	{
		$this->res = new delete($this->getElementQuery());
		$this->sql = $this->res->getQuery();
		$this->errorCode = 'NULLDELETE';
		$this->errorCodeName = 'excluir';
		return $this->prepareQuery($this->sql);
	}


	public function query($sql= null)
	{
		if($sql == null)
			die('Informe o comando sql corretamente.');
		else{
			$this->res = new query($this->getElementQuery(), $sql);
			$this->sql = $this->res->getQuery();
			$this->errorCode = 'NULLQUERY';
			$this->errorCodeName = 'query';
			return $this->prepareQuery($this->sql);
		}
	}




	private function prepareQuery()
	{
		$this->statement = $this->pdo->prepare($this->sql);
		try{ 
		    $this->statement->execute($this->res->getParamArray());
		    $this->rows_affected = $this->statement->rowCount();
			if($this->rows_affected > 0)
			{
				return true;
			}
			else
			{
				$this->rows_affected = 0;
				return false;
			}
		}catch (PDOException $e)
		{
			$this->errorCode = $e;
		    $this->rows_affected = 0;
			return false;
		}
	}





	public function resultAll($tipo = 0)
	{
		if($this->rows_affected > 0)
		{
			if($tipo == 0) //todos
				return $this->statement->fetchAll(PDO :: FETCH_BOTH);
			else
			if($tipo == 1)//penas os nomes dos campos
				return $this->statement->fetchAll(PDO :: FETCH_ASSOC);
			else
			if($tipo == 2)//apenas como classe
				return $this->statement->fetchAll(PDO::FETCH_CLASS);
		}else{
			return false;
		}
	}


	public function result($tipo = 0)
	{
		if($this->rows_affected > 0)
		{
			if($tipo == 0){ //todos

				return $this->statement->fetch(PDO :: FETCH_BOTH);
			}else
			if($tipo == 1){//apenas os nomes dos campos
				return $this->statement->fetch(PDO :: FETCH_ASSOC);
			}
		}else{
			return false;
		}
	}


	public function rowCount()
	{
		return $this->statement->rowCount();
	}

	public function getError()
	{
		return $this->error->getMensagemErro($this->errorCode, $this->errorCodeName);	
	}

	public function getErrorCode()
	{
		return $this->errorCode;	
	}

	
	public function getUltimoId()
	{
		return $this->pdo->lastInsertId();	
	}

	public function getSql()
	{
		return $this->sql;
	}


	public function clear()
	{
		$this->res = null;
		$this->clearElements();
	}
	

}
