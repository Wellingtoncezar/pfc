<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class localizacoes{
	const ARMAZEM = 'ARMAZEM';
	const PRATELEIRA = 'PRATELEIRA';
	const DESCARTADOS = 'DESCARTADOS';

	public static function getAttribute($attr)
	{
		if(isset($attr))
			return $attr;
		else
			return null;
	}
}