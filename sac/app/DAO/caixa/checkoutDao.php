<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class checkoutDao extends Dao{
	public function __construct(){
		parent::__construct();
	}


	public function checkmachine(checkoutModel $checkoutModel)
	{
		try {

			$this->db->clear();
			$this->db->setTabela('checkout');
			$this->db->setCondicao("ip_maquina = ?");
			$this->db->setParameter(1, $checkoutModel->getIpmaquina());
			if($this->db->select())
			{
				return true;
			}else
				return false;
		} catch (dbException $e) {
			return $e->getMessageError();
		}
	}







}