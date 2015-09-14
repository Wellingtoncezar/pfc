<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class loginModel extends Model{
	private $error = array();
	private $id;
	private $nome;
	private $sobrenome;
	private $email;
	private $login;
	private $senha;
	private $permissao;
	private $foto;
	private $listaPermissao;
	private $permissao_usuario;
	private $captcha;

	/*GETS*/
	public function getId(){
		return $this->id;
	}
	public function getNome(){
		return $this->nome;
	}
	public function getSobrenome(){
		return $this->sobrenome;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getLogin(){
		return $this->login;
	}
	public function getSenha(){
		return $this->senha;
	}
	
	public function getPermissao(){
		return $this->permissao;
	}

	public function getFoto(){
		return $this->foto;
	}
	public function getPermissoes(){
		return $this->listaPermissao;
	}
	public function getCaptcha(){
		return $this->captcha;
	}


	/*SETS*/
	public function setId($id){
		$this->id = $id;
	}
	public function setNome($nome){
		$this->nome = $nome;
	}
	public function setSobrenome($sobrenome){
		$this->sobrenome = $sobrenome;
	}
	public function setEmail($email){
		$this->email = $email;
	}
	public function setLogin($login){
		$this->login = $login;
	}
	public function setSenha($senha){
		$this->senha = $senha;
	}

	public function setPermissao($permissao){
		$this->permissao = $permissao;
	}

	public function setFoto($foto){
		$this->foto = $foto;
	}
	public function setPermissoes($listaPermissao){
		$this->listaPermissao = $listaPermissao;
	}
	public function setCaptcha($captcha){
		$this->captcha = $captcha;
	}



	public function __construct(){
		parent::__construct();
	}


	
}