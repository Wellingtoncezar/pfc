<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class loadContent{

	public function load($contentFile, $data)
	{
		$contentFile = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.VIEWS.DIRECTORY_SEPARATOR.$contentFile.'.phtml';
		$dadosSite = file_get_contents($contentFile);
		$dadosSite = str_replace('{{URL}}', URL, $dadosSite);
		foreach ($data as $key => $value) {
			$dadosSite = str_replace('{{'.$key.'}}', $value, $dadosSite);
		}
		return $dadosSite;
	}
}