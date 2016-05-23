<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class teste extends Controller{
	public function __construct(){
		parent::__construct();
		//$this->load->dao('loginDao');
		//$this->loginDao->statusLogin();

	}


	/********************************************/
	/****PÁGINAS****/
	

	/**
	*Página index
	*/

	public function index()
	{	
		try {
			$this->testando();
		} catch (Exception $e) {
			echo 'ocorreu o erro:'. $e->getMessage();
		}
		
		echo '<p>continuação da execução</p>';
	}
	function testando(){
		//senão o insere 
		$db = new db();
		$db->clear();
		$db->setTabela('test');
		$dataValue = array(
			'nome' => 'a',
		);
		try {
			if($db->insert($dataValue)){
				echo 'inserido';
			}else
				echo $db->getError();
		} catch (error_db $e) {
			throw new Exception($e, 1);
			
		}
	}
}


/**
*
*class: home
*
*location : controllers/home.controller.php
*/
