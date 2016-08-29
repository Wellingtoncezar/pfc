<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
interface IListagemFuncionarios{
	public function listar(db $db);
}