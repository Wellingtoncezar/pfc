<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class tipopermissao{
	const ADMINISTRADOR = 'ADMINISTRADOR';
	const USUARIO = 'USUARIO';
	public static function getAttribute($attr)
	{
		if(isset($attr))
			return $attr;
		else
			return null;
	}
}