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
	public function listar($condStatus = array())
	{
		$this->db->clear();
		$this->load->model('produtos/produtosModel');
<<<<<<< HEAD
		$this->load->model('produtos/categoriasModel');
		$this->load->model('produtos/marcasModel');
		$this->load->model('produtos/unidademedidaModel');
=======
		$this->load->model('produtos/unidadeMedidaProdutoModel');
		$this->load->model('produtos/unidadeMedidaModel');
>>>>>>> origin/master
		$produtos = Array();

		if(empty($condStatus))
		{
			$condStatus = array(
				status::ATIVO,
				status::INATIVO
			);
		}
		
		$cond = "";
		$n = 1;
		foreach ($condStatus as $value) {
			$this->db->setParameter($n,$value); //seta os parametros no sql
			if(count($condStatus) == $n)
				$cond .= "?";
			else
				$cond .= "?,";
			$n++;
		}

		$cond = " AND A.status_produto in(".$cond.") ";
		$cond = "A.id_marca = B.id_marca AND A.id_categoria = C.id_categoria ".$cond;

		$this->db->setTabela('produtos as A, marcas as B, categorias as C');
		$this->db->setCondicao($cond);

		$campos = array('A.id_produto','A.foto_produto','A.nome_produto','B.nome_marca','C.nome_categoria','status_produto');
		if($this->db->select($campos)):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$produtosModel = new produtosModel();
				$produtosModel->setId($value['id_produto']);
				$produtosModel->setFoto($value['foto_produto']);
				$produtosModel->setNome($value['nome_produto']);
				$produtosModel->setStatus(status::getAttribute($value['status_produto']));

				$categoriasModel = new categoriasModel();
				$categoriasModel->setNome($value['nome_categoria']);
				$produtosModel->setCategoria($categoriasModel);
				
				$marcasModel = new marcasModel();
				$marcasModel->setNome($value['nome_marca']);
				$produtosModel->setMarca($marcasModel);

				$this->db->clear();
				$this->db->setTabela('unidade_medida as A, unidade_medida_produto AS B');
				$this->db->setCondicao("B.id_produto = ? AND A.id_unidade_medida = B.id_unidade_medida");
				$this->db->setParameter(1, $value['id_produto']);
				if($this->db->select())
				{
					$unidadeMedida = $this->db->resultAll();
					foreach ($unidadeMedida as $unidade)
					{
						$unidadeMedidaModel = new unidadeMedidaModel();
						$unidadeMedidaModel->setId($unidade['id_unidade_medida']);
						$unidadeMedidaProdutoModel = new unidadeMedidaProdutoModel();
						$unidadeMedidaProdutoModel->setId($unidade['id_unidade_medida_produto']);
						$unidadeMedidaProdutoModel->setUnidadeMedida($unidadeMedidaModel);
						$unidadeMedidaProdutoModel->setParaVenda($unidade['para_venda']);
						$unidadeMedidaProdutoModel->setParaEstoque($unidade['para_estoque']);
						$unidadeMedidaProdutoModel->setFator($unidade['fator_unidade_medida']);
						$unidadeMedidaProdutoModel->setOrdem($unidade['ordem']);
						$produtosModel->addUnidadeMedida($unidadeMedidaProdutoModel);
					}
				}

				array_push($produtos, $produtosModel);
				unset($produtosModel);
			}
			return $produtos;
		else:
			return $produtos;
		endif;
	}

	/**
	 * Retorna lista de produtos ativos
	 * @return object [produtosModel]
	 */
	public function listarAtivos()
	{
		$condStatus = array(
			status::ATIVO
		);
		return $this->listar($condStatus);
	}

	/**
	 * Retorna a consulta de um produto pelo id
	 * @return object [produtosModel]
	 */
	public function consultar(produtosModel $produto)
	{
		$this->db->clear();
		$this->db->setTabela('produtos as a, categorias as b , marcas as c');
		$this->db->setCondicao("a.id_produto = ? and b.id_categoria = a.id_categoria and c.id_marca = a.id_marca");
		$this->db->setParameter(1, $produto->getId());

		//PRODUTO
		if($this->db->select()):
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
			
			$produto->setFoto($result['foto_produto']);
			$produto->setNome($result['nome_produto']);
			$produto->setMarca($marcasModel);
			$produto->setCategoria($categoriasModel);
			$produto->setDescricao($result['descricao_produto']);
			$produto->setStatus(status::getAttribute($result['status_produto']));
			$produto->setDataCadastro($result['data_cadastro_produto']);


			$this->db->clear();
			$this->db->setTabela('unidade_medida as A, unidade_medida_produto AS B');
			$this->db->setCondicao("B.id_produto = ? AND A.id_unidade_medida = B.id_unidade_medida");
			$this->db->setParameter(1, $result['id_produto']);
			if($this->db->select())
			{
				$this->load->model('produtos/unidadeMedidaModel');	
				$this->load->model('produtos/unidadeMedidaProdutoModel');	
				
				$unidadeMedida = $this->db->resultAll();
				foreach ($unidadeMedida as $unidade)
				{
					$unidadeMedidaModel = new unidadeMedidaModel();
					$unidadeMedidaModel->setId($unidade['id_unidade_medida']);
					$unidadeMedidaModel->setNome($unidade['nome_unidade_medida']);
					$unidadeMedidaProdutoModel = new unidadeMedidaProdutoModel();
					$unidadeMedidaProdutoModel->setId($unidade['id_unidade_medida_produto']);
					$unidadeMedidaProdutoModel->setUnidadeMedida($unidadeMedidaModel);
					$unidadeMedidaProdutoModel->setParaVenda($unidade['para_venda']);
					$unidadeMedidaProdutoModel->setParaEstoque($unidade['para_estoque']);
					$unidadeMedidaProdutoModel->setFator($unidade['fator_unidade_medida']);
					$unidadeMedidaProdutoModel->setOrdem($unidade['ordem']);
					$produto->addUnidadeMedida($unidadeMedidaProdutoModel);
				}
			}
		endif;
		return $produto;
	}



	/**
	 * Insere novos produtos
	 * @return boolean, json
	 */
 	public function inserir(produtosModel $produto)
 	{
 		$data = array(
 			'foto_produto' => $produto->getFoto(),
 			'nome_produto' => $produto->getNome(),
 			'id_marca' => $produto->getMarca()->getId(),
 			'id_categoria' => $produto->getCategoria()->getId(),
 			'descricao_produto' => $produto->getDescricao(),
 			'preco_venda_produto' => $produto->getPrecoVenda(),
 			'markup_produto' => $produto->getMarkup(),
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
			if(!empty($produto->getUnidadeMedida()))
			 	$this->atualizaUnidadeMedida($produto);
			return true;
 		}else
 		{
 			throw new Exception($this->db->getError(), 1);
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
			 	$this->atualizaUnidadeMedida($produto);

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
 	private function atualizaUnidadeMedida(produtosModel $produto)
	{
		//excluir
		$naoExcluirUnidade = array();
		foreach ($produto->getUnidadeMedida() as $unidade)
		{
			if($unidade->getId() != '')
				array_push($naoExcluirUnidade,$unidade->getFornecedor()->getId());
		}
		$cond = '';
		if(!empty($naoExcluirUnidade))
		{
			$naoExcluirUnidade = implode(',', $naoExcluirUnidade);
			$this->db->clear();
			$cond = " AND id_unidade_medida_produto not in (".$naoExcluirUnidade.")";
		}
		$sql = "DELETE FROM unidade_medida_produto WHERE id_produto = '".$produto->getId()."' $cond";
		$this->db->query($sql);
		if($this->db->rowCount() > 0)

		$this->db->clear();
		$this->db->setTabela('unidade_medida_produto');
		foreach ($produto->getUnidadeMedida() as $unidade)
		{
			if(!empty($unidade))
			{
				$data = array(
					'id_produto' => $produto->getId(),
					'id_unidade_medida' => $unidade->getUnidadeMedida()->getId(),
					'fator_unidade_medida' => $unidade->getFator(),
					'para_venda' => $unidade->getParaVenda(),
					'para_estoque' => $unidade->getparaEstoque(),
					'ordem' => $unidade->getOrdem()
				);

				if($unidade->getId() != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
				{
					$this->db->setCondicao('id_unidade_medida_produto = "'.$unidade->getId().'"');
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