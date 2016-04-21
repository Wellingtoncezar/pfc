<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class statusPedidos{
	const FINALIZADO = 'FINALIZADO';
	const PENDENTE = 'PENDENTE';
	const CANCELADO = 'CANCELADO';

	public static function getAttribute($attr)
	{
		if(isset($attr))
			return $attr;
		else
			return null;
	}
}