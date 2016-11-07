<?php
/*
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gerenciar extends Controller{
	public function __construct(){
		parent::__construct();
	}


	/*---------------------------
	- PÁGINAS
	=============================*/


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
			'titlePage' => 'Caixa'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('caixa/home',$data);
		$this->load->view('includes/footer',$data);
	}

	/**
	 * Página de cadastro
	 */
	public function cadastrar()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Cadastrar caixas',
			'template' => new templateFactory()

		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('caixa/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}


	/**
	 * Página de edição
	 */
	public function editar()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Editar caixa'
		);
		//ID
		$idCaixas = intval($this->load->url->getSegment(3));
		
		//caixa MODEL
		$this->load->model('caixa/caixasModel');
		$caixasModel = new caixasModel();
		$caixasModel->setId($idCaixas);

		//caixa DAO
		$this->load->dao('caixa/caixasDao');
		$this->load->dao('caixa/iConsultaCaixa');
		$this->load->dao('caixa/consultaPorId');
		$caixasDao = new caixasDao();
		$data['caixa'] = $caixasDao->consultar(new consultaPorId(), $caixasModel);
		if($data['caixa'] == null)
			$this->http->redirect(URL.'error404');
		//DATAFORMAT
		$this->load->library('dataFormat', null, true);
		$data['dataFormat'] = $this->load->dataFormat;

		$this->load->view('includes/header',$data);
		$this->load->view('caixa/editar',$data);
		$this->load->view('includes/footer',$data);
	}


	/*----------------------------
	- AÇÕES
	=============================*/
	/**
	 * Ação do cadastrar
	 */
	public function inserir()
	{
		try{

			$codigo = isset($_POST['codigo']) ? filter_var($_POST['codigo']) : '';
			$ip = $this->getIp();
		

			//validação dos dados
			$this->load->library('dataValidator', null, true);
			
			$this->load->dataValidator->set('Codigo', $codigo, 'codigo')->is_required()->min_length(2);
			$this->load->dataValidator->set('Ip', $ip, 'ip')->is_required();

			
			if ($this->load->dataValidator->validate())
			{
			
				//CAIXAS
				$this->load->model('caixa/caixasModel');
				$caixasModel = new caixasModel();
				
				$caixasModel->setCodigo($codigo);
				$caixasModel->setIp($ip);
				$caixasModel->setDataCadastro(date('Y-m-d h:i:s'));


				//caixas DAO
				$this->load->dao('caixa/caixasDao');
				$caixasDao = new caixasDao();
				$this->http->response($caixasDao->inserir($caixasModel));
			}else
		    {
				$todos_erros = $this->load->dataValidator->get_errors();
				$this->http->response(json_encode($todos_erros));
		    }
		} catch (dbException $e) {
 			if($e->getDbCode() == '23000'){
 				$this->http->response('Esta máquina já está registrada no sistema');
 			}else
	 			$this->http->response($e->getMessageError());
 		}

	}



	/**
	 * Ação do editar
	 */
	/**
	 * Ação do cadastrar
	 */
	public function atualizar()
	{
		$id = isset($_POST['id']) ? filter_var($_POST['id']) : '';
		$codigo = isset($_POST['codigo']) ? filter_var($_POST['codigo']) : '';
		$ip = $this->getIp();



		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Codigo', $codigo, 'codigo')->is_required()->min_length(2);
		$this->load->dataValidator->set('Ip', $ip, 'ip')->is_required();

		
		if ($this->load->dataValidator->validate())
		{
		
			//CAIXAS
			$this->load->model('caixa/caixasModel');
			$caixasModel = new caixasModel();
			$caixasModel->setId($id);
			$caixasModel->setCodigo($codigo);
			$caixasModel->setIp($ip);
			$caixasModel->setDataCadastro(date('Y-m-d h:i:s'));


			//caixas DAO
			$this->load->dao('caixa/caixasDao');
			$caixasDao = new caixasDao();
			echo $caixasDao->atualizar($caixasModel);
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}
	private function getIp()
    	{
    	    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    	    {
    	        return $_SERVER['HTTP_CLIENT_IP'];
    	    }
    	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    	    {
    	        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    	    }
    	    else{
    	        return $_SERVER['REMOTE_ADDR'];
    	    }
    	}

	public function excluir()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		$this->atualizarStatus();
	}





	public function getJsoncaixa()
	{
		//caixas
		$this->load->dao('caixa/caixasDao');
		$this->load->dao('caixa/iListagemCaixa');
		//usurios
		$this->load->dao('funcionarios/IUsuarios');
		$this->load->dao('funcionarios/consultaUsuarioPorId');
		$this->load->dao('funcionarios/usuariosDao');
		//funcionarios
		$this->load->dao('funcionarios/IListagemFuncionarios');
		$this->load->dao('funcionarios/consultaFuncionarioPorId');
		$this->load->dao('funcionarios/funcionariosDao');


		$caixasDao = new caixasDao();
		$caixas = $caixasDao->listar();
		//echo $caixasDao->listar($caixa);

		foreach ($caixas as $caixa) 
		{
			$caixasDao->listaAberturaCaixa($caixa);
			foreach($caixa->getCaixaAberto() as $caixaAberto)
			{
				//USUARIOS DAO -- consultando o usuario pelo id
				$usuariosDao = new usuariosDao;
				$usuariosModel = $usuariosDao->consultar(new consultaUsuarioPorId(), $caixaAberto->getUsuario(), array(status::ATIVO, status::INATIVO));
				if($usuariosModel != null)
				{

					//FUNCIONARIOS DAO -- Consultando o funcionario pelo id
					$funcionariosDao = new funcionariosDao();
					$funcionariosModel = $funcionariosDao->consultar(new consultaFuncionarioPorId(), $usuariosModel->getFuncionario(), array(status::ATIVO, status::INATIVO));
					$usuariosModel->setFuncionario($funcionariosModel);

					$caixaAberto->setUsuario($usuariosModel);
				}
			}
		}



		$this->load->library('dataformat');
		$dataformat = new dataformat();
		$_arCaixa = Array();
		foreach ($caixas as $cx):
			$aux = array(
				    	'id'=> $cx->getId(),
				    	'codigo' => $cx->getCodigo(),
						'ip'=> $cx->getIp(),
						'acoes'=> "",
						'linkEditar'=> URL.'caixa/gerenciar/editar/'.$cx->getId(),
						'abertos'=> array()
				    );
			$arrAberturaCaixa = array();
			foreach ($cx->getCaixaAberto() as $OpenBox){
				$valorUndEstoque = 0;
		        $aux2 = array( 
				        	'id' => $OpenBox->getId(),
							'dateOpen' => $dataformat->formatar($OpenBox->getDataAbertura(),'datahora'),
							'dateClose' => $dataformat->formatar($OpenBox->getDataFechamento(),'datahora'),
							'user' => html_entity_decode($OpenBox->getUsuario()->getFuncionario()->getNome().' '.$OpenBox->getUsuario()->getFuncionario()->getSobreNome()),
							'acoes' => "",
							'linkvisualizar' => ''
							
				    	);

				array_push($aux['abertos'], $aux2);
			}

			array_push($_arCaixa, $aux);
        endforeach;

        $this->http->response(json_encode($_arCaixa));
	}
}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
