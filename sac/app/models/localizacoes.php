<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class localizacoes{
	const RESERVADO = 'RESERVADO';
	const SEPARADO = 'SEPARADO';
	const DISPONIVEL = 'DISPONIVEL';
	const PERDIDO = 'PERDIDO';

	public static function getAttribute($attr)
	{
		if(isset($attr))
			return $attr;
		else
			return null;
	}
}