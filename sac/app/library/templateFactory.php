<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class templateFactory extends Library implements iTemplateFactory {

	public function getButton($button, $atr, $checkPermission = '') 
	{
		// echo '<pre>';
		// echo $checkPermission.'<br>';
		// var_dump($this->checkPermissao->checkPermissaoPagina(false, $checkPermission));
		// echo '</pre>';
		if($checkPermission != '' && $this->load->checkPermissao->check(false, $checkPermission) == false )//verifica a permissão de acesso
			return null;

		$this->load->library('buttons/'.$button);
		$template = new $button();
		return $template->getContent($atr);
	}

	public function getTable($table, $atr)
	{
		$this->load->library('tables/'.$table);
		$template = new $table();
		return $template->getContent($atr);
	}

}