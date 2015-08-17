<?php
    /*
    * 
    * @access restrito
    * @since 20/11/2013
    * @version 2.0
    * @author Fellipe Augusto
    * 
    */
class limitar
{
	private $string;
	function __construct($string, $tamanho,  $tipo = 'letra',$cont=' [...]' ,$encode='UTF-8')
	{
		if($tipo == 'palavra')//limita por palavras
		{
			$palavras = explode(' ',$string);

			if( count($palavras) > $tamanho )
			{
				$str=$palavras[0];
				$i=1;
				while($i < $tamanho)
				{
					$str .= ' '.$palavras[$i];
					$i++;
				}
				$this->string = trim($str).$cont;
		        //$this->string = mb_substr($string, 0, $tamanho - 3, $encode) . '...';
			}
		    else
		        $this->string = $string;
		}else
		{
		    if( strlen($string) > $tamanho )
		        $this->string = mb_substr($string, 0, $tamanho - 3, $encode) . $cont;
		    else
		        $this->string = mb_substr($string, 0, $tamanho, $encode);
		}
		return $this->string;
	}

	function getLimitar()
	{
		   return $this->string;
	}
}