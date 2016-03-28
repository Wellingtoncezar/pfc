<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class acesso_negado extends Controller{
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Página index
	 */
	public function index()
	{
		$data = array(
			'titlePage' => 'Acesso negado'
		);

		
		
		$this->load->view('includes/header',$data);
		$this->load->view('acesso_negado',$data);
		$this->load->view('includes/footer',$data);

	}

}