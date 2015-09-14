<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class home extends Controller{
	private $error = array();
	private $countError = 0;
	public function __construct(){
		parent::__construct();
	}


	/********************************************/
	/****PÁGINAS****/
	

	/**
	*Página index
	*/
	public function index()
	{
		//$this->saveModules();
		//$this->saveAction();

		$data = array(
			'titlePage' => ''
		);
		
		$this->load->view('includes/header',$data);
		//$this->load->view('home',$data);
		$this->load->view('includes/footer',$data);
	}
	public function page()
	{
		$this->load->view('home');
	}
}


/**
*
*class: home
*
*location : controllers/home.controller.php
*/
