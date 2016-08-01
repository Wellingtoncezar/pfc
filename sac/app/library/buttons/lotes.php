<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class lotes implements ITemplate {
	private $atrDefault;
	public function getContent(loadContent $load, Array $atr = null)
	{
		$this->atrDefault = array(
			'title' => 'Lotes',
			'href' => '',
			'moreContent' => ''
		);

		if(!empty($atr))
		{
			foreach ($atr as $key => $value) {
				if(array_key_exists($key, $this->atrDefault))
					$this->atrDefault[$key] = $value;
			}
		}
		return $load->load('template/actions_buttons/lotes',$this->atrDefault);
	}
}