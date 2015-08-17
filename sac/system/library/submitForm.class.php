<?php

class SubmitForm{
	private $campos;
	private $error;

	public function __construct($campos)
	{
		$this->campos = $campos;
		foreach ($this->campos as $key => $value) {
			$rules = explode('|',$value[2]);
			foreach ($rules as $regra)
			{
				if($this->$regra($value[0], $value[1]))
				{
					$this->error = TRUE;
				}else
				{
					$config = array('campo'=>$key,'descricao'=>$this->error);
					$this->error = json_encode($config);
				}
			}
		}
	}
	
	public function getValidate()
	{
		return $this->error;
	}
	
	
	private function required($value,$label)
	{
		if(trim($value) != NULL && trim($value) != '' && trim($value) != 0)
			return true;
		else
			$this->error = 'O campo '.$label.' está vazio';
	}
	private function trim()
	{
		return true;
	}
}