<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class template extends Library{
	private $_modulos = array();
	private $_menu = '';
	private $checkPermissao;
	public function __construct()
	{
		//$this->checkPermissao = new checkPermissao();//validação das permissões de acesso
	}


	/**
	*Retorna o conteudo do arquivo substituindo pelos valores
	*/
	function getContent($contentFile, $data)
	{
		$contentFile = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.VIEWS.DIRECTORY_SEPARATOR.$contentFile.'.phtml';
		$dadosSite = file_get_contents($contentFile);
		$dadosSite = str_replace('{{URL}}', URL, $dadosSite);
		foreach ($data as $key => $value) {
			$dadosSite = str_replace('{{'.$key.'}}', $value, $dadosSite);
		}
		return $dadosSite;
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
	public function btnCadastrar($href,$title = 'Cadastrar',$moreContent = '')
	{
		// if($this->checkPermissao->acao('cadastrar'))//verifica a permissão do botão
		// {

			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			//$data = array();
			return $this->getContent('template/actions_buttons/btnCadastrar',$data);
		// }else
		// 	return '';
	}

	/**
	*Retorna o botão de Excluir
	*/
	public function btnExcluir($href, $id, $value, $title='Excluir', $moreContent = '')
	{
		// if($this->checkPermissao->acao('excluir'))
		// {
			$data = array(
				'title' => $title,
				'href' => $href,
				'id' => $id,
				'value' => $value,
				'moreContent' => $moreContent
			);
			return $this->getContent('template/actions_buttons/btnExcluir',$data);
		// }else
		// 	return '';
	}

	/**
	*Retorna o botão de editar
	*/
	public function btnEditar($href, $title = 'Editar', $moreContent = '')
	{
		//if($this->checkPermissao->acao('editar'))
		//{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			return $this->getContent('template/actions_buttons/btnEditar',$data);
		// }else
		// 	return '';
	}

	/**
	*Retorna o botão de visualizar
	*/
	public function btnVisualizar($href, $title = 'Visualizar', $moreContent = '')
	{
		if($this->checkPermissao->acao('visualizar'))
		{
			$data = array(
				'title' => $title,
				'href' => $href,
				'moreContent' => $moreContent
			);
			return $this->getContent('template/actions_buttons/btnVisualizar',$data);
		}else
			return '';
	}


	
	/**
	*Retorna o botão default - para qualquer ação
	*/
	public function btnDefault($check,$href,$title = 'ação',$moreContent = '')
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