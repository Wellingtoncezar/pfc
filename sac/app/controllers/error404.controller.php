<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class error404 extends Controller{
	private $mensagem;
	public function __construct(){
		parent::__construct();

		$this->mensagem = '<p><strong>DESCULPE-NOS</strong></p><p>A página que você procura não foi encontrada.</p><p>Verifique o endereço digitado ou tente novamente mais tarde.</p>';
	}

	public function index($mensagem = null)
	{
		$this->mensagem = ($mensagem != null) ? $mensagem : $this->mensagem;
		$data = array(
			'titlePage' => 'Página não encontrada',
			'_message_error' => $this->mensagem
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('error_404',$data);
		$this->load->view('includes/footer',$data);
	}
}
