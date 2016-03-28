<?php 


class uploadFoto
{
	private $nomeArquivoFoto;
	public function uploadFoto($directory, $arquivo, $nomeArquivo, $tamanhos = array(), $cropValues = array())
	{
		$directory = ltrim(rtrim($directory));

		if(!is_dir(BASEPATH.'gerenciador/'.UPLOADPATH.'/'.$directory))
			mkdir(BASEPATH.'gerenciador/'.UPLOADPATH.'/'.$directory);

		if(is_dir(BASEPATH.'gerenciador/'.UPLOADPATH.'/'.$directory))
		{
			$destinoOriginal = BASEPATH.'gerenciador/'.UPLOADPATH.'/'.$directory.'/';
			if(!is_dir($destinoOriginal))
				mkdir($destinoOriginal);


			$this->load->library('upload');
			$upload = new upload();
			$img = $upload->setUpload($arquivo,$destinoOriginal, $nomeArquivo);
			
			if($upload->getError() == false)
			{
				$origem = $destinoOriginal.$upload->getArquivo();
				foreach ($tamanhos as $tamanho => $valores)
				{
					$_destCrop = 'destino_'.$tamanho;

					$$_destCrop = BASEPATH.'gerenciador/'.UPLOADPATH.'/'.$directory.'/'.$tamanho.'/';

					if(!is_dir($$_destCrop))
						mkdir($$_destCrop);

					$$_destCrop = $$_destCrop.$upload->getArquivo();

					$w = $cropValues['w'] ;
					$h =  $cropValues['h'];
					$x1 = $cropValues['x1'];
					$y1 = $cropValues['y1'];
					
					$crop = new crop_image();
					$crop->setImage($origem,$$_destCrop,$w, $h,$x1, $y1,$valores['w'], $valores['h']);
					$crop->cropResize();

				}
				$this->nomeArquivoFoto = $upload->getArquivo();
				return true;
			}else
				return $upload->getError();
		}else
			return 'Erro ao efetuar o upload. O diretório não existe';
	}
	public function getNomeArquivo()
	{
		return $this->nomeArquivoFoto
	}
}
