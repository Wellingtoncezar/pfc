<?php
define('SYSTEMPATH','system');
define('LIBRARYPATH','library');
define('APPPATH','app');
require_once('include.php');
config::getInstance();
config::getConfig();
require_once(BASEPATH.'/app/DAO/produtos/marcasDao.php');
require_once(BASEPATH.'/app/models/produtos/marcasModel.php');

class testeMarca extends PHPUnit_Framework_TestCase{
	// public function testeListar(){
	// 	$marca = new marcasDao();
 //        $this->assertEquals(Array(), $marca->listar());
	// }

	// public function testeConsultar(){
	// 	$marcasModel = new marcasModel();
	// 	$marcasModel->setId(1);
	// 	$marca = new marcasDao();
 //        $this->assertEquals($marcasModel, $marca->consultar($marcasModel));
	// }

	// public function testeInserir(){
	// 	$marcasModel = new marcasModel();
	// 	$marcasModel->setNome('Coca');
	// 	$marcasModel->setStatus('ATIVO');
	// 	$marcasModel->setDataCadastro(date('Y-m-d H:i:s'));
	// 	$marca = new marcasDao();
	// 	$this->assertTrue($marca->inserir($marcasModel));
	// }


	// public function testeAtualizar(){
	// 	$marcasModel = new marcasModel();
	// 	$marcasModel->setId(9);
	// 	$marcasModel->setNome('Cocas');
	// 	$marca = new marcasDao();
	// 	$this->assertTrue($marca->atualizar($marcasModel));
	// }

	public function testeAtualizarStatus(){
		$marcasModel = new marcasModel();
		$marcasModel->setId(9);
		$marcasModel->setStatus('INAT');
		// var_dump($marcasModel);
		$marca = new marcasDao();
		$this->assertTrue($marca->atualizarStatus($marcasModel));
	}

}
