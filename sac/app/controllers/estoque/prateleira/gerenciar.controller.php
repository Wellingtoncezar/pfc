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
			'titlePage' => 'Prateleira - Estoque'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('estoque/prateleira/home',$data);
		$this->load->view('includes/footer',$data);
	}


	public function getjsonlote()
	{
		$this->load->dao('estoque/estoqueDao');
		$this->load->dao('estoque/iListagemEstoque');
		$this->load->dao('estoque/listarPrateleira');
		$estoqueDao = new estoqueDao();
		$estoque = $estoqueDao->listar(new listarPrateleira());
		$this->http->response($this->getJsonEstoque($estoque));
	}


	public function getJsonEstoque($estoque)
	{
		$this->load->library('dataformat');
		$dataformat = new dataformat();
		$_arEstoque = Array();

		//loop de listagem de produtos no estoque
		foreach ($estoque as $estoqueProd):
			$foto = $estoqueProd->getProduto()->getFoto() != '' ? URL.'skin/uploads/produtos/p/'.$estoqueProd->getProduto()->getFoto() : URL.'skin/img/imagens/forn.jpg';
			$aux = array(
				    	'id'=> $estoqueProd->getId(),
				    	'codigobarras' => $estoqueProd->getProduto()->getCodigoBarra(),
						'produto'=> $estoqueProd->getProduto()->getNome(),
						'foto'=> $foto,
						'qtdtotal'=> $dataformat->formatar($estoqueProd->getQuantidadeTotal(),'decimal').' '.$estoqueProd->getUnidadeMedidaParaEstoque()->getUnidadeMedida()->getNome(),
						'min'=> $dataformat->formatar($estoqueProd->getNivelEstoque()->getQuantidadeMinima(),'decimal'),
						'max'=> $dataformat->formatar($estoqueProd->getNivelEstoque()->getQuantidadeMaxima(),'decimal'),
						'minUnformated'=> $estoqueProd->getNivelEstoque()->getQuantidadeMinima(),
						'maxUnformated'=> $estoqueProd->getNivelEstoque()->getQuantidadeMaxima(),
						'nivel'=> $estoqueProd->getQuantidadeTotal(),//(($estoqueProd->getQuantidadeTotal()- $estoqueProd->getNivelEstoque()->getQuantidadeMinima()) * 100) / ($estoqueProd->getNivelEstoque()->getQuantidadeMaxima() - $estoqueProd->getNivelEstoque()->getQuantidadeMinima()),
						'progressclass' => "progress-bar-success",
						'linkAlterarLimites' => URL."estoque/armazem/gerenciar/limitar",
						'acoes'=> "",
				      	'lotes'=> array()
				    );
			$arrLotes = array();


			//loop de listagem dos lotes
			foreach ($estoqueProd->getLotes() as $lotes){
				
				
		        $aux2 = array(
		        			'idEstoque' => $estoqueProd->getId(),
				        	'id' => $lotes->getId(),
				        	'idProduto' => $estoqueProd->getId(),
							'codigo' => $lotes->getCodigoLote(),
							'codigogti' => ($lotes->getCodigoBarrasGti() != '') ? $lotes->getCodigoBarrasGti() : $estoqueProd->getProduto()->getCodigoBarra(),
							'codigogst' => $lotes->getCodigoBarrasGst(),
							'validade' => $dataformat->formatar($lotes->getDataValidade(),'data'),
							'quantidade' => $lotes->getQuantidadeLotePorLocalizacao(). ' '.$lotes->getLocalizacao()[0]->getUnidadeMedidaEstoque()->getUnidadeMedida()->getNome(),
							'qtdConvertido' => $lotes->getQuantidadeLotePorLocalizacao(),
							'nomeUnidadeConvertido' => $lotes->getLocalizacao()[0]->getUnidadeMedidaEstoque()->getUnidadeMedida()->getNome(),
							'qtdNaoConvertido' => $lotes->getQuantidadeLotePorLocalizacao(false),
							'acoes' => "",
							'idUnidadeMedidaPraVenda' => $estoqueProd->getUnidadeMedidaParaVenda()->getId(),
							'nomeUnidadeMedida' => $estoqueProd->getUnidadeMedidaParaVenda()->getUnidadeMedida()->getNome(),
							'linkarmazenar' => URL."estoque/prateleira/gerenciar/armazenar",
							'linkdescartar' => URL."estoque/prateleira/gerenciar/descartar"
				    	);

				array_push($aux['lotes'], $aux2);
			}

			array_push($_arEstoque, $aux);
        endforeach;

        return json_encode($_arEstoque);
	}


	//trasferencia de lotes para a prateleira
	public function armazenar()
	{
		$this->load->model('estoque/estoqueModel');
		$this->load->model('estoque/lotesModel');
		$this->load->model('estoque/localizacaoLoteModel');
		$this->load->model('produtos/unidadeMedidaEstoqueModel');
		$this->load->dao('estoque/estoqueDao');
		$this->load->library('dataValidator');

		$idEstoque				= (int) $this->http->getRequest('idEstoque');
		$idlote 				= (int) $this->http->getRequest('idlote');
		$idUnidadeMedidaVenda  	= (int) $this->http->getRequest('idUnidadeMedidaVenda');
		$quantidade 			= (double) $this->http->getRequest('quantidade');
		$observacoes 			= $this->http->getRequest('observacoes');
		
		//validação dos dados
		$dataValidator= new dataValidator();
		$dataValidator->set('Quantidade', $quantidade, 'quantidade')->is_required()->is_num();
		if ($dataValidator->validate())
		{
			//UNIDADE MEDIDA ESTOQUE MODEL
			$unidadeMedidaEstoqueModel = new unidadeMedidaEstoqueModel();
			$unidadeMedidaEstoqueModel->setId($idUnidadeMedidaVenda);

			//LOCALIZACAO LOTE MODEL
			$localizacaoLoteModel = new localizacaoLoteModel();
			$localizacaoLoteModel->setUnidadeMedidaEstoque($unidadeMedidaEstoqueModel);
			$localizacaoLoteModel->setQuantidade($quantidade);
			$localizacaoLoteModel->setObservacoes($observacoes);
			$localizacaoLoteModel->armazenar();

			//LOTES MODEL
			$lotesModel = new lotesModel();
			$lotesModel->setId($idlote);
			$lotesModel->addLocalizacao($localizacaoLoteModel);

			//ESTOQUE MODEL
			$estoqueModel = new estoqueModel();
			$estoqueModel->setId($idEstoque);
			$estoqueModel->addLote($lotesModel);

			//ESTOQUE DAO
			$estoqueDao = new estoqueDao();	
			
			if(!$estoqueDao->verificaQuantidadeTransferencia($estoqueModel, localizacoes::PRATELEIRA)){
				$mensagem = "Quantidade insuficiente para realizar a transferência";
				$this->http->response($mensagem);
			}else{
				$this->http->response($estoqueDao->transferir($estoqueModel, localizacoes::PRATELEIRA));
			}
			
				
		}else
	    {
			$todos_erros = $dataValidator->get_errors();
			$this->http->response(json_encode($todos_erros));
	    }
	}

}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
