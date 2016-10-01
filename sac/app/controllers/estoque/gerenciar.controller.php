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
			'titlePage' => 'Estoque'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('estoque/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function pesquisarproduto()
	{
		$this->load->model('produtos/produtosModel');
		$this->load->dao('produtos/produtosDao');
		$this->load->dao('produtos/IConsultaProduto');
		$this->load->dao('produtos/consultaPorId');
		$this->load->dao('produtos/consultaPorCodigoBarras');

		$tipo = $this->http->getRequest('tipo');
		$value = $this->http->getRequest('value');
		$status = Array(status::ATIVO);

		$produtosModel = new produtosModel();
		$produtos = new produtosDao();

		$produto = new produtosModel();
		if($tipo == 'pordescricao')
		{
			$idProduto = (int) $value;
			$produtosModel->setId($idProduto);
			$produto = $produtos->consultar(new consultaPorId(), $produtosModel, $status);
		}else
		if($tipo == 'porcodigo'){
			$produtosModel->setCodigoBarra($value);
			$produto = $produtos->consultar(new consultaPorCodigoBarras(), $produtosModel, $status);
		}
		$this->http->response($this->getJson($produto));
	}


	private function getJson(produtosModel $produto){
		$unidadeMedidaEstoque = Array();
		foreach ($produto->getUnidadeMedidaEstoque() as $unidMedEstoque){
			$aux = Array();
			$aux['id_unidade_medida_estoque'] = $unidMedEstoque->getId();
			$aux['nome_unidade_medida'] = $unidMedEstoque->getUnidadeMedida()->getNome();
			array_push($unidadeMedidaEstoque, $aux);
		}



		$json = Array(
			'id_produto' => $produto->getId(),
			'nome_produto' => $produto->getNome(),
			'codigo_barras' => $produto->getCodigoBarra(),
			'foto_produto' => URL.'skin/uploads/produtos/'.$produto->getFoto(),
			'unidadeMedidaEstoque' => $unidadeMedidaEstoque,
			'validadeControlada' => $produto->getControleValidade()
		);
		return json_encode($json);


	}

	public function inserir(){
		if(!$this->load->checkPermissao->check(false,URL.'estoque/gerenciar/'))
		{
			$this->http->response("Ação não permitida");
			return false;
		}
		//validação dos dados
		$this->load->library('dataValidator');

		$id_produto 			= $this->http->getRequest('id_produto');
		$codigoLote 			= $this->http->getRequest('codigoLote');
		$codBarrasGti 			= $this->http->getRequest('codBarrasGti');
		$codBarrasGst 			= $this->http->getRequest('codBarrasGst');
		$dataValidade 			= $this->http->getRequest('dataValidade');
		$quantidade 			= $this->http->getRequest('quantidade');
		$unidadeMedidaEstoque 	= $this->http->getRequest('unidadeMedidaEstoque');
		$observacoes 			= $this->http->getRequest('observacoes');

		$dataValidator = new dataValidator();
		$dataValidator->set('Produto', $id_produto, 'id_produto')->is_required();
		$dataValidator->set('Código do lote', $codigoLote, 'codigoLote')->is_required();
		$dataValidator->set('Data de nascimento', $dataNascimento, 'dataNascimento')->is_required()->is_date('d/m/Y');
		$dataValidator->set('Quantidade', $quantidade, 'quantidade')->is_required()->min_value(0);
	}
}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
