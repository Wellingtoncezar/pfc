<?php
/**
* @author Wellington cézar
* @version 2.1
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
interface IDbCrud
{
	public function getQuery();
	public function getParamArray();
}