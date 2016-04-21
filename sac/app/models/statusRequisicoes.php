<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class statusRequisicoes{
	const NOVO = 'NOVO';
	const PENDENTE = 'PENDENTE';
	const PROCESSANDO = 'PROCESSANDO';
	const APROVADO = 'APROVADO';
	const REPROVADO = 'REPROVADO';
	const CANCELADO = 'CANCELADO';

	public static function getAttribute($attr)
	{
		if(isset($attr))
			return $attr;
		else
			return null;
	}
}