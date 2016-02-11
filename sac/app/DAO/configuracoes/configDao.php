<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
* Classe de configuração relacionado aos dados do site
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class configDao extends Dao{
	private $config;
	private $campos = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuracoes/configModel');

		$this->config = new configModel();
	}

	public function getTitulo()
	{
		array_push($this->campos, 'titulo_site');
		return $this;
	}

	public function getFavicon()
	{
		array_push($this->campos, 'favicon_site');
		return $this;
	}

	public function getStatus()
	{
		array_push($this->campos, 'status_site');
		return $this;
	}

	public function getConfig()
	{
		$this->db->clear();
		$this->db->setTabela('configuracoes_site');
		$this->db->select($this->campos);
		if( $this->db->rowCount() > 0 )
		{
			$res = $this->db->result();

			if(in_array('titulo_site',$this->campos))
				$this->config->setTitulo($res['titulo_site']);

			if(in_array('favicon_site',$this->campos))
				$this->config->setFavicon($res['favicon_site']);

			if(in_array('status_site',$this->campos))
				$this->config->setStatus($res['status_site']);
			
			return $this->config;
		}else
		{
			return $this->db->getError();
		}
	}

}