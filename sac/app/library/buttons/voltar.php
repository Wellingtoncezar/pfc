<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class voltar extends loadContent implements ITemplate {
	private $atrDefault;
	public function getContent(Array $atr = null)
	{
		$this->atrDefault = array(
			'title' => 'Voltar',
			'href' => '',
		);

		if(!empty($atr))
		{
			foreach ($atr as $key => $value) {
				if(array_key_exists($key, $this->atrDefault))
					$this->atrDefault[$key] = $value;
			}
		}
		return parent::load('template/actions_buttons/voltar',$this->atrDefault);
	}
}