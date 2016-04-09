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
			return $produtos;
		endif;
	}


	/**
	 * Retorna a consulta de um funcionário pelo id
	 * @return object [funcionariosModel]
	 */
	public function consultar(produtosModel $produto)
	{
		$this->db->clear();
		$this->db->setTabela('produtos');
		$this->db->setCondicao("id_produto = '".$produto->getId()."'");
		$this->db->select();

		//PRODUTO
		if($this->db->rowCount() > 0):
			$result = $this->db->result();

			

			$produto->setFoto($result['foto_produto']);
			$produto->setNome($result['nome_produto']);
			//$produto->setMarca($marcasModel);
			//$produto->setCategoria($categoriasModel);
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
	 * Insere novos funcionários
	 * @return boolean, json
	 */
 // 	public function inserir(funcionariosModel $produto)
 // 	{
 		

	// 	if($produto->getFoto() != '')
	// 	{
	//  		//nome da imagem
	// 		$char = new caracteres($produto->getNome());
	// 		$this->nomeArquivoFoto = $char->getValor().'_'.date('HisdmY').'';
			
	// 		$upload = $this->uploadFoto($this->nomeArquivoFoto, $produto->getFoto()); //upload da foto
	// 		if($upload)
	// 			return $this->insertData($produto);
	// 		else
	// 			return $upload;
	// 	}else
	// 	{
	// 		return $this->insertData($produto);
	// 	}

	// }

	/**
	 * Atualiza funcionários
	 * @return boolean, json
	 */
 	public function atualizar(funcionariosModel $produto)
 	{

		if($produto->getFoto() != '')
		{
	 		$this->db->clear();
	 		$this->db->setTabela('funcionarios');
	 		$this->db->setCondicao("id_funcionario = '".$produto->getId()."'");
	 		$this->db->select(array('foto_funcionario'));
	 		$res = $this->db->result();
	 		$this->nomeArquivoFoto = pathinfo($res['foto_funcionario'],PATHINFO_FILENAME);
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


	public function inserir(produtosModel $produto)
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

			return 'cadastrado';
			//return true;
 		}else
 		{
 			return json_encode(array('erro'=>'Erro ao inserir registro'));
 		}
 		
 	}

 	private function updateData(funcionariosModel $produto)
	{

 		$data = array(
 			'foto_funcionario' => $this->nomeArquivoFoto,
 			'nome_funcionario' => $produto->getNome(),
 			'sobrenome_funcionario' => $produto->getSobrenome(),
 			'data_nascimento_funcionario' => $produto->getDataNascimento(),
 			'sexo_funcionario' => $produto->getSexo(),
 			'rg_funcionario' => $produto->getRg(),
 			'cpf_funcionario' => $produto->getCpf(),
 			'estado_civil_funcionario' => $produto->getEstadoCivil(),
 			'escolaridade_funcionario' => $produto->getEscolaridade(),
 			'codigo_funcionario' => $produto->getCodigo(),
 			'cargo_funcionario' => $produto->getCargo(),
 			'data_admissao_funcionario' => $produto->getDataAdmissao(),
 			'salario_funcionario' => $produto->getSalario(),
 			'status_funcionario' => $produto->getStatus(),
 			'data_cadastro_funcionario' => $produto->getDataCadastro()
 		);

 		$this->db->clear();
		$this->db->setTabela('funcionarios');
		$this->db->setCondicao("id_funcionario = '".$produto->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount() > 0)
			$this->nUpdates++;
		
		//ENDEREÇO
		$this->atualizaEndereco($produto);
		//TELEFONES
		$this->atualizaTelefones($produto);
		//EMAILS
		$this->atualizaEmails($produto);

 		if($this->nUpdates > 0)
			return true;
 		else
 		{
 			return json_encode(array('erro'=>'Erro ao editar registro'));
 		}
 	}



 	/**
 	 * 
 	 * Atualiza ou insere os telefones
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
 	 * Atualiza ou insere os emails
 	 * @return void
 	 */
	private function atualizaEmails(funcionariosModel $produto)
	{
		//excluir
		$emailExcluir = array();
		foreach ($produto->getEmail() as $email)
		{
			if($email->getId() != '')
				array_push($emailExcluir,$email->getId());
		}
		$cond = '';
		if(!empty($emailExcluir))
		{
			$emailExcluir = implode(',', $emailExcluir);
			$this->db->clear();
			$cond = " AND id_email not in (".$emailExcluir.")";
		}
		$sql = "DELETE FROM emails WHERE id_funcionario = '".$produto->getId()."' $cond";
		$this->db->query($sql);


		$this->db->clear();
		$this->db->setTabela('emails');
		foreach ($produto->getEmail() as $emails)
		{
			if(!empty($emails))
			{
				$data = array(
					'id_funcionario' => $produto->getId(),
					'tipo_email' => $emails->getTipo(),
					'endereco_email' => $emails->getEmail()
				);

				if($emails->getId() != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
				{
					$this->db->setCondicao('id_email = "'.$emails->getId().'"');
					$this->db->update($data);
				}else
					$this->db->insert($data);

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
			$destino = BASEPATH.'skin/uploads/funcionarios/';
			$destino_p = BASEPATH.'skin/uploads/funcionarios/p/';

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