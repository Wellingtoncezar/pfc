<?php

class error_db{
	private $msg_error;
	public function getMensagemErro($code, $tipo, $val)
	{
		switch ($code){
			case '23000':
				$this->msg_error = 'Não é possível '.$tipo.' o registro '.$val.', pois ele já existe.';
				break;
			case '1451':
				$this->msg_error = 'Não é possível '.$tipo. ' o registro '.$val.'. Existem registros relacionados à ele.';
				break;
		}
		return $this->msg_error;


	}

}