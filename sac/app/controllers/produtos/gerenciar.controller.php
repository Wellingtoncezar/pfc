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
			'produtos' => $produtos,
			'template' => new templateFactory()
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

		//marcas
		$this->load->dao('produtos/marcasDao');
		$marcas = new marcasDao;
		$data['marcas']=$marcas->listar();

		//categorias
		$this->load->dao('produtos/categoriasDao');
		$categorias = new categoriasDao;
		$data['categorias']=$categorias->listar();

		//unidades de medida
		$this->load->dao('produtos/unidademedidaDao');
		$unidademedida = new unidademedidaDao;
		$data['unidademedida']= $unidademedida->listar();

		//fornecedores
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
		// $this->load->dao('produtos/unidademedidaDao');

		$data = array(
			'titlePage' => 'Editar Produto'
		);

		$idProduto = $this->load->url->getSegment(3);
		
		$produtosModel = new produtosModel();
		$produtosModel->setId($idProduto);
		
		$produtos = new produtosDao();
		$data['produto'] = $produtos->consultar($produtosModel);

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

	public function inserir()
	{
		if(!$this->load->checkPermissao->check(false,URL.'produtos/gerenciar/cadastrar'))
		{
			echo "Ação não permitida";
			return false;
		}

		$this->load->library('dataFormat', null, true);
		$this->load->model('produtos/produtosModel');
		$this->load->model('produtos/marcasModel');
		$this->load->model('produtos/categoriasModel');
		$this->load->model('produtos/unidadeMedidaModel');
		$this->load->model('produtos/unidadeMedidaEstoqueModel');
		$this->load->dao('produtos/produtosDao');

		$foto 					= isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome 					= isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$codigoBarra 			= isset($_POST['codigoBarra']) ? intval($_POST['codigoBarra']) : '';
		$marca 					= isset($_POST['marca']) ? intval($_POST['marca']) : '';
		$categoria 				= isset($_POST['categoria']) ? intval($_POST['categoria']) : '';
        $descricao 				= isset($_POST['descricao']) ? filter_var(trim($_POST['descricao'])) : '';
		$fornecedores 			= isset($_POST['fornecedores']) ? filter_var_array($_POST['fornecedores']) : Array();
		$unidadeMedidaEstoque 	= isset($_POST['unidadeMedidaEstoque']) ? filter_var_array($_POST['unidadeMedidaEstoque']) : array();
		$unidadeMedidaVenda 	= isset($_POST['unidadeMedidaVenda']) ? filter_var($_POST['unidadeMedidaVenda']) : '';
		$fatorUnidadeMedidaVenda= isset($_POST['fatorUnidadeMedidaVenda']) ? filter_var($_POST['fatorUnidadeMedidaVenda']) : '';


		//validação dos dados
		$this->load->library('dataValidator', null, true);
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(3);
		$this->load->dataValidator->set('Marca', $marca, 'marca')->is_required();
		$this->load->dataValidator->set('Categoria', $categoria, 'categoria')->is_required();
		$this->load->dataValidator->set('Fornecedores', $fornecedores, 'fornecedores')->is_required();
		$this->load->dataValidator->set('Unidades de medidas de estoque', $unidadeMedidaEstoque, 'unidadeMedidaEstoque')->is_required();
		$this->load->dataValidator->set('Unidade de medida para venda', $unidadeMedidaVenda, 'unidadeMedidaVenda')->is_required();
		$this->load->dataValidator->set('Fator da unidade de medida para venda', $fatorUnidadeMedidaVenda, 'fatorUnidadeMedidaVenda')->is_required();
		if ($this->load->dataValidator->validate())
		{
			//PRODUTOS
			$produtosModel = new produtosModel();

			//MARCA
			$marcasModel = new marcasModel();
			$marcasModel->setId($marca);

			//CATEGORIA
			$categoriasModel = new categoriasModel();
			$categoriasModel->setId($categoria);
			
			$unidadeMedidaVendaModel = new unidadeMedidaModel();
			$unidadeMedidaVendaModel->setId($unidadeMedidaVenda);


			//UNIDADES DE MEDIDA DE ESTOQUE
			foreach ($unidadeMedidaEstoque as $unidade)
			{
				$unidade['venda'] = $unidade['venda']== "true" ? true : false;
				$unidade['estoque'] = $unidade['estoque']== "true" ? true : false;
				$fator = $this->load->dataFormat->formatar($unidade['fator_unidade'],'decimal','banco');

				$unidadeMedidaModel = new unidadeMedidaModel();
				$unidadeMedidaModel->setId($unidade['idUnidadeMedida']);

				$unidadeMedidaEstoqueModel = new unidadeMedidaEstoqueModel();
				$unidadeMedidaEstoqueModel->setId($unidade['idUnidadeMedidaProduto']);
				$unidadeMedidaEstoqueModel->setUnidadeMedida($unidadeMedidaModel);
				$unidadeMedidaEstoqueModel->setParaVenda($unidade['venda']);
				$unidadeMedidaEstoqueModel->setParaEstoque($unidade['estoque']);
				$unidadeMedidaEstoqueModel->setFator($fator);
				$unidadeMedidaEstoqueModel->setOrdem($unidade['ordem']);
				$produtosModel->addUnidadeMedidaEstoque($unidadeMedidaEstoqueModel);
			}

			//FORNECEDORES
			$this->load->model('fornecedores/fornecedoresModel');
			foreach ($fornecedores as $fornec)
			{
				$fornecedoresModel = new fornecedoresModel();
				$fornecedoresModel->setId($fornec['id']);
				$produtosModel->addFornecedor($fornecedoresModel);
			}

			//IMAGEM
			$cropValues = Array(
				'w' => $_POST['w'],
				'h' => $_POST['h'],
				'x1' => $_POST['x1'],
				'y1' => $_POST['y1']
			);
			$tamanho = Array(
				'p' =>array(
						'w' => 404,
						'h' =>  158
					)
			);
			$nome_foto = '';
			if(!empty($foto))
			{
				$nome_foto = md5(date('dmYHis'));
				try {
					$this->load->library('uploadFoto');
					$upload = new uploadFoto('produtos', $foto, $nome_foto, $tamanho, $cropValues);
					$nome_foto = $upload->getNomeArquivo();
				} catch (Exception $e) {
					echo $e->getMessage();
					return false;
				}
			}

			// //FORMATAÇÃO DOS DADOS


			$produtosModel->setFoto($nome_foto);
			$produtosModel->setNome($nome);
			$produtosModel->setMarca($marcasModel);
			$produtosModel->setCategoria($categoriasModel);
			$produtosModel->setDescricao($descricao);
			$produtosModel->setUnidadeMedidaVenda($unidadeMedidaVendaModel);
			$produtosModel->setFatorUnidadeMedidaVenda($fatorUnidadeMedidaVenda);
			
			$produtosModel->setDataCadastro(date('Y-m-d h:i:s'));
			//PRODUTOS DAO
			$produtosDao = new produtosDao();
			try {
				echo $produtosDao->inserir($produtosModel);
			} catch (Exception $e) {
				echo $e->getMessage();
				return false;
			}
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
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
