<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class gerenciar extends Controller{
	private $error = array();
	private $countError = 0;
	
	public function __construct(){
		parent::__construct();
		// $checkPermissao = new checkPermissao();
		// $checkPermissao->checkPermissaoPagina();
		
		// //checagem do login
		// $this->load->dao('loginDao');
		// $login = new loginDao();
		// $login->statusLogin();
	}

	/********************************************/
	/****PÁGINAS****/

	/**
	*Página index
	*/
	public function index()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();

		$data = array(
			'titulo' => 'Níveis de acesso ao sistema',
			'template' => new template()
		);

		$this->load->dao('configuracoes/niveisAcessoDao');
		$niveis = new niveisAcessoDao();
		$data['niveis'] = $niveis->listar();
			
		$this->load->view('includes/header',$data);
		$this->load->view('configuracoes/niveis_acesso/home',$data);
		$this->load->view('includes/footer',$data);

	}

	/**
	*Página editar
	*/
	public function editar()
	{
		// $checkPermissao = new checkPermissao();
		// $checkPermissao->checkPermissaoPagina();
		$data = array(
			'titulo' => 'Editar Grupo de Permissões para Usuários',
		);



		//modulos
		$this->load->dao('configuracoes/modulosDao');
		$modulosDao = new modulosDao();
		//$modulos->setStatus('"Ativo"');
		//$modulos->setStatusSelecao('"Ativo"');
		$data['modulos'] = $modulosDao->listar(0);

		$url = new url();
		$id = intval($url->getSegment(4));
		$this->load->dao('configuracoes/niveisAcessoDao');
		$niveis = new niveisAcessoDao();
		$niveis = $niveis->getNivelAcesso($id);
		$data['nivel'] = $niveis;


		$this->load->view('includes/header',$data);
		$this->load->view('configuracoes/niveis_acesso/editar',$data);
		$this->load->view('includes/footer',$data);
	}



	/********************************************/
	/****FUNÇÕES DE ALTERAÇÕES DE REGISTROS****/

	/**
	* Atualização de um registro
	*/
	public function atualizar()
	{
		$id = isset($_POST['id']) ? filter_var(trim($_POST['id'])) : '';
		$administrador = isset($_POST['administrador']) ? filter_var(trim($_POST['administrador'])) : '';
		$permissoes = (isset($_POST['permissoes']) AND $_POST['permissoes'] != '{}') ? $_POST['permissoes'] : '';

		$validate = new DataValidator();
		$validate->set('Permissões', $permissoes, 'permissoes')->is_required();

		
		if ($validate->validate())
		{
			$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');
			$niveisAcesso = new niveisAcessoModel();
			$niveisAcesso->setId($id);
			if(!empty($administrador))
				$niveisAcesso->setPermissoes($administrador);	
			else
				$niveisAcesso->setPermissoes($permissoes);

			$this->load->dao('configuracoes/niveisAcessoDao');
			$niveisAcessoDao = new niveisAcessoDao();
			echo $niveisAcessoDao->atualizar($niveisAcesso);
		}else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }

		
		
	}



}