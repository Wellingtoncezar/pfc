<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
interface IConsultaCaixa{
	public function consultar(db $db, caixasModel $caixa);

}