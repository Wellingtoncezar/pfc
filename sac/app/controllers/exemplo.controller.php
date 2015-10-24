<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class exemplo extends Controller{
	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		echo 'pagina inicial';
	}



	public function cadastrar()
	{
		//load model
		$this->load->model('exemploModel');
		$this->exemploModel->setNome('welldsfington');
		$this->exemploModel->setIdade(25);

		//load dao
		$this->load->dao('exemploDao');
		$resp = $this->exemploDao->inserir( $this->exemploModel );

		if( $resp )
			echo 'Cadastrado com sucesso';
		else
			echo 'Erro ao cadastrar';
	}





	public function consultar()
	{
		//load model
		$this->load->model('exemploModel');
		$this->exemploModel->setId(9);

		//load dao
		$this->load->dao('exemploDao');
		$exemplo = $this->exemploDao->consultar( $this->exemploModel );

		if( $exemplo != false ){
			echo '<h2>Dados retornados</h2>';
			echo 'Nome: '. $exemplo->getNome().'</p>';
			echo '<p>Idade: '. $exemplo->getIdade().'</p>';
		}
		else
			echo 'Erro retornar consulta';
	}
}