<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class status{
	const ATIVO = 'ATIVO';
	const INATIVO = 'INATIVO';
	const EXCLUIDO = 'EXCLUIDO';

	public static function getAttribute($attr)
	{
		if(isset($attr))
			return $attr;
		else
			return null;
	}
}