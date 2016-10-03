<?php
/**
* Classe de instancialização dos eventos.
* @author Wellington cézar
* @version 2.3
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class db{
	private $pdo = null;
	private $statement = null;
	private $sql;
	private $error;
	private $code;
	private $message; 
	private $elementQuery = array();

	public function __construct() 
	{
		require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php');
		if(	!defined('HOSTNAME') 
			|| !defined('USERNAME') 
			|| !defined('PASSWORD') 
			|| !defined('DBNAME') 
			|| !defined('MYSQLPORT')
		){
			foreach ($_db['userlogin'] as $key => $value)
			{
				$key = strtoupper($key);
				define($key,$value);
			}
			//die('Arquivo de configuração não está configurado corretamente. Configure o caminho do servidor mysql, com porta login e senha.');
		}

		$this->pdo = Conn::connect();
		$this->code = null;

		$this->elementQuery['tabela'] = '';
		$this->elementQuery['campos'] = '';
		$this->elementQuery['valores'] = '';
		$this->elementQuery['condicao'] = '';
		$this->elementQuery['orderBy'] = '';
		$this->elementQuery['limit'] = '';
		$this->elementQuery['parameters'] = array();

	}



	/**
	 * close the statement cursor
	 * */
	// public function __destruct()
	// {
	// 	if($this->statement != NULL)
	// 		$this->statement->closeCursor();
	// }
	



	/**
	 * define a tabela do banco
	 * @param String
	 * @return null
	 * */
	public function setTabela($tabela)
	{
		$this->elementQuery['tabela'] = $tabela;
	}




	/**
	 * define os campos para compor a query
	 * @param Array
	 * @return null
	 * */
	public function setCampos($campos)
	{
		if(is_array($campos))
			$this->elementQuery['campos'] = $campos;
		else
			die('Informe um tipo array para o metodo setCampos');
	}



	/**
	 * define os valores dos campos da tabela
	 * @param Array
	 * @return void
	 * */
	public function setValores($valores)
	{
		if(is_array($valores))
			$this->elementQuery['valores'] = $valores;
		else
			$this->elementQuery['valores'] = $this->prepare_values($valores);
	}



	/**
	 * define a condição de consulta da query
	 * @param String
	 * @return null
	 * */
	public function  setCondicao($cond)
	{
		$this->elementQuery['condicao'] = $cond;
	}



	/**
	 * Define o campo de ordenação
	 * @param string
	 * @return null
	 * */
	public function setOrderBy($orderBy = '')
	{
		$this->elementQuery['orderBy'] = $orderBy;
	}



	/**
	 * define o limite de consulta da query
	 * @param integer
	 * @param integer
	 * @return null
	 * */
	public function setLimit($limit1='', $limit2 = null)
	{
		if($limit2 != null)
			$this->elementQuery['limit'] = $limit1.','.$limit2;	
		else
			$this->elementQuery['limit'] = $limit1;	
	}



	/**
	 * define os valores para cada posição dos "?" da string de consulta(query)
	 * para cada posição "?" deverá ter um valor correspondente
	 * @param integer
	 * @param string
	 * */
	public function setParameter($pos, $value)
	{
		$this->elementQuery['parameters'][$pos] = filter_var(htmlentities($value));
	}



	/**
	 * prepara os valores correspondentes aos dos campos da tabela
	 * @param Array
	 * @return Array
	 * */
	private function prepare_values($valores)
	{
		if(count($this->elementQuery['campos']) == count($valores))
		{
			$ar_val = array();
			foreach ($this->elementQuery['campos'] as $key => $val){
				$ar_val[$val] = $this->elementQuery['valores'][$key];
			}
			return $ar_val;
		}else
		{
			throw new dbException('','21S01');
		}
	}


	/**
	 * preparação da string do insert
	 * @param Array
	 * @return boolean
	 * */
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
			throw new dbException('Parâmetros passados incorretamente. Informe um tipo array para o método insert', '1064');
		}
		$this->code = 'NULLINSERT';
		$this->message = "inserir";
		return $this->prepareQuery(new insert($this->elementQuery));
	}



	/**
	 * preparação da string do update
	 * @param Array
	 * @return boolean
	 * */
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
			throw new dbException('Parâmetros passados incorretamente. Informe um tipo array para o método update', '1064');
		}
		
		$this->code = 'NULLUPDATE';
		$this->message = "editar";
		return $this->prepareQuery(new update($this->elementQuery));
		
	}



	/**
	 * preparação da string do select
	 * @param Array
	 * @return boolean
	 * */
	public function select($campos = NULL)
	{
		if($campos != NULL)
		{
			if(is_array($campos))
			{
				$this->setCampos($campos);
			}else
			{
				throw new dbException('Parâmetros passados incorretamente. Informe um tipo array para o método select', '1064');
			}
		}
		$this->code = 'NULLSELECT';
		$this->message = "selecionar";
		return $this->prepareQuery(new select($this->elementQuery));
	}



	/**
	 * preparação da string do delete
	 * @return boolean
	 * */
	public function delete()
	{
		$this->code = 'NULLDELETE';
		$this->message = "excluir";
		return $this->prepareQuery(new delete($this->elementQuery));
	}



	/**
	 * preparação da string de consulta
	 * @param String
	 * @return boolean
	 * */
	public function query($sql= null)
	{
		if($sql == null)
			throw new dbException('Erro de sintaxe, informe o comando sql corretamente', '1064');
		else{
			$this->code = 'NULLQUERY';
			$this->message = "executar";
			return $this->prepareQuery(new query($this->elementQuery, $sql));
		}
	}



	/**
	 * preparação e execução da string de consulta
	 * @param IDbCrud
	 * @return boolean
	 * */
	private function prepareQuery(IDbCrud $crud)
	{
		$this->sql = $crud->getQuery();
		try{
			$this->statement = $this->pdo->prepare($this->sql);
		    $this->statement->execute($crud->getParamArray());
		    $this->rows_affected = $this->statement->rowCount();
			if($this->rows_affected > 0)
			{
				return true;
			}else
			{
				$this->rows_affected = 0;
				return false;
			}
		}catch (PDOException $e)
		{
			$this->code = $e->getCode();
			$this->message = $e->getMessage();
			throw new dbException($this->message, $this->code, $e);
		}
	}



	/**
	 * Retorno completo da consulta
	 * @param integer
	 * @return Array
	 * */
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
			return Array();
		}
	}



	/**
	 * Retorno único da consulta
	 * @param integer
	 * @return Array
	 * */
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
			return Array();
		}
	}



	/**
	 * retorna o número de linhas afetadas pela consulta
	 * @return integer
	 * */
	public function rowCount()
	{
		return $this->statement->rowCount();
	}



	/**
	 * Retorna a mensagem de erro
	 * Não gerada por exceção
	 * @return String
	 * */
	public function getError()
	{
		$error = new dbException($this->message, $this->code);
		return $error->getMessageError();
	}



	/**
	 * retorna o código de erro (dbException)
	 * @return String
	 * */ 
	public function getcode()
	{
		return $this->code;
	}

	

	/**
	 * Retorna o ultimo id Inserido
	 * @return integer
	 * */
	public function getUltimoId()
	{
		return $this->pdo->lastInsertId();	
	}



	/**
	 * retorna a string de consulta corrente
	 * @return String
	 * */
	public function getSql()
	{
		return $this->sql;
	}



	/**
	 * Retorna todos os valores default dos elementos
	 * */
	public function clear()
	{
		$this->elementQuery['tabela'] = '';
		$this->elementQuery['campos'] = '';
		$this->elementQuery['valores'] = '';
		$this->elementQuery['condicao'] = '';
		$this->elementQuery['orderBy'] = '';
		$this->elementQuery['limit'] = '';
		$this->elementQuery['parameters'] = Array();
	}

}