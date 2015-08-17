<?php
/**
* Classe para conexao com o banco de dados.
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 2.0
*
*/
abstract class conn extends db
{
	public static $pdoConn = null;
	private $dsn;
	public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
    
	public function __construct()
	{
		try 
		{	
			if(self::$pdoConn == null)
			{
				$this->dsn  = "mysql:host=".HOSTNAME.";dbname=".DBNAME."; port=".MYSQLPORT;
				self::$pdoConn  = new PDO($this->dsn, USERNAME, PASSWORD);
				self::$pdoConn->exec("set names utf8");
				self::$pdoConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				//self::$pdoConn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				//self::$pdoConn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
				parent::__construct(self::$pdoConn);
			}else
				parent::__construct(self::$pdoConn);
		}
		catch (PDOException $e) 
		{
			if($e->getCode( ) == '1049')
			{
				die('Erro mysql[1049]: O banco '.strtoupper(DBNAME).' não existe');
			}else
			if($e->getCode() == '2002')
			{
				die('Erro mysql[2002]: O host "'.strtoupper(HOSTNAME).'" não é conhecido ou a porta de conexão está incorreta.
					<p><strong>Possíveis soluções: </strong></p>
					<ul>
						<li>Verifique se o caminho do host está correto.</li>
						<li>Verifique se a porta de conexão do mysql está correta (a porta padrão é: 3306).</li>
					</ul>
					');
			}else
			if($e->getCode() == '1044')
			{
				die('Erro mysql[1044]: Acesso negado para o usuário "@localhost" para banco de dados '.strtoupper(DBNAME).' 
					<p><strong>Possível solução: </strong>Verifique se o nome de usuário da conexão está correta.</p>');
			}else
			if($e->getCode() == '1045')
			{
				die('Erro mysql[1044]: Acesso negado para o usuário "@localhost" com senha para banco de dados '.strtoupper(DBNAME).'.
					<p><strong>Possível solução: </strong>Verifique se o nome de usuário e a senha da conexão estão corretas.</p>');
			}
			else
			{
				die('Conexão falhou. Erro: '.$e->getMessage());
			}
		}
	}
}