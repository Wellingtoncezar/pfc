<?php
/**
*@author wellington cezar e diego Hernandes
*/
if(!defined('URL')) die('Acesso negado');
class loginDao extends Dao{
	private $error = array();
	public function __construct(){
		parent::__construct();
	}

	
	


	/**
	*validLogin
	*@return boolean | string
	* Validação do login e senha
	*/
	public function validLogin(usuariosModel $usuariosModel){
		$this->db->clear();
		$this->db->setTabela('sys_usuarios as A, funcionarios as B, nivel_acesso AS C');
		$this->db->setCondicao('A.login_usuario = "'.$usuariosModel->getLogin().'" AND A.status_usuario = "'.status::ATIVO.'"  AND B.status_funcionario = "'.status::ATIVO.'" AND A.id_nivel_acesso = C.id_nivel_acesso AND A.id_funcionario = B.id_funcionario');
		

		if($this->db->select())
		{
			$res = $this->db->result();
			if(Bcrypt::check($usuariosModel->getSenha(),$res['senha_usuario']))
			{
				$this->load->model('funcionarios/funcionariosModel');
				$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');

				//funcionario
				$funcionarios = new funcionariosModel();
				$funcionarios->setId($res['id_funcionario']);
				$funcionarios->setNome($res['nome_funcionario']);
				$funcionarios->setSobrenome($res['sobrenome_funcionario']);
				$funcionarios->setFoto($res['foto_funcionario']);

				//nivel de acesso
				$nivelAcesso = new niveisAcessoModel();
				$nivelAcesso->setId($res['id_nivel_acesso']);

				// $nivelAcesso->setPermissoes($res['permissoes']);
				$nivelAcesso->setIndice($res['index_access_db_name']);


				$usuariosModel->setId($res['id_usuario']);
				$usuariosModel->setEmail($res['email_usuario']);
				$usuariosModel->setId($res['id_usuario']);
				$usuariosModel->setFuncionario($funcionarios);
				$usuariosModel->setNivelAcesso($nivelAcesso);
				$usuariosModel->setHash($this->updateHashAcesso($usuariosModel));
				return $usuariosModel;
			}else{
				return null;
			}
		}else
		{
			return null;
		}
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


	public function updateHashAcesso(usuariosModel $usuariosModel)
	{
		$this->db->clear();
		$this->db->setTabela('sys_usuarios_acessos');
		$data = array(
			'id_usuario' => $usuariosModel->getId(),
			'data_acesso' => date('Y-m-d'),
			'hora_acesso' => date('H:i:s'),
			'ip_acesso' => $this->getIp()
		);
		$this->db->insert($data);

		//cria o token de segurança para verificação do login
		$hash = Bcrypt::hash(date('YmdHis'));	
		$dataValue = array(
			'hash_acesso' => $hash
		);
		$this->db->clear();
		$this->db->setTabela('sys_usuarios');
		$this->db->setCondicao('id_usuario = ? ');
		$this->db->setParameter(1, $usuariosModel->getId());

		if($this->db->update($dataValue))
			return $hash;
		else
			return null;	
	}

	/**
	*Verifica se o usuário está logado corretamente, através da sessão e de um token gravado no banco que deve corresponder ao gravado na sessão
	*/
	public function statusLogin()
	{
		if(isset($_SESSION['user']['token']))
		{
			$login = $_SESSION['user']['login'];
			$token = $_SESSION['user']['token'];
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