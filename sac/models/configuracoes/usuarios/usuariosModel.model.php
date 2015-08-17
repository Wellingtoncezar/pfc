<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class usuariosModel extends Controller{
	private $id;
	private $nome;
	private $sobrenome;
	private $email;
	private $login;
	private $senha;
	private $status;
	private $permissao;
	private $foto;
	private $nomeArquivoFoto;

	public function __construct(){
		parent::__construct();
	}

	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setSobrenome($sobrenome){
		$this->sobrenome = $sobrenome;
	}

	public function getSobrenome(){
		return $this->sobrenome;
	}

	public function setEmail($email){
		$this->email = $email;
	}
	public function getEmail()
	{
		return $this->email;
	}

	public function setLogin($login){
		$this->login = $login;
	}

	public function getLogin(){
		return $this->login;
	}

	public function setSenha($senha){
		$this->senha = $senha;
	}

	public function getSenha(){
		return $this->senha;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setPermissao($permissao){
		$this->permissao = $permissao;
	}
	public function getPermissao(){
		return $this->permissao;
	}

	public function setFoto($foto){
		$this->foto = $foto;
	}

	public function getNomeArquivoFoto()
	{
		return $this->nomeArquivoFoto;
	}

	public function loginDisponivel($login)
	{
		$this->clear();
		$this->setTabela('usuarios_adm');
		$this->setCondicao("login_usuario = '".$login."'");
		$this->select();
		if($this->rowCount()>0)
			return false;
		else
			return true;
	}


	public function emailDisponivel($email)
	{
		$this->clear();
		$this->setTabela('usuarios_adm');
		$this->setCondicao("email_usuario = '".$email."'");
		$this->select();
		if($this->rowCount()>0)
			return false;
		else
			return true;
	}
	

	public function inserir()
	{
		$data = array(
			'nome_usuario' => filter_var($this->nome),
			'sobrenome_usuario' => filter_var($this->sobrenome),
			'email_usuario' => filter_var($this->email),
			'login_usuario' => filter_var($this->login),
			'senha_usuario' => filter_var(md5($this->senha)),
			'status_usuario' => filter_var($this->status),
			'permissao_usuario' => filter_var($this->permissao),
			'data_cadastro' => date('Y-m-d H:i:s')
		);
		
		$this->clear();
		$this->setTabela('usuarios_adm');
		$this->insert($data);
		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}


	public function listar($condicao = '<>', $valor = 'Excluído'){
		$this->clear();
		$this->query("SELECT * FROM usuarios_adm AS A LEFT JOIN usuario_adm_grupo_permissao AS B ON A.permissao_usuario = B.id_grupo_permissao WHERE A.status_usuario $condicao '$valor'");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}
		else
			return false;
	}




	/**
	*Insere um novo grupo de permissão de acesso
	*/
	public function inserirGrupoUsuarios(){
		$data = array(
			'nome_permissao' => $this->nome,
			'permissao' => $this->permissao,
			'data_cadastro' => date('Y-m-d H:i:s')
		);
		$this->clear();
		$this->setTabela('usuario_adm_grupo_permissao');
		$this->insert($data);
		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}

	/**
	*Atualiza um grupo de permissão de acesso
	*/
	public function atualizarGrupoUsuarios(){
		$data = array(
			'nome_permissao' => $this->nome,
			'permissao' => $this->permissao
			
		);
		$this->clear();
		$this->setTabela('usuario_adm_grupo_permissao');
		$this->setCondicao('id_grupo_permissao = "'.$this->id.'"');
		$this->update($data);
		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}

	


	/**
	*retorna a listagem das permissões cadastradas
	*/
	public function listaGruposUsuarios(){
		$this->clear();
		$this->setTabela('usuario_adm_grupo_permissao');
		$this->select();
		if($this->rowCount() > 0){
			return $this->resultAll();
		}
		else
			return false;
	}

	/**
	*Exclui permanentemente o gupo de usuário
	*/
	public function excluirGrupoUsuario($id)
	{
		
		$this->clear();
		$this->setTabela('usuario_adm_grupo_permissao');
		$this->setCondicao('id_grupo_permissao = "'.$id.'"');
		$this->delete();
		if($this->rowCount() > 0){
			return true;
		}
		else
			return false;
	}

	public function getGrupoUsuario($id){
		$this->clear();
		$this->setTabela('usuario_adm_grupo_permissao');
		$this->setCondicao('id_grupo_permissao = "'.$id.'"');
		$this->select();
		if($this->rowCount() > 0){
			return $this->result();
		}
		else
			return false;
	}



	public function atualizarStatus()
	{
		$data = array(
			'status_usuario' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('usuarios_adm');
		$this->setCondicao('id_usuario = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}

	public function atualizaFoto()
	{
		$data = array(
			'foto_usuario' =>  $this->nomeArquivoFoto
		);
		$this->clear();
		$this->setTabela('usuarios_adm');
		$this->setCondicao('id_usuario = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0){
			$fotoP = BASEPATH.'uploads/usuarios/p/'.$_SESSION['login_adm']['foto'];
			$fotoG = BASEPATH.'uploads/usuarios/'.$_SESSION['login_adm']['foto'];
/*			if(file_exists($fotoP))
				unlink($fotoP)
			if(file_exists($fotoG))
				unlink($fotoG))
*/
			
			$_SESSION['login_adm']['foto'] = $this->nomeArquivoFoto;
			return true;
		}
		else
			return false;
	}



	public function uploadFoto($nomeArquivo)
	{
		if(is_dir(BASEPATH.'uploads/usuarios/'))
		{
			$arquivo = $this->foto;
			$destino = BASEPATH.'uploads/usuarios/';
			$destino_p = BASEPATH.'uploads/usuarios/p/';

			if(!is_dir($destino))
				mkdir($destino);

			if(!is_dir($destino_p))
				mkdir($destino_p);

			$img= new upload($arquivo,$destino, $nomeArquivo);
			if($img->getError() == false)
			{
				$dest = $destino.$img->getArquivo();
				$dest_p = $destino_p.$img->getArquivo();
				if(
					(isset($_POST['w']) && $_POST['w'] != '') ||
					(isset($_POST['h']) && $_POST['h'] != '') ||
					(isset($_POST['x1']) && $_POST['x1'] != '') ||
					(isset($_POST['y1']) && $_POST['y1'] != '')
					){
						$w = $_POST['w'] ;
						$h =  $_POST['h'];
						$x1 = $_POST['x1'];
						$y1 = $_POST['y1'];
						
						$crop = new crop_image();
						$crop->setImage($dest,$dest_p,$w, $h,$x1, $y1,404, 158);
						$crop->cropResize();
						$crop->setImage($dest,$dest,$w, $h,$x1, $y1,1349, 527);
						$crop->cropResize();
					}else
					{
						$w = $_POST['w'] ;
						$h =  $_POST['h'];
						$x1 = $_POST['x1'];
						$y1 = $_POST['y1'];

						$crop = new crop_image();
						$crop->setImage($dest,$dest_p,$w, $h,$x1, $y1,404, 158);
						$crop->setImage($dest,$dest,$w, $h,$x1, $y1,1349, 527);
						$crop->resize();
					}

				$this->nomeArquivoFoto = $img->getArquivo();
				return true;
			
			}else
				return $img->getError();
		}else
			return 'Erro ao efetuar o upload. O diretório não existe';
	}


	public function excluirUsuario()
	{
		$this->clear();
		$this->setTabela('usuarios_adm');
		$this->setCondicao('id_usuario = "'.$this->id.'"');
		$this->delete();

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}
}


/**
*
*class: usuariosModel
*
*location : models/configuracoes/usuarios/usuariosModel.model.php
*/