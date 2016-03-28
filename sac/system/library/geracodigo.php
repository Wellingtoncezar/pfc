<?php
/**
* Classe geradora de codigos aleatórios
* @access 
* @author Wellington cézar
* @since 18/06/2015
* @version 2.0
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class geracodigo 
{
	private $codigo;
	private $tamanho = 8;
	private $comMinusculas = false;
	private $comMaiusculas = false;
	private $comNumeros = true;
	private $comSimbolos = false;
	private $lmin = 'abcdefghijklmnopqrstuvwxyz';
	private $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	private $num = '1234567890';
	private $simb = '!@#$%*-';
	function __construct()
	{
		
	}
	public function setTamanho($tamanho = 8)
	{
		if($tamanho != 0)
			$this->tamanho = $tamanho;
		return $this;
	}

	public function comMinusculas($comMinusculas = false)
	{
		if(is_bool($comMinusculas))
			$this->comMinusculas = $comMinusculas;
		return $this;
	}

	public function comMaiusculas($comMaiusculas = false)
	{
		if(is_bool($comMaiusculas))
			$this->comMaiusculas = $comMaiusculas;
		return $this;
	}

	public function comNumeros($comNumeros = true)
	{
		if(is_bool($comNumeros))
			$this->comNumeros = $comNumeros;
		return $this;
	}

	public function comSimbolos($comSimbolos = false)
	{
		if(is_bool($comSimbolos))
			$this->comSimbolos = $comSimbolos;
		return $this;
	}



	function gerar()
	{
		$this->codigo = '';
		$caracteres = '';

		if ($this->comMinusculas) $caracteres .= $this->lmin;
		if ($this->comMaiusculas) $caracteres .= $this->lmai;
		if ($this->comNumeros) $caracteres .= $this->num;
		if ($this->comSimbolos) $caracteres .= $this->simb;

		$len = strlen($caracteres);
		for ($n = 1; $n <= $this->tamanho; $n++) {
			$rand = mt_rand(1, $len);
			$this->codigo .= $caracteres[$rand-1];
		}
		return $this->codigo;
	}
	public function getCodigo()
	{
		return $this->codigo;
	}

}