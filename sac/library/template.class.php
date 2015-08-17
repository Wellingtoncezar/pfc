<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso não permitido');
class template extends Controller{
	private $_modulos = array();
	private $_menu = '';
	private $checkPermissao;
	public function __construct()
	{
		$this->checkPermissao = new checkPermissao();//validação das permissões de acesso
	}


	/**
	*Retorna o conteudo do arquivo substituindo pelos valores
	*/
	function getContent($contentFile, $data)
	{
		$contentFile = BASEPATH.DIRECTORY_SEPARATOR.VIEWS.DIRECTORY_SEPARATOR.$contentFile.'.phtml';
		$dadosSite = file_get_contents($contentFile);
		$dadosSite = str_replace('{{URL}}', URL, $dadosSite);
		foreach ($data as $key => $value) {
			$dadosSite = str_replace('{{'.$key.'}}', $value, $dadosSite);
		}
		return $dadosSite;
	}

	/**
	*retorna a header da página central
	*/
	public function page_header($title, $moreContent = null)
	{
		$data = array(
			'title' => $title,
			'moreContent' => $moreContent
		);
		return $this->getContent('template/page_header/page_header',$data);
	}


	/**
	*Retorn a div para inserir os botões da header da página central
	*/
	public function actions_buttons($botoes)
	{
		$data = array(
			'botoes' => $botoes
		);
		return $this->getContent('template/actions_buttons/actions_buttons',$data);
	}


	/**
	*Retorna o botão de adicionar
	*/
	public function btnAdicionarRegistro($href,$title = 'Adicionar',$moreContent = '')
	{
		if($this->checkPermissao->acao('cadastrar'))//verifica a permissão do botão
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			//$data = array();
			return $this->getContent('template/actions_buttons/btnAdicionarRegistro',$data);
		}else
			return '';
	}

	/**
	*Retorna o botão de Excluir
	*/
	public function btnExcluirRegistro($href, $id, $title='Excluir', $moreContent = '')
	{
		if($this->checkPermissao->acao('excluir'))
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'id' => $id,
				'moreContent' => $moreContent
			);
			return $this->getContent('template/actions_buttons/btnExcluirRegistro',$data);
		}else
			return '';
	}

	/**
	*Retorna o botão de editar
	*/
	public function btnEditarRegistro($href, $title = 'Editar', $moreContent = '')
	{
		if($this->checkPermissao->acao('editar'))
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			return $this->getContent('template/actions_buttons/btnEditarRegistro',$data);
		}else
			return '';
	}

	/**
	*Retorna o botão de visualizar
	*/
	public function btnVisualizarRegistro($href, $title = 'Visualizar', $moreContent = '')
	{
		if($this->checkPermissao->acao('visualizar'))
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			return $this->getContent('template/actions_buttons/btnVisualizarRegistro',$data);
		}else
			return '';
	}


	/**
	*Retorna o botão de imagem
	*/
	public function btnImagensRegistro($href, $title = 'Imagens', $moreContent = '')
	{
		if($this->checkPermissao->acao('imagens'))
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			return $this->getContent('template/actions_buttons/btnImagensRegistro',$data);
		}else
			return '';
	}


	/**
	*Retorna o botão de restaurar
	*/
	public function btnRestaurarRegistro($href, $id, $title='Restaurar', $moreContent = '')
	{
		if($this->checkPermissao->acao('restaurar'))
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'id' => $id,
				'moreContent' => $moreContent
			);
			return $this->getContent('template/actions_buttons/btnRestaurarRegistro',$data);
		}else
			return '';
	}



	/**
	*Retorna o botão de alunos
	*/
	public function btnAlunos($href,$title = 'Alunos',$moreContent = '')
	{
		if($this->checkPermissao->acao('alunos'))//verifica a permissão do botão
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			//$data = array();
			return $this->getContent('template/actions_buttons/btnAlunos',$data);
		}else
			return '';
	}

	/**
	*Retorna o botão dos professores
	*/
	public function btnProfessores($href,$title = 'Professores',$moreContent = '')
	{
		if($this->checkPermissao->acao('professores'))//verifica a permissão do botão
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			//$data = array();
			return $this->getContent('template/actions_buttons/btnProfessores',$data);
		}else
			return '';
	}

	/**
	*Retorna o botão das chamadas da EBD
	*/
	public function btnChamadas($href,$title = 'Alunos',$moreContent = '')
	{
		if($this->checkPermissao->acao('chamadas'))//verifica a permissão do botão
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			//$data = array();
			return $this->getContent('template/actions_buttons/btnChamadas',$data);
		}else
			return '';
	}

	
	/**
	*Retorna o botão de adicionar alunos na EBD
	*/
	public function btnAdicionarAlunos($href,$title = 'Adicionar Alunos',$moreContent = '')
	{
		if($this->checkPermissao->acao('cadastrarAlunos'))//verifica a permissão do botão
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			//$data = array();
			return $this->getContent('template/actions_buttons/btnAdicionarAlunos',$data);
		}else
			return '';
	}


	/**
	*Retorna o botão default - para qualquer ação
	*/
	public function btnDefault($check,$href,$title = 'Adicionar Alunos',$moreContent = '')
	{
		if($this->checkPermissao->acao($check))//verifica a permissão do botão
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			//$data = array();
			return $this->getContent('template/actions_buttons/btnDefault',$data);
		}else
			return '';
	}


	/**
	*Retorna o botão de editar
	*/
	public function btnVoltar($href)
	{
		$data = array(
			'href' => $href,
		);
		return $this->getContent('template/actions_buttons/btnVoltar',$data);
	}




	/**
	*Retorna uma tabela
	*/
	public function tabela($thead, $tfoot, $tbody, $moreContent = '')
	{
		$data = array(
			'thead' => $thead,
			'tfoot' => $tfoot,
			'tbody' => $tbody,
			'moreContent' => $moreContent
		);
		return $this->getContent('template/tabela/tabela',$data);
	}

	/**
	*Retorna uma tabela simples
	*/
	public function simplesTabela($thead, $tfoot, $tbody, $moreContent = '')
	{
		$data = array(
			'thead' => $thead,
			'tfoot' => $tfoot,
			'tbody' => $tbody,
			'moreContent' => $moreContent
		);
		return $this->getContent('template/tabela/simpleTabela',$data);
	}


	/**
	*Retorna checkbox para status (Ativo/Inativo)
	*/
	public function checkboxStatus($id,$name,$checked =false, $moreContent = '')
	{
		if($checked == true)
			$checked = 'checked';
		else
			$checked = '';
		$data = array(
			'id' => $id,
			'name' => $name,
			'checked' => $checked,
			'moreContent' => $moreContent
		);
		return $this->getContent('template/status/checkboxStatus',$data);
	}


	
	/**
	*Retorna o botão de conversão para xls
	*/
	public function btnConvetToXls($href)
	{
		$data = array(
			'href' => $href,
		);
		return $this->getContent('template/actions_buttons/btnConvetToXls',$data);
	}


	/**
	*Retorna o botão de conversão para xls
	*/
	public function btnConvetToPdf($href)
	{
		$data = array(
			'href' => $href,
		);
		return $this->getContent('template/actions_buttons/btnConvetToPdf',$data);
	}
}


/**
*
*class: template
*
*location : library/template.php
*/