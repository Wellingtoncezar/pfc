<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
interface IRelatoriosDao{
	public function consultar(db $db, RelatoriosModel $relatorio);
}