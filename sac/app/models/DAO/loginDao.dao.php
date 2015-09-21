<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class loginDao extends Model{
	public function __construct(){
		parent::__construct();
	}


	/**
	*Logar
	*@return boolean | string
	* Validação do login e captcha
	*/
	public function logar($loginModel)
	{
		//validação do formulario
		if($this->validForm($loginModel) == TRUE)
		{
			//número de tentativas de login errado
			if($_SESSION['ntentativaLogin'] >=5)
			{
			    if (empty($_SESSION['captcha']) || trim(strtolower($loginModel->getCaptcha())) != $_SESSION['captcha']) 
			    {
			    	$this->error = array(
						'error'=>'Código incorreto',
						'captcha' => TRUE
					);
					return json_encode($this->error);
			    }else
			    {
			    	return $this->validLogin($loginModel);
			    }
			}else
				return $this->validLogin($loginModel);
		}else
			return json_encode($this->error);
	}


	/**
	*validLogin
	*@return boolean | string
	* Validação do login e senha
	*/
	private function validLogin($loginModel){
		$login = filter_var($loginModel->getLogin());
		$senha = filter_var($loginModel->getSenha());

		$senha = Bcrypt::hash($senha);

		$this->clear();
		$this->setTabela('sys_usuarios');
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
				$this->setTabela('sys_usuarios');
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
				'error'=>'Login e/ou senha incorreto',
				'captcha' => TRUE
			);
			return json_encode($this->error);
		}
	}


	/**
	*validForm
	*@return boolean | string
	* Validação dos campos formulário
	*/
	private function validForm($loginModel)
	{
		$valid = new validate();
		if(!$valid->string($loginModel->getLogin()))
		{
			$this->error['campo'] = 'login';
			$this->error['error'] = 'Informe o seu login de acesso';
			return FALSE;
		}else
		if(!$valid->string($loginModel->getSenha()))
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
			$this->setTabela('sys_usuarios');
			$this->setCondicao("login_usuario = '".$login."' and hash_acesso = '".$token."'");
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