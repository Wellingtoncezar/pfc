<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class loginModel extends Load{
	private $error = array();
	public function __construct(){
		parent::__construct();
	}


	/**
	*Logar
	*@return boolean | string
	* Validação do login e captcha
	*/
	public function logar($login,$senha,$captcha)
	{
		if($this->validForm($login,$senha) == TRUE)
		{
			if($_SESSION['ntentativaLogin'] >=5)
			{
			    if (empty($_SESSION['captcha']) || trim(strtolower($captcha)) != $_SESSION['captcha']) 
			    {
			    	$this->error = array(
						'error'=>'Código incorreto',
						'captcha' => TRUE
					);
					return json_encode($this->error);
			    }else
			    {
			    	return $this->validLogin($login, $senha);
			    }
			}else
				return $this->validLogin($login,$senha);
		}else
			return json_encode($this->error);
		
	}


	/**
	*validLogin
	*@return boolean | string
	* Validação do login e senha
	*/
	private function validLogin($login, $senha){
		$senha = md5($senha);
		$this->clear();
		$this->setTabela('usuarios_adm');
		$this->setCondicao('login_usuario = "'.$login.'" and senha_usuario = "'.$senha.'" AND status_usuario = "Ativo"');
		$this->select();
		$res = $this->result();

		if($res != FALSE)
		{
			unset($_SESSION['ntentativaLogin']);
			$_SESSION['login_adm']['id'] = $res['id_usuario'];
			$_SESSION['login_adm']['nome'] = $res['nome_usuario'];
			$_SESSION['login_adm']['sobrenome'] = $res['sobrenome_usuario'];
			$_SESSION['login_adm']['email'] = $res['email_usuario'];
			$_SESSION['login_adm']['login'] = $res['login_usuario'];
			$_SESSION['login_adm']['permissao'] = $res['permissao_usuario'];
			$_SESSION['login_adm']['foto'] = $res['foto_usuario'];
			$_SESSION['login_adm']['listaPermissao'] = '';
			
			if($res['permissao_usuario'] != 'Administrador')
			{
				$this->clear();
				$this->setTabela('usuario_adm_grupo_permissao');
				$this->setCondicao("id_grupo_permissao = '".$res['permissao_usuario']."'");
				$this->select();
				if($this->rowCount() > 0)
				{
					$resPerm = $this->result();
					$_SESSION['login_adm']['listaPermissao'] = $resPerm['permissao'];
					$_SESSION['login_adm']['permissao'] = $resPerm['nome_permissao'];
				}
			}



			$this->clear();
			$this->setTabela('usuario_adm_acesso');
			$this->setCondicao("id_usuario = '".$res['id_usuario']."' order by id_acesso desc limit 1");
			$this->select();
			$res = $this->result();
			if($res != FALSE){
				$data = explode('-',$res['data_acesso']);
				$_SESSION['login_adm']['acesso'] = '<strong>Último acesso:</strong> '.$data[2].'/'.$data[1].'/'.$data[0].' '.$res['hora_acesso'];
			}else
			{
				$_SESSION['login_adm']['acesso'] = '<strong>Primeiro acesso ao gerenciador</strong>';
			}
			
			$this->clear();
			$this->setTabela('usuario_adm_acesso');
			$data = array(
				'id_usuario' => $_SESSION['login_adm']['id'],
				'data_acesso' => date('Y-m-d'),
				'hora_acesso' => date('H:i:s'),
				'ip_acesso' => $this->getIp()
			);



			$this->insert($data);
			if($this->rowCount()>0)
			{
				//cria o token de segurança para verificação do login
				$hash = Bcrypt::hash(date('YmdHis'));	
				$dataValue = array(
					'token' => $hash
				);
				$this->clear();
				$this->setTabela('usuarios_adm');
				$this->setCondicao('id_usuario = "'.$res['id_usuario'].'"');
				$this->update($dataValue);
				if($this->rowCount() > 0){
					$_SESSION['login_adm']['token'] = $hash;
					return TRUE;
				}
				else
					return FALSE;
			}
			else
				return FALSE;
		}else
		{
			$_SESSION['ntentativaLogin']++;
			$this->error = array(
				'error'=>'Login incorreto',
				'captcha' => FALSE
			);
			return json_encode($this->error);
		}
	}


	/**
	*validForm
	*@return boolean | string
	* Validação dos campos formulário
	*/
	private function validForm($login, $senha)
	{
		$valid = new validate();
		if(!$valid->string($login))
		{
			$this->error['campo'] = 'login';
			$this->error['error'] = 'Informe o seu login de acesso';
			return FALSE;
		}else
		if(!$valid->string($senha))
		{
			$this->error['campo'] = 'senha';
			$this->error['error'] = 'Informe a senha';
			return FALSE;
		}else
			return TRUE;
	}

	/**
	*Retorna o ip do usuário
	*/
	function getIp()
	{
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))
	    {
	        return $_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	    {
	        return $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else{
	        return $_SERVER['REMOTE_ADDR'];
	    }
	}


	/**
	*Verifica se o usuário está logado corretamente, através da sessão e de um token gravado no banco que deve corresponder ao gravado na sessão
	*/
	public function statusLogin()
	{
		if(isset($_SESSION['login_adm']['token']))
		{
			$login = $_SESSION['login_adm']['login'];
			$token = $_SESSION['login_adm']['token'];
			$this->clear();
			$this->setTabela('usuarios_adm');
			$this->setCondicao("login_usuario = '".$login."' and token = '".$token."'");
			$this->select();
			$res = $this->result();
			if($this->rowCount() > 0)
			{
				unset($login);
				unset($token);
				return true;
			}else{
				//echo '<p>'.$token.'</p>';
				//echo '<p>'.$res['token'].'</p>';
				return header('Location: '.URL.'login');
			}
		}else
			return header('Location: '.URL.'login');
	}
}