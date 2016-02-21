<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class templateFactory extends Library implements iTemplateFactory {

	public function getButton($button, $atr, $checkPermission = TRUE) 
	{
		// if($this->checkPermissao->acao($button))//verifica a permissão de acesso
		// {
			$this->load->library('buttons/'.$button);
			$template = new $button();
			return $template->getContent($atr);
		// }else
		//  	return null;
	}

	public function getTable($table, $atr)
	{
		$this->load->library('tables/'.$table);
		$template = new $table();
		return $template->getContent($atr);
	}

}