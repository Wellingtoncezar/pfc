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
		echo 'teste';
		echo Bcrypt::hash("admin");
		// try 
		// {
		// 	$db = new db();
		// 	$db->clear();
		// 	$sql = "SELECT * FROM produtos WHERE id_produto = '1'";
		// 	//$sql = "DELETE FROM produtos WHERE id_produto = '1'";
		// 	$db->query($sql);
		// 	//$res = $db->resultAll();
		// 	echo '<pre>';
		// 	//print_r($res);
		// 	echo '</pre>';
		// } catch (Exception $e) {
		// 	echo $e->getMessage();
		// }
	}

}


/**
*
*class: home
*
*location : controllers/home.controller.php
*/
