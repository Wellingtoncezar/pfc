<?php
/**
* Classe que converte os caracteres de um texto que não são aceitos em uma url
* @access 
* @author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
* @since 18/06/2014
* @version 1.0
*
*/
class caracteres 
{
	private $valor;
	function __construct($val)
	{
		$this->valor = $this->toAscii($val);
	}

	function getValor()
	{
		return $this->valor;
	}

	private function toAscii($str, $replace=array(), $delimiter='-') {
		setlocale(LC_ALL, 'pt_BR.utf-8');
	    if( !empty($replace) ) {
	        $str = str_replace((array)$replace, ' ', $str);
	    }
	 
	    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	    $clean = strtolower(trim($clean, '-'));
	    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	 
	    return $clean;
	}
}