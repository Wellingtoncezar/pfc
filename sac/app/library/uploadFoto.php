<?php 
if(!defined('BASEPATH')) die('Acesso não permitido');
class uploadFoto extends Library
{
	private $caminho = '';
	private $nomeArquivoFoto = '';
	private $tamanhos = Array();
	public function uploadFoto($directory, $arquivo, $nomeArquivo, $tamanhos = array(), $cropValues = array())
	{
		$this->caminho = BASEPATH.UPLOADPATH.'/'.$directory;
		$this->tamanhos = $tamanhos;
		if(empty($arquivo))
		{
			$this->nomeArquivoFoto = $nomeArquivo;
			return false;
		}
		$directory = ltrim(rtrim($directory));

		if(!is_dir($this->caminho))
			mkdir($this->caminho);


		if(is_dir($this->caminho))
		{
			$destinoOriginal = $this->caminho.'/';
			if(!is_dir($destinoOriginal))
				mkdir($destinoOriginal);

			$path_parts = pathinfo($nomeArquivo);
			$nomeArquivo = $path_parts['filename'];

			
			$upload = new upload($arquivo,$destinoOriginal, $nomeArquivo);


			
			if($upload->getError() == false)
			{
				$origem = $destinoOriginal.$upload->getArquivo();
				foreach ($this->tamanhos as $tamanho => $valores)
				{
					$_destCrop = 'destino_'.$tamanho;

					$$_destCrop = $this->caminho.'/'.$tamanho.'/';

					if(!is_dir($$_destCrop))
						mkdir($$_destCrop);

					$$_destCrop = $$_destCrop.$upload->getArquivo();

					$w = $cropValues['w'];
					$h =  $cropValues['h'];
					$x1 = $cropValues['x1'];
					$y1 = $cropValues['y1'];
					$crop = new crop_image();
					$crop->setImage($origem,$$_destCrop,$w, $h,$x1, $y1,$valores['w'], $valores['h']);
					$crop->cropResize();

				}
				$this->nomeArquivoFoto = $upload->getArquivo();
				return true;
			}else{
				throw new Exception($upload->getError(), 1);
			}
		}else{
			throw new Exception('Erro ao efetuar o upload. O diretório não existe', 1);
		}
	}
	public function getNomeArquivo()
	{
		return $this->nomeArquivoFoto;
	}

	public function resetUpload()
	{
		@unlink($this->caminho.'/'.$this->nomeArquivoFoto);
		foreach ($this->tamanhos as $tamanho => $valores)
		{
			@unlink($this->caminho.'/'.$tamanho.'/'.$this->nomeArquivoFoto);
		}


	}
}
