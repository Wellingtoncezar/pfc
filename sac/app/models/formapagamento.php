<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class formapagamento{
	const DINHEIRO = 'DINHEIRO';
	const CARTAODEBITO = 'CARTAODEBITO';
	const CARTAOCREDITO = 'CARTAOCREDITO';

	public static function getAttribute($attr)
	{
		if(isset($attr))
			return $attr;
		else
			return null;
	}
}