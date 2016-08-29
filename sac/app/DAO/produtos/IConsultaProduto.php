<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
interface IConsultaProduto{
	public function consultar(db $db, produtosModel $produto, $status);
}