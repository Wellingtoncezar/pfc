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

		$data = array(
			'titlePage' => 'Produtos'
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

		$data = array(
			'titlePage' => 'Cadastrar Produtos'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('produtos/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	public function editar()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();

		$data = array(
			'titlePage' => 'Editar produtos'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('produtos/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	public function inserir()
	{
		$foto = isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$marca = isset($_POST['marca']) ? intval($_POST['marca']) : '';
		$categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : '';
        $descricao = isset($_POST['descricao']) ? filter_var(trim($_POST['descricao'])) : '';
		$fornecedor = isset($_POST['fornecedor']) ? intval($_POST['fornecedor']) : '';
		

		//valores
		$precocompra = isset($_POST['preco_compra']) ? filter_var($_POST['preco_compra']) : '';
		$porcentagemlucro = isset($_POST['porcentagem_lucro']) ? filter_var($_POST['porcentagem_lucro']) : '';
		$precovenda = isset($_POST['preco_venda']) ? filter_var($_POST['preco_venda']) : '';
		$peso = isset($_POST['peso']) ? filter_var(trim($_POST['peso'])) : '';
		$quantidade = isset($_POST['quantidade']) ? filter_var($_POST['quantidade']) : '';
		$uni_medida = isset($_POST['uni_medida']) ? filter_var(trim($_POST['uni_medida'])) : '';
		$estoque_max = isset($_POST['estoque_max']) ? filter_var($_POST['estoque_max']) : '';
        $estoque_min = isset($_POST['estoque_min']) ? filter_var($_POST['estoque_min']) : '';
		

		//categoria
		$nome_categoria = isset($_POST['nome_categoria']) ? filter_var($_POST['nome_categoria']) : '';
		$status_categoria = isset($_POST['status_categoria']) ? filter_var($_POST['status_categoria']) : '';
		$data_categoria = isset($_POST['data_categoria']) ? filter_var(trim($_POST['data_categoria'])) : '';

		//Marca
		$nome_marca = isset($_POST['nome_marca']) ? filter_var($_POST['nome_marca']) : '';
		$status_marca = isset($_POST['status_marca']) ? filter_var($_POST['status_marca']) : '';
		$data_marca = isset($_POST['data_marca']) ? filter_var(trim($_POST['data_marca'])) : '';

		
		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(3);
		$this->dataValidator->set('Fornecedor', $fornecedor, 'fornecedor')->is_required();
		$this->dataValidator->set('Preço compra', $precocompra, 'preco_compra')->is_required();
		$this->dataValidator->set('Porcentagem lucro', $porcentagemlucro, 'porcentagem_lucro')->is_required();
		$this->dataValidator->set('Quantidade', $quantidade, 'quantidade')->is_required()->is_num();
		$this->dataValidator->set('Unidade de Medida', $uni_medida, 'uni_medida')->is_required();
		$this->dataValidator->set('Estoque maximo', $estoque_max, 'estoque_max')->is_required();
		$this->dataValidator->set('Estoque minimo', $estoque_min, 'estoque_min')->is_required();


		if ($this->dataValidator->validate())
		{


			//CATEGORIA
			$this->load->model('categoriasModel');
			$categoriasModel = new categoriasModel();
			$categoriasModel->setId($id_categoria);
			$categoriasModel->setNome($nome_categoria);


			//MARCA
			$this->load->model('marcasModel');
			$marcasModel = new marcasModel();
			$marcasModel->setId($id_marca);
			$marcasModel->setNome($nome_marca);

			//FORNECEDOR
			$this->load->model('fornecedoresModel');
			$fornecedoresModel = new fornecedoresModel();
			$fornecedoresModel->setId($id_fornecedor);
			$fornecedoresModel->setRazaoSocial($$razao_social);

			//FORMATAÇÃO DOS DADOS
			$this->load->library('dataFormat', null, true);
			$precocompra = $this->dataFormat->formatar($precocompra,'decimal','banco');
			$porcentagemlucro = $this->dataFormat->formatar($porcentagemlucro,'decimal','banco');
			$precovenda = $this->dataFormat->formatar($precovenda,'decimal','banco');


			//PRODUTOS
			$this->load->model('produtos/produtosModel');
			$produtosModel = new produtosModel();
			$produtosModel->setFoto($foto);
			$produtosModel->setNome($nome);
			$produtosModel->setMarcas($marcasModel);
			$produtosModel->setCategorias($categoriasModel);
			$produtosModel->setDescricao($descricao);
			$produtosModel->setFornecedor($fornecedor);
			$produtosModel->setPrecoCompra($precocompra);
			$produtosModel->setPorcentagemLucro($porcentagemlucro);
			$produtosModel->setPrecoVenda($precovenda);
			$produtosModel->setPeso($peso);
			$produtosModel->setQuantidade($quantidade);
			$produtosModel->setuni_medida($uni_medida);
			$produtosModel->setEstoqueMax($estoque_max);
			$produtosModel->setEstoqueMin($estoque_min);
			$produtosModel->setStatus(status::ATIVO);
			$produtosModel->setDataCadastro(date('Y-m-d h:i:s'));
		
		//FUNCIONARIO DAO
			$this->load->dao('produtos/produtosDao');
			$produtosDa = new produtosDao();
			echo $produtosDa->inserir($produtosModel);
		}else
	    {
			$todos_erros = $this->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}
}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
