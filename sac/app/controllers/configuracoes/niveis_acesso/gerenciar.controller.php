<?php
/**
* @author Wellington Cezar
* @author Diego Hernandes
*/
if(!defined('URL')) die('Acesso negado');
class gerenciar extends Controller{
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
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titulo' => 'Níveis de acesso ao sistema',
			'template' => new templateFactory()
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
		$this->load->dao('configuracoes/modulosDao');
		$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');
		$this->load->dao('configuracoes/niveisAcessoDao');

		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		$data = array(
			'titulo' => 'Editar Grupo de Permissões para Usuários',
		);
		$url = new url();
		$id = intval($url->getSegment(4));



		//modulos
		$niveisAcessoModel = new niveisAcessoModel();
		$niveisAcessoModel->setId($id);
		$modulosDao = new modulosDao();
		
		$niveis = new niveisAcessoDao();
		$niveis = $niveis->getNivelAcesso($niveisAcessoModel, $modulosDao->listar(0));
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
		$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');
		$this->load->model('configuracoes/modulos/modulosModel');
		$this->load->model('configuracoes/modulos/paginasModel');
		$this->load->model('configuracoes/modulos/actionsModel');


		$id = $this->http->getRequest('id');
		$administrador = $this->http->getRequest('administrador');
		$permissoes = $this->http->getRequest('permissoes');

		$validate = new DataValidator();
		$validate->set('Permissões', $permissoes, 'permissoes')->is_required();
		
		if ($validate->validate())
		{
			$_permissoes = json_decode($permissoes,true);
			$niveisAcesso = new niveisAcessoModel();
			$niveisAcesso->setId($id);

			if(is_null($administrador))
			{
				$niveisAcesso = $this->getPermissoes($_permissoes, $niveisAcesso);
			}


			$this->load->dao('configuracoes/niveisAcessoDao');
			$niveisAcessoDao = new niveisAcessoDao();
			$this->http->response($niveisAcessoDao->atualizar($niveisAcesso));
		}else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	}



	private function getPermissoes($_permissoes, niveisAcessoModel $niveisAcessoModel)
	{
		$this->load->model('configuracoes/modulos/modulosModel');
		$this->load->model('configuracoes/modulos/paginasModel');
		$this->load->model('configuracoes/modulos/actionsModel');
		$this->load->model('configuracoes/niveis_acesso/permissoesAcessoModel');

		//$permissoesAcessoModel = new permissoesAcessoModel();
		//obtendo modulos
		// echo '<pre>';
		// print_r($_permissoes);
		// echo '</pre>';
		foreach($_permissoes as $idMod => $modulo)
		{
			$modulosModel = new modulosModel();
			$modulosModel->setId($idMod);
			//obtendo submodulos
			foreach ($modulo['submodulos'] as $idSubMod => $subModulo) 
			{
				$submodulosModel = new modulosModel();
				$submodulosModel->setId($idSubMod);
				//obtendo paginas
				foreach ($subModulo as $idPagina => $paginas) 
				{
					$paginasModel = new paginasModel();
					$paginasModel->setId($idPagina);
					//obtendo actions
					foreach ($paginas as $idAction => $actions) 
					{
						$actionsModel = new actionsModel();
						$actionsModel->setId($idAction);

						$paginasModel->addAction($actionsModel);
					}

					$submodulosModel->addPagina($paginasModel);
				}

				$modulosModel->addModulo($submodulosModel);
			}
			//Obtendo paginas
			foreach ($modulo['paginas'] as $idPagina => $paginas) 
			{
				$paginasModel = new paginasModel();
				$paginasModel->setId($idPagina);
				//Obtendo actions
				foreach ($paginas as $idAction => $actions) 
				{
					$actionsModel = new actionsModel();
					$actionsModel->setId($idAction);

					$paginasModel->addAction($actionsModel);
				}

				$modulosModel->addPagina($paginasModel);
			}

			
			$niveisAcessoModel->addPermissoes($modulosModel);
		}
		// echo '<pre>';
		// print_r($niveisAcessoModel);
		// echo '</pre>';
		return $niveisAcessoModel;


	}
	



}