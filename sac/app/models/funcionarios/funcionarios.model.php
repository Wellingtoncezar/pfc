<?php
/**
*@author Wellington cezar, Diego Hernandes, Jessica Azevedo
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class funcionarios extends Model{
	private $nome;
	private $sobrenome;
	private $dataNascimento;
	private $sexo;
	private $rg;
	private $cpf;
	private $estadoCivil;
	private $escolaridade;
	private $endereco;
	private $telefone;
	private $email;
	

	public function __construct(){
		parent::__construct();
	}

}