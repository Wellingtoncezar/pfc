<?php
/**
 * Classe DAO de Produtos
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class produtosDao extends Dao{
	private $nomeArquivoFoto;
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros dos produtos
	 * @return Array
	 */
	public function listar()
	{
		$this->load->model('produtos/produtosModel');
		$produtos = Array();

		$this->db->clear();
		$this->db->setTabela('produtos as A, marcas as B, categorias as C');
		$this->db->setCondicao("A.status_produto in('".status::ATIVO."','".status::INATIVO."') AND A.id_marca = B.id_marca AND A.id_categoria = C.id_categoria");
		$campos = array('A.id_produto','A.codigo_barras_produto','A.foto_produto','A.nome_produto','B.nome_marca','C.nome_categoria','status_produto');
		$this->db->select($campos);
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$produtosModel = new produtosModel();
				$produtosModel->setId($value['id_produto']);
				$produtosModel->setCodigoBarras($value['codigo_barras_produto']);
				$produtosModel->setFoto($value['foto_produto']);
				$produtosModel->setNome($value['nome_produto']);
				$produtosModel->setStatus(status::getAttribute($value['status_produto']));
				array_push($produtos, $produtosModel);
				unset($produtosModel);
			}
			return $produtos;
		else:
			
			return $produtosModel;
		endif;
	}


	/**
	 * Retorna a consulta de um produto pelo id
	 * @return object [funcionariosModel]
	 */
	public function consultar(produtosModel $produto)
	{
		$this->db->clear();
		$this->db->setTabela('produtos as a , categorias as b , marcas as c');
		$this->db->setCondicao("a.id_produto = '".$produto->getId()."' and b.id_categoria = a.id_categoria and c.id_marca = a.id_marca");
		$this->db->select();

		//PRODUTO
		if($this->db->rowCount() > 0):
			$result = $this->db->result();
			//CATEGORIA
			$this->load->model('produtos/categoriasModel');
			$categoriasModel= new categoriasModel();
			$categoriasModel->setId($result['id_categoria']);
			$categoriasModel->setNome( $result['nome_categoria'] );
			$categoriasModel->setStatus(status::getAttribute($result['status_categoria']));
			$categoriasModel->setDataCadastro($result['data_cadastro_categoria']);

			//MARCA
            $this->load->model('produtos/marcasModel');
            $marcasModel= new marcasModel();
			$marcasModel->setId( $result['id_marca'] );
			$marcasModel->setNome( $result['nome_marca'] );
			$marcasModel->setStatus(status::getAttribute($result['status_marca']));
			$marcasModel->setDataCadastro($result['data_cadastro_marca']);
			
			//FORNECEDORES
			$this->db->clear();
		    $this->db->setTabela('produto_fornecedores as a , fornecedores as b ');
		    $this->db->setCondicao("a.id_produto = '".$produto->getId()."' and a.id_fornecedor = b.id_fornecedor");
		    $this->db->select();
		    

		    if($this->db->rowCount() > 0):

		    	$resultFornec = $this->db->resultAll();
				//FORNECEDORES
				$this->load->model('fornecedores/fornecedoresModel');
				$this->load->model('produtos/produtofornecedorModel');
				foreach ($resultFornec as $fornec)
				{
					/*
					if($fornec['principal'] == 'true')
						$principal = true;
					else
						$principal = false;
					*/
					$fornecedoresModel = new fornecedoresModel();
					$fornecedoresModel->setId($fornec['id_fornecedor']);
					$fornecedoresModel->setRazaoSocial($fornec['razao_social_fornecedor']);
					$fornecedoresModel->setFoto($fornec['foto_fornecedor']);
					

					$produtofornecedorModel = new produtofornecedorModel();
					$produtofornecedorModel->setFornecedor($fornecedoresModel);
					$produtofornecedorModel->setPrincipal($fornec['fornecedor_principal']);

					$produto->setFornecedores($produtofornecedorModel);
				}

			endif;

			$produto->setFoto($result['foto_produto']);
			$produto->setNome($result['nome_produto']);
			$produto->setMarca($marcasModel);
			$produto->setCategoria($categoriasModel);
			$produto->setDescricao($result['descricao_produto']);
			//$produto->setUnidadeMedida($unidademedidaModel);

			$produto->setPrecocusto($result['preco_custo']);
			$produto->setPrecovenda($result['preco_venda']);
			$produto->setMarkup($result['markup_produto']);
			$produto->setStatus(status::getAttribute($result['status_produto']));
			$produto->setDataCadastro($result['data_cadastro_produto']);
		endif;
		return $produto;
	}



	/**
	 * Insere novos produtos
	 * @return boolean, json
	 */
 	public function inserir(produtosModel $produto)
 	{
 		

	 	if($produto->getFoto() != '')
	 	{
	  		//nome da imagem
	 		$char = new caracteres($produto->getNome());
	 		$this->nomeArquivoFoto = $char->getValor().'_'.date('HisdmY').'';
			
	 		$upload = $this->uploadFoto($this->nomeArquivoFoto, $produto->getFoto()); //upload da foto
	 		if($upload)
	 			return $this->insertData($produto);
	 		else
	 			return $upload;
	 	}else
		{
			return $this->insertData($produto);
		}

	 }

	/**
	 * Atualiza produtos
	 * @return boolean, json
	 */
 	public function atualizar(produtosModel $produto)
 	{

		if($produto->getFoto() != '')
		{
	 		$this->db->clear();
	 		$this->db->setTabela('produtos');
	 		$this->db->setCondicao("id_produto = '".$produto->getId()."'");
	 		$this->db->select(array('foto_produto'));
	 		$res = $this->db->result();
	 		$this->nomeArquivoFoto = pathinfo($res['foto_produto'],PATHINFO_FILENAME);
			if($this->nomeArquivoFoto == '')
			{
		 		//nome da imagem
				$char = new caracteres($produto->getNome());
				$this->nomeArquivoFoto = $char->getValor().'_'.date('HisdmY').'';
			}
				
			$upload = $this->uploadFoto($this->nomeArquivoFoto, $produto->getFoto()); //upload da foto
			if($upload)
				return $this->updateData($produto);
			else
				return $upload;
		}else
		{
			return $this->updateData($produto);
		}

	}


	public function insertData(produtosModel $produto)
	{
 		$data = array(
 			'nome_produto' => $produto->getNome(),
 			'id_marca' => $produto->getMarca()->getId(),
 			'id_categoria' => $produto->getCategoria()->getId(),
 			'descricao_produto' => $produto->getDescricao(),
 			'preco_custo' => $produto->getPrecocusto(),
 			'preco_venda' => $produto->getPrecovenda(),
 			'markup_produto' => $produto->getMarkup(),
 			'id_unidade_medida' => $produto->getUnidadeMedida()->getId(),
 			'status_produto' => $produto->getStatus(),
 			'data_cadastro_produto' => $produto->getDataCadastro()
 		);


 		$this->db->clear();
		$this->db->setTabela('produtos');
		$this->db->insert($data);
		if($this->db->rowCount() > 0)
		{
			$produto->setId($this->db->getUltimoId()); //RETORNA O ID INSERIDO

			//FORNECEDORES
			if(!empty($produto->getFornecedores()))
			 	$this->atualizaFornecedores($produto);

			return true;
 		}else
 		{
 			return json_encode(array('erro'=>'Erro ao inserir registro'));
 		}
 		
 	}

 	private function updateData(produtosModel $produto)
	{

 		$data = array(
 			'nome_produto' => $produto->getNome(),
 			'id_marca' => $produto->getMarca()->getId(),
 			'id_categoria' => $produto->getCategoria()->getId(),
 			'descricao_produto' => $produto->getDescricao(),
 			'preco_custo' => $produto->getPrecocusto(),
 			'preco_venda' => $produto->getPrecovenda(),
 			'markup_produto' => $produto->getMarkup(),
 			'id_unidade_medida' => $produto->getUnidadeMedida()->getId(),
 			'status_produto' => $produto->getStatus(),
 			'data_cadastro_produto' => $produto->getDataCadastro()
 		);



 	


 		$this->db->clear();
		$this->db->setTabela('produtos');
		$this->db->setCondicao("id_produto = '".$produto->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount() > 0)
		{
		
			//FORNECEDORES
			if(!empty($produto->getFornecedores()))
			 	$this->atualizaFornecedores($produto);

			return true;
 		}else
 		{
 			return json_encode(array('erro'=>'Erro ao inserir registro'));
 		}
 		
 	}



 	/**
 	 * 
 	 * @return void
 	 */
 	private function atualizaFornecedores(produtosModel $produto)
	{

		//excluir
		$fornecedorExcluir = array();
		foreach ($produto->getfornecedores() as $fornecedor)
		{
			if($fornecedor->getId() != '')
				array_push($fornecedorExcluir,$fornecedor->getFornecedor()->getId());
		}
		$cond = '';
		if(!empty($fornecedorExcluir))
		{
			$fornecedorExcluir = implode(',', $fornecedorExcluir);
			$this->db->clear();
			$cond = " AND id_fornecedor not in (".$fornecedorExcluir.")";
		}
		$sql = "DELETE FROM produto_fornecedores WHERE id_produto = '".$produto->getId()."' $cond";
		$this->db->query($sql);
		if($this->db->rowCount() > 0)

		$this->db->clear();
		$this->db->setTabela('produto_fornecedores');
		foreach ($produto->getFornecedores() as $fornecedores)
		{
			if(!empty($fornecedores))
			{
				$data = array(
					'id_produto' => $produto->getId(),
					'id_fornecedor' => $fornecedores->getFornecedor()->getId(),
					'fornecedor_principal' =>$fornecedores->getPrincipal()
				);

				if($fornecedores->getId() != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
				{
					$this->db->setCondicao('id_produto_fornecedor = "'.$fornecedores->getId().'"');
					$this->db->update($data);
				}else{
					$this->db->insert($data);
				}

				if($this->db->rowCount() > 0)
					$this->nUpdates++;
			}
		}


	}





	/**
 	 * Atualiza o status
 	 * @return boolean
 	 */
	public function atualizarStatus(produtosModel $produto)
	{
		$data = array('status_produto'=>$produto->getStatus());
		$this->db->clear();
		$this->db->setTabela('produtos');
		$this->db->setCondicao("id_produto = '".$produto->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount()>0)
			return true;
		else
			return false;
	}


	/**
 	 * faz o upload do arquivo
 	 * @return boolean, String
 	 */
	public function uploadFoto($nomeArquivo, $arquivo)
	{
		//verifica se o diretório existe
		if(is_dir(BASEPATH.'skin/uploads/produtos/'))
		{
			$destino = BASEPATH.'skin/uploads/produtos/';
			$destino_p = BASEPATH.'skin/uploads/produtos/p/';

			if(!is_dir($destino))
				mkdir($destino);

			if(!is_dir($destino_p))
				mkdir($destino_p);

			$img = new upload($arquivo,$destino, $nomeArquivo);
			
			if($img->getError() == false)
			{
				$dest = $destino.$img->getArquivo();
				$dest_p = $destino_p.$img->getArquivo();
				if(
					(isset($_POST['w']) && $_POST['w'] != '') ||
					(isset($_POST['h']) && $_POST['h'] != '') ||
					(isset($_POST['x1']) && $_POST['x1'] != '') ||
					(isset($_POST['y1']) && $_POST['y1'] != '')
					){
						$w = $_POST['w'] ;
						$h =  $_POST['h'];
						$x1 = $_POST['x1'];
						$y1 = $_POST['y1'];
						
						$crop = new crop_image();
						$crop->setImage($dest,$dest_p,$w, $h,$x1, $y1,404, 158);
						$crop->cropResize();
						$crop->setImage($dest,$dest,$w, $h,$x1, $y1,1349, 527);
						$crop->cropResize();
					}else
					{
						$w = $_POST['w'] ;
						$h =  $_POST['h'];
						$x1 = $_POST['x1'];
						$y1 = $_POST['y1'];

						$crop = new crop_image();
						$crop->setImage($dest,$dest_p,$w, $h,$x1, $y1,404, 158);
						$crop->setImage($dest,$dest,$w, $h,$x1, $y1,1349, 527);
						$crop->resize();
					}

				$this->nomeArquivoFoto = $img->getArquivo();
				return true;
			
			}else
				return $img->getError();
		}else
			return 'Erro ao efetuar o upload. O diretório não existe';


	}


}