<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
interface iTemplateFactory{
	public function getButton($button, $atr, $checkPermission);
	public function getTable($table, $atr);
}