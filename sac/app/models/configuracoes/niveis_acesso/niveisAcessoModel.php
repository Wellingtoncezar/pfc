<?php
/**
 * Entidade de manipulação da tabela nivel_acesso
*@author Wellington cezar - wellington-cezar@hotmail.com
* @table = nivel_acesso
*/
if(!defined('URL')) die('Acesso negado');
class niveisAcessoModel{
	/**
	 * @id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer", name="id_nivel_acesso")
     * @var int
     */
	private $id;
	/**
	 * @nome
     * @Column(type="string", name="nome_nivel_acesso")
     * @var string
     */
	private $nome;
	/**
	 * @tipopermissao
     * @Column(type="enum(ADMINISTRADOR, USUARIO)", name="tipo_permissao")
     * @var enum(ADMINISTRADOR, USUARIO)
     */
	private $tipopermissao = tipopermissao::USUARIO;
	/**
	 * @permissoes
     * @OneToMany(targetEntity="modulosModel")
     * @var modulosModel[]
     **/
	private $permissoes = array();
	/**
	 * @indice
     * @Column(type="string", name="index_access_db_name")
     * @var string
     **/
	private $indice;

	//SET
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setPermissoes($permissoes)
	{
		$this->permissoes = $permissoes;
	}

	public function addPermissoes(modulosModel $permissoes)
	{
		array_push($this->permissoes, $permissoes);
	}

	public function setIndice($indice)
	{
		$this->indice = $indice;
	}


	public function setTipoPermissaoAdministrador()
	{
		$this->tipopermissao = tipopermissao::ADMINISTRADOR;
	}

	public function setTipoPermissaoUsuario()
	{
		$this->tipopermissao = tipopermissao::USUARIO;
	}


	//GET
	public function getId()
	{
		return $this->id;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function getPermissoes()
	{
		return $this->permissoes;
	}
	public function getIndice()
	{
		return $this->indice;
	}

	public function getTipoPermissao()
	{
		return $this->tipopermissao;
	}
}
