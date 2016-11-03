<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
interface IUsuarios{
	public function consultar(db $db, usuariosModel $usuarios, $status);
}