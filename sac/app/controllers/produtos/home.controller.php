<?php
/*
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class home extends Controller{
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
		//$this->saveModules();
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Produtos'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('produtos/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function cadastrar()
	{
		//$this->saveModules();
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Cadastrar Produtos'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('produtos/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	public function editar()
	{
		//$this->saveAction();

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
		$marca = isset($_POST['marca']) ? filter_var($_POST['marca']) : '';
		$descricao = isset($_POST['descricao']) ? filter_var(trim($_POST['descricao'])) : '';
		$fornecedor = isset($_POST['fornecedor']) ? filter_var($_POST['fornecedor']) : '';
		

		//valores
		$precocompra = isset($_POST['preçocompra']) ? filter_var($_POST['preçocompra']) : '';
		$porcentagemlucro = isset($_POST['porcentagemlucro']) ? filter_var($_POST['porcentagemlucro']) : '';
		$precovenda = isset($_POST['precovenda']) ? filter_var($_POST['precovenda']) : '';
		$pesoliquido = isset($_POST['pesoliquido']) ? filter_var(trim($_POST['pesoliquido'])) : '';
		$pesobruto = isset($_POST['pesobruto']) ? filter_var(trim($_POST['pesobruto'])) : '';
		$quantidade = isset($_POST['quantidade']) ? filter_var($_POST['quantidade']) : '';
		$estoquemax = isset($_POST['estoquemax']) ? filter_var($_POST['estoquemax']) : '';
        $estoquemin = isset($_POST['estoquemin']) ? filter_var($_POST['estoquemin']) : '';
		$estoquetotal = isset($_POST['estoquetotal']) ? filter_var($_POST['estoquetotal']) : '';
		$dimensao = isset($_POST['dimensao']) ? filter_var(trim($_POST['dimensao'])) : '';
		$unidmed = isset($_POST['unidmed']) ? filter_var(trim($_POST['unidmed'])) : '';

		//categoria
		$nome_categoria = isset($_POST['nome_categoria']) ? filter_var($_POST['nome_categoria']) : '';
		$status_categoria = isset($_POST['status_categoria']) ? filter_var($_POST['status_categoria']) : '';
		$data_categoria = isset($_POST['data_categoria']) ? filter_var(trim($_POST['data_categoria'])) : '';


		
		//validação dos dados
		$this->load->library('dataValidator');
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(3);
		$this->dataValidator->set('Marca', $marca, 'marca')->is_required()->min_length(3);
		$this->dataValidator->set('Categoria', $categoria, 'categoria')->is_required()->min_length(3);
		$this->dataValidator->set('Fornecedor', $fornecedor, 'fornecedor')->is_required();
		$this->dataValidator->set('Precocompra', $precocompra, 'precocompra')->is_required();
		$this->dataValidator->set('Porcentagemlucro', $porcentagemlucro, 'porcentagemlucro')->is_required();
		$this->dataValidator->set('Quantidade', $quantidade, 'quantidade')->is_required()->is_num();
		$this->dataValidator->set('Estoquemax', $estoquemax, 'estoquemax')->is_required();
		$this->dataValidator->set('Estoquemin', $estoquemin, 'estoquemin')->is_required();
		$this->dataValidator->set('Estoquetotal', $estoquetotal, 'estoquetotal')->is_required();


		if ($this->dataValidator->validate())
		{
			//TELEFONES
			$categoriasList = Array();
			$this->load->model('categoriaModel');
			foreach ($categorias as $categoria)
			{
				$categoriaModel = new categoriaModel();
				$categoriaModel->setId_categoria( $id_categoria['id_categoria'] );
				$categoriaModel->setNome_categoria( $nome_categoria['nome_categoria'] );
				$categoriaModel->setStatus_categoria( $status_categoria['status_categoria'] );
				$categoriaModel->setData_categoria( $data_cate['data_categoria'] );
				array_push($categoriasList, $categoriaModel);
				unset($categoriaModel);
			}
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
