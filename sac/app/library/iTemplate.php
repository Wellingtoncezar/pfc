<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
interface iTemplate{
	public function getContent(loadContent $load, Array $atr);
}