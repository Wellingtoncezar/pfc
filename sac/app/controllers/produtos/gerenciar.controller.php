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

		$this->load->dao('produtos/produtosDao');
		$produtosDao = new produtosDao();
		$produtos = $produtosDao->listar(); 
		$data = array(
			'titlePage' => 'Produtos',
			'produtos' => $produtos
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('produtos/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function cadastrar()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Cadastrar Produtos'
		);

		//marcas -- obtendo a lista das marcas
		$this->load->dao('produtos/marcasDao');
		$marcas = new marcasDao;
		$data['marcas']=$marcas->listar();

		//categorias -- obtendo a lista das categorias
		$this->load->dao('produtos/categoriasDao');
		$categorias = new categoriasDao;
		$data['categorias']=$categorias->listar();

		//unidades de medida ---- obtendo a lista das unidades de medida
		$this->load->dao('produtos/unidademedidaDao');
		$unidademedida = new unidademedidaDao;
		$data['unidademedida']= $unidademedida->listar();

		//fornecedores -- obtendo a lista dos fornecedores
		$this->load->dao('fornecedores/fornecedoresDao');
		$fornecedores = new fornecedoresDao;
		$data['fornecedores']=$fornecedores->listar();
		
		$this->load->view('includes/header',$data);
		$this->load->view('produtos/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	public function editar()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$this->load->model('produtos/produtosModel');
		$this->load->dao('produtos/produtosDao');
		$this->load->dao('produtos/marcasDao');
		$this->load->dao('produtos/categoriasDao');
		$this->load->dao('produtos/iConsultaProduto');
		$this->load->dao('produtos/consultaPorId');

		$data = array(
			'titlePage' => 'Editar Produto'
		);

		$idProduto = (int) $this->load->url->getSegment(3);
		
		$status = Array(
			status::ATIVO,
			status::INATIVO
		);
		$produtosModel = new produtosModel();
		$produtosModel->setId($idProduto);
		$produtos = new produtosDao();
		$data['produto'] = $produtos->consultar(new consultaPorId(), $produtosModel, $status);
		//marcas
		$marcas = new marcasDao;
		$data['marcas']=$marcas->listar();

		//categorias
		$categorias = new categoriasDao;
		$data['categorias']=$categorias->listar();

		// //fornecedores
		// $this->load->dao('fornecedores/fornecedoresDao');
		// $fornecedores = new fornecedoresDao;
		// $data['fornecedores']=$fornecedores->listar();
		
		$this->load->view('includes/header',$data);
		$this->load->view('produtos/editar',$data);
		$this->load->view('includes/footer',$data);
	}




	public function precos()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$this->load->model('produtos/produtosModel');
		$this->load->dao('produtos/produtosDao');
		$this->load->dao('produtos/iConsultaProduto');
		$this->load->dao('produtos/consultaPorId');
		$this->load->dao('produtos/precosDao');

		$idProduto = (int) $this->load->url->getSegment(3);
		$data = array(
			'titlePage' => 'Tabela de preços',
			'idProduto' => $idProduto,
			'dataFormat' => new dataFormat()
		);
		$produtosModel = new produtosModel();
		$produtosModel->setId($idProduto);

		//obtendo o produto
		$produtos = new produtosDao();
		$produtosModel = $produtos->consultar(new consultaPorId(), $produtosModel, Array(status::ATIVO, status::INATIVO));

		//obtendo os preços do produto
		$precos = new precosDao();

		//setando os preços no produto
		$produtosModel->setPrecos($precos->listar($produtosModel));
		$data['produtoPreco'] = $produtosModel;
		

		$this->load->view('includes/header',$data);
		$this->load->view('produtos/precos/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function cadastrarprecos()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$idProduto = (int) $this->load->url->getSegment(3);
		$data = array(
			'titlePage' => 'Cadastrar preços',
			'idProduto' => $idProduto
		);


		$this->load->view('includes/header',$data);
		$this->load->view('produtos/precos/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	public function inserirPreco()
	{
		try {
			if(!$this->load->checkPermissao->check(false,URL.'produtos/gerenciar/cadastrarprecos')){
				$this->http->response("Ação não permitida");
				return false;
			}
			//carregamento das classes
			$this->load->library('dataFormat');
			$this->load->library('dataValidator');
			$this->load->model('produtos/produtosModel');
			$this->load->model('produtos/precosModel');
			$this->load->dao('produtos/precosDao');
			$dataFormat = new dataFormat();

			//obtenção dos dados
			$idProduto 	= (int) $this->http->getRequest('idProduto');
			$preco 		= (double) $dataFormat->formatar($this->http->getRequest('preco'),'decimal','banco');
			$padrao 	= (Boolean) $this->http->getRequest('padrao');
			$de 		= $dataFormat->formatar($this->http->getRequest('de'), 'data', 'banco');
			$ate 		= $dataFormat->formatar($this->http->getRequest('ate'), 'data', 'banco');


			//validação dos dados
			$dataValidator = new dataValidator();
			$dataValidator->set('Preço', $preco, 'preco')->is_required()->is_num();
			if($padrao == false)
			{
				$dataValidator->set('De', $de, 'de')->is_required()->is_date('Y-m-d');
				$dataValidator->set('Até', $ate, 'ate')->is_required()->is_date('Y-m-d');
			}
			
			if ($dataValidator->validate())
			{

				//PRODUTOS
				$produtosModel = new produtosModel();
				$produtosModel->setId($idProduto);
				
				//PREÇOS MODEL
				$precosModel = new precosModel();
				$precosModel->setPreco($preco);
				$precosModel->setDataInicio($de);
				$precosModel->setDataFim($ate);
				$precosModel->setPadrao($padrao);
				$precosModel->setDataCadastro(date('Y-m-d'));

				//PRECOS DAO
				$precosDao = new precosDao();
				$this->http->response($precosDao->inserir($produtosModel, $precosModel));
			}else
		    {
				$todos_erros = $dataValidator->get_errors();
				$this->http->response(json_encode($todos_erros));
		    }

		} catch (dbException $e) {
			$this->http->response($e->getMessageError());
		}
	}






	

	public function inserir()
	{
		try {
			if(!$this->load->checkPermissao->check(false,URL.'produtos/gerenciar/cadastrar'))
			{
				$this->http->response("Ação não permitida");
				return false;
			}


			$this->load->model('produtos/produtosModel');
			$this->load->model('produtos/marcasModel');
			$this->load->model('produtos/categoriasModel');
			$this->load->model('produtos/unidadeMedidaModel');
			$this->load->model('produtos/unidadeMedidaEstoqueModel');
			$this->load->model('produtos/precosModel');
			$this->load->dao('produtos/precosDao');
			$this->load->dao('produtos/produtosDao');


			//obtendo os dados enviados pela requisição
			$dataFormat = new dataFormat();
			$foto 					= isset($_FILES['foto']) ? $_FILES['foto'] : '';
			$nome 					= $this->http->getRequest('nome');
			$codigoBarra 			= $this->http->getRequest('codigobarras');
			$marca 					= $this->http->getRequest('marca');
			$categoria 				= $this->http->getRequest('categoria');
			$preco 					= $dataFormat->formatar($this->http->getRequest('preco'), 'decimal', 'banco');
	        $controlarvalidade 		= (boolean)$this->http->getRequest('controlarvalidade');
	        $descricao 				= $this->http->getRequest('descricao');
			$fornecedores 			= (Array) $this->http->getRequest('fornecedores');
			$unidadeMedidaEstoque 	= $this->http->getRequest('unidadeMedidaEstoque');


			//validação dos dados
			$dataValidator = new dataValidator();
			$dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(3);
			$dataValidator->set('Marca', $marca, 'marca')->is_required();
			$dataValidator->set('Categoria', $categoria, 'categoria')->is_required();
			$dataValidator->set('Preço', $preco, 'preco')->is_required();
			$dataValidator->set('Fornecedores', $fornecedores, 'fornecedores')->is_required()->min_value(3);
			$dataValidator->set('Unidades de medidas de estoque', $unidadeMedidaEstoque, 'unidadeMedidaEstoque')->is_required();


			if ($dataValidator->validate())
			{
				//PRODUTOS
				$produtosModel = new produtosModel();

				//MARCA
				$marcasModel = new marcasModel();
				$marcasModel->setId($marca);

				//CATEGORIA
				$categoriasModel = new categoriasModel();
				$categoriasModel->setId($categoria);
				


				//UNIDADES DE MEDIDA DE ESTOQUE -- obtendo as unidades de medida 
				foreach ($unidadeMedidaEstoque as $unidade)
				{
					$unidade['venda'] = $unidade['venda']== "true" ? true : false;
					$unidade['estoque'] = $unidade['estoque']== "true" ? true : false;
					$fator = $dataFormat->formatar($unidade['fator_unidade'],'decimal','banco');

					$unidadeMedidaModel = new unidadeMedidaModel();
					$unidadeMedidaModel->setId($unidade['idUnidadeMedida']);

					$unidadeMedidaEstoqueModel = new unidadeMedidaEstoqueModel();
					$unidadeMedidaEstoqueModel->setId($unidade['idUnidadeMedidaProduto']);
					$unidadeMedidaEstoqueModel->setUnidadeMedida($unidadeMedidaModel);
					$unidadeMedidaEstoqueModel->setParaVenda($unidade['venda']);
					$unidadeMedidaEstoqueModel->setParaEstoque($unidade['estoque']);
					$unidadeMedidaEstoqueModel->setFator($fator);
					$unidadeMedidaEstoqueModel->setOrdem($unidade['ordem']);
					//adicionando as unidades no produto
					$produtosModel->addUnidadeMedidaEstoque($unidadeMedidaEstoqueModel);
				}

				//FORNECEDORES -- obtendo os fonecedores do produto
				$this->load->model('fornecedores/fornecedoresModel');
				$this->load->model('produtos/produtofornecedorModel');
				foreach ($fornecedores as $fornec)
				{
					$fornecedoresModel = new fornecedoresModel();
					$fornecedoresModel->setId($fornec['id']);
					
					$produtofornecedorModel = new produtofornecedorModel();
					$produtofornecedorModel->setFornecedor($fornecedoresModel);
					//adicionando os fornecedores ao produto
					$produtosModel->addFornecedor($produtofornecedorModel);
				}

				//IMAGEM
				//obtendo a imagem e realizando o upload
				$nome_foto = '';
				if(!empty($foto))
				{
					//obtendo o tamanho do corte da imagem
					$cropValues = Array(
						'w' => $this->http->getRequest('w'),
						'h' => $this->http->getRequest('h'),
						'x1' => $this->http->getRequest('x1'),
						'y1' => $this->http->getRequest('y1')
					);

					//definindo o tamanho da imagem após o upload
					$tamanho = Array(
						'p' =>array(
								'w' => 404,
								'h' =>  158
							)
					);
					//renomeando a imagem
					$nome_foto = md5(date('dmYHis'));

					// realizando o upload
					$this->load->library('uploadFoto');
					$upload = new uploadFoto('produtos', $foto, $nome_foto, $tamanho, $cropValues);
					$nome_foto = $upload->getNomeArquivo();
				
				}

				// //FORMATAÇÃO DOS DADOS
				$produtosModel->setFoto($nome_foto);
				$produtosModel->setCodigoBarra($codigoBarra);
				$produtosModel->setNome($nome);
				$produtosModel->setMarca($marcasModel);
				$produtosModel->setCategoria($categoriasModel);
				$produtosModel->setDescricao($descricao);
				$produtosModel->setDataCadastro(date('Y-m-d h:i:s'));
				//definindo controle de validade
				if($controlarvalidade == true)
					$produtosModel->ativarControleValidade();
				else
					$produtosModel->desativarControleValidade();
				//adicionando o preço padrão ao produto
				$precosModel = new precosModel();
				$precosModel->setPreco($preco);
				$precosModel->setPadrao(true);
				

				//PRODUTOS DAO
				$produtosDao = new produtosDao();
				$produtosModel = $produtosDao->inserir($produtosModel);
				//se o produto foi cadastrado corretamente
				if($produtosModel->getId() != '')
				{
					//insere o preço padrão
					$precosDao = new precosDao();
					$precosDao->inserir($produtosModel, $precosModel);
					$this->http->response(true);
				}
			}else
		    {
		    	//exibindo os erro de validação
				$this->http->response(json_encode($dataValidator->get_errors()));
		    }
		}catch (dbException $e) {
			//se tiver algum erro no banco
			$this->http->response($e->getMessageError());
			return false;
		}catch (Exception $e) {
			//se tiver algum erro no envio da imagem ou outro erro que seja diferente do banco
			$this->http->response($e->getMessage());
			return false;
		}

	}

	public function atualizar()
	{
		if(!$this->load->checkPermissao->check(false,URL.'produtos/gerenciar/atualizar'))
		{
			echo "Ação não permitida";
			return false;
		}
		$idProduto = isset($_POST['id_produto']) ? filter_var($_POST['id_produto']) : '';
		$foto = isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$marca = isset($_POST['marca']) ? intval($_POST['marca']) : '';
		$categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : '';
        $descricao = isset($_POST['descricao']) ? filter_var(trim($_POST['descricao'])) : '';
		$fornecedores = isset($_POST['fornecedores']) ? filter_var_array($_POST['fornecedores']) : Array();

		$preco_custo = isset($_POST['preco_custo']) ? filter_var($_POST['preco_custo']) : '';
		$preco_venda = isset($_POST['preco_venda']) ? filter_var($_POST['preco_venda']) : '';
		$markup = isset($_POST['markup']) ? filter_var($_POST['markup']) : '';
		$uni_medida = isset($_POST['uni_medida']) ? filter_var(trim($_POST['uni_medida'])) : '';

		//validação dos dados
		$this->load->library('dataValidator', null, true);
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(3);
		$this->load->dataValidator->set('Marca', $marca, 'marca')->is_required();
		$this->load->dataValidator->set('Categoria', $categoria, 'categoria')->is_required();
		$this->load->dataValidator->set('Fornecedores', $fornecedores, 'listafornecedores')->is_required();
		$this->load->dataValidator->set('Preço de custo', $preco_custo, 'preco_custo')->is_required();
		$this->load->dataValidator->set('Preço de venda', $preco_venda, 'preco_venda')->is_required();
		$this->load->dataValidator->set('Markup', $markup, 'markup')->is_required();
		$this->load->dataValidator->set('Unidade de Medida', $uni_medida, 'uni_medida')->is_required();

		if ($this->load->dataValidator->validate())
		{
			//PRODUTOS
			$this->load->model('produtos/produtosModel');
			$produtosModel = new produtosModel();

			//MARCA
			$this->load->model('produtos/marcasModel');
			$marcasModel = new marcasModel();
			$marcasModel->setId($marca);

			//CATEGORIA
			$this->load->model('produtos/categoriasModel');
			$categoriasModel = new categoriasModel();
			$categoriasModel->setId($categoria);

			//UNIDADE DE MEDIDA
			$this->load->model('produtos/unidademedidaModel');
			$unidademedidaModel = new unidademedidaModel();
			$unidademedidaModel->setId($uni_medida);


			

			//FORNECEDORES
			$this->load->model('fornecedores/fornecedoresModel');
			$this->load->model('produtos/produtofornecedorModel');
			foreach ($fornecedores as $fornec)
			{
				if($fornec['principal'] == 'true')
					$principal = true;
				else
					$principal = false;

				$fornecedoresModel = new fornecedoresModel();
				$fornecedoresModel->setId($fornec['id']);

				$produtofornecedorModel = new produtofornecedorModel();
				$produtofornecedorModel->setFornecedor($fornecedoresModel);
				$produtofornecedorModel->setPrincipal($principal);

				$produtosModel->setFornecedores($produtofornecedorModel);
			}

			//FORMATAÇÃO DOS DADOS
			$this->load->library('dataFormat', null, true);
			$preco_custo = $this->load->dataFormat->formatar($preco_custo,'decimal','banco');
			$preco_venda = $this->load->dataFormat->formatar($preco_venda,'decimal','banco');
			$markup = $this->load->dataFormat->formatar($markup,'decimal','banco');


			
			$produtosModel->setFoto($foto);
			$produtosModel->setNome($nome);
			$produtosModel->setMarca($marcasModel);
			$produtosModel->setCategoria($categoriasModel);
			$produtosModel->setDescricao($descricao);
			$produtosModel->setUnidadeMedida($unidademedidaModel);

			$produtosModel->setPrecocusto($preco_custo);
			$produtosModel->setPrecovenda($preco_venda);
			$produtosModel->setMarkup($markup);
			$produtosModel->setStatus(status::ATIVO);
			$produtosModel->setDataCadastro(date('Y-m-d h:i:s'));

			//PRODUTOS DAO
			$this->load->dao('produtos/produtosDao');
			$produtosDao = new produtosDao();
			echo $produtosDao->atualizar($produtosModel);
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}

	/**
	 * Ãção de atualizar status
	 */
	public function atualizarStatus()
	{
		$idProduto = intval($_POST['id']);
		$status = filter_var($_POST['status']);

		//PRODUTOS MODEL
		$this->load->model('produtos/produtosModel');
		$produtosModel = new produtosModel();
		$produtosModel->setId( $idProduto );
		$produtosModel->setStatus( status::getAttribute($status));

		//PRODUTOS DAO
		$this->load->dao('produtos/produtosDao');
		$produtosDao = new produtosDao();
		echo $produtosDao->atualizarStatus($produtosModel);

	}

	public function excluir()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();

		if(!$this->load->checkPermissao->check(false,URL.'produtos/gerenciar/excluir'))
		{
			echo "Ação não permitida";
			return false;
		}
		$this->atualizarStatus();
	}
}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
