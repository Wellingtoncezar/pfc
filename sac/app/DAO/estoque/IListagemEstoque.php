<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
interface IListagemEstoque{
	public function listar($db);
	public function getLocalizacao();
}