<?php
/*
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gerenciar extends Controller{
	public function __construct(){
		parent::__construct();
	}


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
			'titlePage' => 'Armazém - Estoque'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('estoque/armazem/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function entrada()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Entrada no Armazém - Estoque'
		);

		$this->load->dao('produtos/produtosDao');
		$produtosDao = new produtosDao();
		$produtos = $produtosDao->listarAtivos();
		$data['produtos'] = $produtos;
		
		$this->load->view('includes/header',$data);
		$this->load->view('estoque/armazem/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	public function getjsonlote()
	{
		$this->load->dao('estoque/estoqueDao');
		$this->load->dao('estoque/iListagemEstoque');
		$this->load->dao('estoque/listarArmazem');
		$estoqueDao = new estoqueDao();
		$estoque = $estoqueDao->listar(new listarArmazem());
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
						'nivel'=> (($estoqueProd->getQuantidadeTotal()- $estoqueProd->getNivelEstoque()->getQuantidadeMinima()) * 100) / ($estoqueProd->getNivelEstoque()->getQuantidadeMaxima() - $estoqueProd->getNivelEstoque()->getQuantidadeMinima()),
						'progressclass' => "progress-bar-success",
						'linkAlterarLimites' => URL."estoque/armazem/gerenciar/limitar",
						'acoes'=> "",
				      	'lotes'=> array()
				    );
			$arrLotes = array();


			//loop de listagem dos lotes
			foreach ($estoqueProd->getLotes() as $lotes){
				
				
		        $aux2 = array(
				        	'id' => $lotes->getId(),
				        	'idProduto' => $estoqueProd->getId(),
							'codigo' => $lotes->getCodigoLote(),
							'codigogti' => ($lotes->getCodigoBarrasGti() != '') ? $lotes->getCodigoBarrasGti() : $estoqueProd->getProduto()->getCodigoBarra(),
							'codigogst' => $lotes->getCodigoBarrasGst(),
							'validade' => $dataformat->formatar($lotes->getDataValidade(),'data'),
							'quantidade' => $lotes->getQuantidadeLotePorLocalizacao(). ' '.$lotes->getLocalizacao()[0]->getUnidadeMedidaEstoque()->getUnidadeMedida()->getNome(),
							'acoes' => "",
							'idUnidadeMedidaPraVenda' => $estoqueProd->getUnidadeMedidaParaVenda()->getId(),
							'nomeUnidadeMedida' => $estoqueProd->getUnidadeMedidaParaVenda()->getUnidadeMedida()->getNome(),
							'linkemprateleirar' => URL."estoque/armazem/gerenciar/emprateleirar",
							'linkdescartar' => URL."estoque/armazem/gerenciar/descartar"
				    	);

				array_push($aux['lotes'], $aux2);
			}

			array_push($_arEstoque, $aux);
        endforeach;

        return json_encode($_arEstoque);
	}


	//trasferencia de lotes para a prateleira
	public function emprateleirar()
	{
		$this->load->dao('estoque/estoqueDao');
		$this->load->model('estoque/lotesModel');
		$this->load->model('estoque/localizacaoLoteModel');
		$this->load->model('produtos/unidadeMedidaEstoqueModel');
		

		$idlote = (int) $this->http->getRequest('idlote');
		$idUnidadeMedidaVenda  = (int) $this->http->getRequest('idUnidadeMedidaVenda');
		$quantidade = filter_var( $this->http->getRequest('quantidade'));
		$observacoes = filter_var( $this->http->getRequest('observacoes'));
		
		$unidadeMedidaEstoqueModel = new unidadeMedidaEstoqueModel();
		$unidadeMedidaEstoqueModel->setId($idUnidadeMedidaVenda);


		$localizacaoLoteModel = new localizacaoLoteModel();
		$localizacaoLoteModel->setUnidadeMedidaEstoque($unidadeMedidaEstoqueModel);
		$localizacaoLoteModel->setQuantidade($quantidade);
		$localizacaoLoteModel->setObservacoes($observacoes);
		$localizacaoLoteModel->emprateleirar();

		$lotesModel = new lotesModel();
		$lotesModel->setId($idlote);
		$lotesModel->addLocalizacao($localizacaoLoteModel);

		$estoqueDao = new estoqueDao();
		$this->http->response($estoqueDao->emprateleirar($lotesModel));

	}

	public function limitar()
	{
		$this->load->dao('estoque/estoqueDao');
		$this->load->model('estoque/estoqueModel');
		$this->load->library('dataformat');
		$dataformat = new dataformat();
		$idEstoque 	= (int) $this->http->getRequest('idEstoque');
		$qtdMax 	= $dataformat->formatar($this->http->getRequest('qtdMax'), 'decimal', 'banco');
		$qtdMin 	= $dataformat->formatar($this->http->getRequest('qtdMin'), 'decimal', 'banco');

		//validação dos dados
		$this->load->library('dataValidator', null, true);
		$this->load->dataValidator->set('Quantidade mínima', $qtdMin, 'qtdMin')->is_required()->is_num();
		$this->load->dataValidator->set('Quantidade máxima', $qtdMax, 'qtdMax')->is_required()->is_num();
		if ($this->load->dataValidator->validate())
		{
			$estoqueModel = new estoqueModel();
			$estoqueModel->setId($idEstoque);

			$nivelEstoqueModel = new nivelEstoqueModel();
			$nivelEstoqueModel->setQuantidadeMinima($value['quantidade_minima']);
			$nivelEstoqueModel->setQuantidadeMaxima($value['quantidade_maxima']);
			
			
			$estoqueModel->setNivelEstoque($nivelEstoqueModel);
			
			$estoqueDao = new estoqueDao();
			$this->http->response($estoqueDao->limitar($estoqueModel));
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			$this->http->response(json_encode($todos_erros));
	    }
	}

}

