<?php
/**
*@author Wellington cezar, Diego Hernandes, Jessica Azevedo
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class funcionariosDao extends Dao{
	public function __construct(){
		parent::__construct();
	}

 	public function inserir($funcionario)
 	{
 		return json_encode($funcionario);
 	}
}