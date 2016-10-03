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
		
		$this->load->model('produtos/produtosModel');
		$this->load->model('produtos/unidadeMedidaEstoqueModel');
		$this->load->model('produtos/unidadeMedidaModel');
		$this->load->model('estoque/estoqueModel');
		$this->load->model('estoque/localizacaoLoteModel');
		$this->load->model('estoque/lotesModel');
		$this->load->dao('produtos/produtosDao');
		$this->load->dao('produtos/iConsultaProduto');
		$this->load->dao('produtos/consultaPorId');
		$this->load->dao('estoque/estoqueDao');

		$this->load->library('dataValidator');
		$this->load->library('dataformat');

		$dataformat = new dataformat();

		$id_produto 			= (int)$this->http->getRequest('id_produto');
		$codigoLote 			= $this->http->getRequest('codigoLote');
		$codBarrasGti 			= $this->http->getRequest('codBarrasGti');
		$codBarrasGst 			= $this->http->getRequest('codBarrasGst');
		$dataValidadeControlada = (boolean)$this->http->getRequest('dataValidadeControlada');
		$dataValidade 			= $dataformat->formatar($this->http->getRequest('dataValidade'),'data', 'banco');
		$quantidade 			= $dataformat->formatar($this->http->getRequest('quantidade'),'decimal', 'banco');
		$unidadeMedidaEstoque 	= (int)$this->http->getRequest('unidadeMedidaEstoque');
		$observacoes 			= $this->http->getRequest('observacoes');


		$dataValidator = new dataValidator();
		$dataValidator->set('Produto', $id_produto, 'id_produto')->is_required();
		$dataValidator->set('Código do lote', $codigoLote, 'codigoLote')->is_required();
		if($dataValidadeControlada == true)
			$dataValidator->set('Data de validade', $dataValidade, 'dataValidade')->is_required()->is_date('Y-m-d');
		$dataValidator->set('Quantidade', $quantidade, 'quantidade')->is_required()->min_value(0);
		$dataValidator->set('Unidade de medida', $unidadeMedidaEstoque, 'unidadeMedidaEstoque')->is_required()->min_value(0);
		
		if ($dataValidator->validate())
		{
			//PRODUTO MODEL
			$produtosModel = new produtosModel();
			$produtosModel->setId($id_produto);


			$status = Array(
				status::ATIVO,
				status::INATIVO
			);

			$produtos = new produtosDao();
			$produtosModel = $produtos->consultar(new consultaPorId(), $produtosModel, $status);


			//UNIDADE MEDIDA ESTOQUE MODEL
			$unidadeMedidaEstoqueModel = new unidadeMedidaEstoqueModel();
			$unidadeMedidaEstoqueModel->setId($unidadeMedidaEstoque);
			
			//LOCALIZACAO LOTE MODEL
			$localizacaoLoteModel = new localizacaoLoteModel();
			$localizacaoLoteModel->setUnidadeMedidaEstoque($unidadeMedidaEstoqueModel);
			$localizacaoLoteModel->setQuantidade($quantidade);
			$localizacaoLoteModel->setObservacoes($observacoes);
			$localizacaoLoteModel->armazenar();

			//LOTE MODEL
			$lotesModel = new lotesModel();
			$lotesModel->setCodigoLote($codigoLote);
			$lotesModel->setCodigoBarrasGti($codBarrasGti);
			$lotesModel->setCodigoBarrasGst($codBarrasGst);
			$lotesModel->setDataValidade($dataValidade);
			$lotesModel->addLocalizacao($localizacaoLoteModel);

			//ESTOQUE MODEL
			$estoqueModel = new estoqueModel();
			$estoqueModel->setProduto($produtosModel);
			$estoqueModel->addLote($lotesModel);

			//ESTOQUE DAO
			$estoqueDao = new estoqueDao();
			$estoqueDao->armazenarLote($estoqueModel);

		}else
	    {
			$this->http->response(json_encode($dataValidator->get_errors()),'400');
	    }
	}
}