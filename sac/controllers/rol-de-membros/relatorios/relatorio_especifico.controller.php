<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class relatorio_especifico extends Controller{
	private $error = array(); //erro geral
	private $relatorioModel; //variavel de instancia do model
	private $errroValidate; //erros de validação
	private $relatorioResult; //resultado da consulta sql
	private $camposTh; //campos que formarão o thead da tabela
	private $tabelaArray = array(); //tabela do relatório em formato array

	public function __construct(){
		parent::__construct();
		//checagem do login
		$login = new loginModel();
		$login->statusLogin();
	}

	/********************************************/
	/****PÁGINAS****/

	/**
	*Página index
	*/
	public function index()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Relatório Específico',
			'method' => __METHOD__
		);

		//carregamento do model e listagem
		$this->loadModel('membros/relatorioEspecificoModel');
		$this->relatorioModel = new relatorioEspecificoModel();
		$relatorios = $this->relatorioModel->listar();
		$data['relatorios'] = $relatorios;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('rol-de-membros/relatorios/relatorio_especifico/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	/**
	*Página cadastrar
	*/
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Criar relatório'
		);

		//estado civil
		$this->loadModel('configuracoes/tabelas/estadoCivilModel');
		$estadocivil = new estadocivilModel();
		$estadocivil = $estadocivil->listar('Ativo');
		$data['estadocivil'] = $estadocivil;

		//tipo de recebimento
		$this->loadModel('configuracoes/tabelas/tipoRecebimentoModel');
		$tipoRecebimento = new tipoRecebimentoModel();
		$tipoRecebimento = $tipoRecebimento->listar("status_tipo_recebimento = 'Ativo'");
		$data['tipoRecebimento'] = $tipoRecebimento;


		//tipo de membro
		$this->loadModel('configuracoes/tabelas/tipoMembroModel');
		$tipoMembro = new tipoMembroModel();
		$tipoMembro = $tipoMembro->listar("status_tipo_membro = 'Ativo'");
		$data['tipoMembro'] = $tipoMembro;

		//tipo de ofício da igreja
		$this->loadModel('configuracoes/tabelas/tipoOficioIgrejaModel');
		$tipoOficioIgreja = new tipoOficioIgrejaModel();
		$tipoOficioIgreja = $tipoOficioIgreja->listar("status_tipo_oficio_igreja = 'Ativo'");
		$data['tipoOficioIgreja'] = $tipoOficioIgreja;


		//igreja
		$this->loadModel('igreja/igrejaModel');
		$igreja = new igrejaModel();
		$igreja = $igreja->listar('=','Ativo');
		$data['igreja'] = $igreja;

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('rol-de-membros/relatorios/relatorio_especifico/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}


	/**
	*Página visualizar
	*/
	public function visualizar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Visualizar relatório',
			'method' => __METHOD__
		);
		$url = new url();
		$id = intval($url->getSegment(4));
		//carregamento do model e listagem
		$this->loadModel('membros/relatorioEspecificoModel');
		$this->relatorioModel = new relatorioEspecificoModel();
		$this->relatorioModel->setId($id);
		$relatorio = $this->relatorioModel->getRelatorio();
		$data['id_relatorio'] = $id;
		$data['relatorio'] = $relatorio;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('rol-de-membros/relatorios/relatorio_especifico/visualizar',$data);
		$this->loadView('includes/baseBottom',$data);
	}


	/********************************************/
	/****FUNÇÕES DE ALTERAÇÕES DE REGISTROS****/

	/**
	* Converte a tabela para um arquivo PDF
	*/
	public function convertToPdf()
	{
		$url = new url();
		$id = intval($url->getSegment(4));
		//carregamento do model e listagem
		$this->loadModel('membros/relatorioEspecificoModel');
		$this->relatorioModel = new relatorioEspecificoModel();
		$this->relatorioModel->setId($id);
		$relatorio = $this->relatorioModel->getRelatorio();
		if($relatorio != false)
		{
			$tabelaRelatorio = json_decode($relatorio['content_relatorio'],true);
	        $thead = '';
	        $tfoot = '';
	        $tbody = '';
	        $th = '<tr>';
	        $td = '';
	        foreach ($tabelaRelatorio['thead'] as $thead)
	        {
	            $th .= '<th>'.$thead.'</th>';
	        }
	        $th .= '</tr>';

	        foreach ($tabelaRelatorio['tbody'] as $tbody)
	        {
	            $td .= '<tr>';
	            foreach ($tbody as $value) 
	            {
	                $td .= '<td>'.$value.'</td>';    
	            }
	            $td .='</tr>';
	        }


	        $thead = $th;
	        //$tfoot = $th;
	        $tbody = $td;
	        $template = new template();
	        $table = $template->simplesTabela($thead, $tfoot, $tbody, 'id="tablePrevisualizar"');


			require_once(BASEPATH."system/library/dompdf/dompdf_config.inc.php");
			$dataFormat = new dataFormat();
			$html =utf8_decode("<html>
						<body>
							<h2 style=\"text-align:center;display:block; border-botton:1px solid #CCC\">Sistema de gerenciamento eclesiástico</h2>
							<h3>".ucfirst($relatorio['nome_relatorio'])."</h3>
							<p><small><strong>Data: </strong>".$dataFormat->formatar($relatorio['data_cadastro_relatorio'],'datahora')."</small></p>
							<p><small><strong>Autor: </strong>".$relatorio['autor_relatorio']."</small></p>
							$table
						</body>
					</html>");

			$char = new caracteres($relatorio['nome_relatorio']);
			$nomeArquivo = $char->getValor().'_'.$id;

			//exit;
			$dompdf = new DOMPDF();
			$dompdf->load_html($html);
			$dompdf->set_paper('letter', 'portrait');
			$dompdf->render();
			$dompdf->stream("./sample.pdf",array("Attachment" => false));

			$pdf = $dompdf->output(); // Cria o pdf

			$arquivo = BASEPATH.'downloads/pdf/relatorio_especifico_membro/'.$nomeArquivo.'.pdf'; // Caminho onde será salvo o arquivo.
			if (file_put_contents($arquivo,$pdf)) 
			{ 
				header(URL.'downloads/pdf/relatorio_especifico_membro/'.$nomeArquivo.'.pdf');//Tenta salvar o pdf gerado
			    return true; // Salvo com sucesso.
			}else 
			{
			    return false; // Erro ao salvar o arquivo
			}
		}
	}

	/**
	* Converte a tabela para um arquivo XLS
	*/
	public function convertToXls()
	{
		$url = new url();
		$id = intval($url->getSegment(4));
		//carregamento do model e listagem
		$this->loadModel('membros/relatorioEspecificoModel');
		$this->relatorioModel = new relatorioEspecificoModel();
		$this->relatorioModel->setId($id);
		$relatorio = $this->relatorioModel->getRelatorio();
		if($relatorio != false)
		{
			$char = new caracteres($relatorio['nome_relatorio']);
			$nomeArquivo = $char->getValor().'_'.$id;
			$this->loadLibrary('PHPExcel/Writer/Excel2007');

			//include 'PHPExcel/Writer/Excel2007.php';
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			// Set properties
			$objPHPExcel->getProperties()->setCreator($_SESSION['login_adm']['nome'].' '.$_SESSION['login_adm']['sobrenome']);
			//$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
			$objPHPExcel->getProperties()->setTitle($relatorio['nome_relatorio']);
			$objPHPExcel->getProperties()->setSubject($relatorio['nome_relatorio']);
			$objPHPExcel->getProperties()->setDescription($relatorio['nome_relatorio']);

			// Add some data
			//echo date('H:i:s') . " Add some data\n";
			$objPHPExcel->setActiveSheetIndex(0);
			$thead = '';
	        $tfoot = '';
	        $tbody = '';
	        $th = '';
	        $td = '';
			$col = 'A';
			$row = '5';
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Relatório: '.$relatorio['nome_relatorio']);

			$dataFormat = new dataFormat();
			

			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Data: '.$dataFormat->formatar($relatorio['data_cadastro_relatorio'],'datahora'));
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Autor: '.$relatorio['autor_relatorio']);
			$sheet = $objPHPExcel->getActiveSheet();

			

			$tabelaRelatorio = json_decode(strip_tags($relatorio['content_relatorio']),true);
			foreach ($tabelaRelatorio['thead'] as $thead)
			{
				//aplicando background no head da tabela e a cor nos textos
				$sheet->getStyle($col.$row)->applyFromArray(
			        array(
			        	'font'  => array(
					        'bold'  => true,
					        'color' => array('rgb' => '000000'),
					        'size'  => 12,
					    ),
			            'fill' => array(
			                'type' => PHPExcel_Style_Fill::FILL_SOLID,
			                'color' => array('rgb' => 'CCCCCC')
			            )
			        )
			    );
				$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);//definindo o dimencionamento horizontal automatico
			    $objPHPExcel->getActiveSheet()->SetCellValue($col.$row, $thead);//adicionando o texto na célula
			    $col++;
			}
			//$col = $col - 1;

			$sheet->getStyle('A1')->getAlignment()->applyFromArray(
			    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
			);
			
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:'.$col.'1');//mesclando as celulas
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:'.$col.'2');//mesclando as celulas
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:'.$col.'3');//mesclando as celulas
			
			$sheet->getStyle('A1')->applyFromArray(
		        array(
		        	'font'  => array(
				        'bold'  => true,
				        'color' => array('rgb' => '000000'),
				        'size'  => 13,
				    ),
		            'fill' => array(
		                'type' => PHPExcel_Style_Fill::FILL_SOLID,
		                'color' => array('rgb' => 'CCCCCC')
		            )
		        )
		    );

			$col = 'A';
			$row ++;
			foreach ($tabelaRelatorio['tbody'] as $tbody)
			{
			    foreach ($tbody as $value) 
			    {

			       $objPHPExcel->getActiveSheet()->SetCellValue($col.$row, $value);
			       $col++;
			    }
			    $row++;
			    $col = 'A';

			}

			$col = 'A';
			foreach ($tabelaRelatorio['thead'] as $thead)
			{
				$sheet->getStyle($col.$row)->applyFromArray(
			        array(
			        	'font'  => array(
					        'bold'  => true,
					        'color' => array('rgb' => '000000'),
					        'size'  => 12,
					    ),
			            'fill' => array(
			                'type' => PHPExcel_Style_Fill::FILL_SOLID,
			                'color' => array('rgb' => 'CCCCCC')
			            )
			        )
			    );
			    $objPHPExcel->getActiveSheet()->SetCellValue($col.$row, $thead);
			    $col++;
			}
			/*
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Hello');
			$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'world!');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Hello');
			$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'world!');
			*/
			// Rename sheet
			//echo date('H:i:s') . " Rename sheet\n";

			$objPHPExcel->getActiveSheet()->setTitle('Simple');

			        
			// Save Excel 2007 file
			//echo date('H:i:s') . " Write to Excel2007 format\n";
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$res = $objWriter->save(str_replace('.php', '.xlsx', BASEPATH.'downloads/xls/relatorio_especifico_membro/'.$nomeArquivo.'.xlsx'));
			header('Location:'.URL.'downloads/xls/relatorio_especifico_membro/'.$nomeArquivo.'.xlsx');
		}
	}


	/**
	* Pré visualização do relatório
	* Além de retornar a tabela do relatório ele insere no banco 
	* apenas com a existência do parâmetro action com conteudo "Salvar"
	*/
	public function previsualizarRelatorio()
	{

		$campos = isset($_POST['campos']) ? filter_var_array($_POST['campos']) : array();//campos de apoio para recuperar apenas os conteúdos selecionados
		$camposTh = isset($_POST['camposTh']) ? filter_var_array($_POST['camposTh']) : array(); //campos que formarão o thead da tabela

		//os mesmos valores do campo <select> é o mesmo correspondente ao array $camposNomeTh

		$camposNomeTh = array();
		$camposNomeTh['nome'] = 'Nome';
        $camposNomeTh['sobrenome'] = 'Sobrenome';
        $camposNomeTh['data_nascimento'] = 'Data de Nascimento';
        $camposNomeTh['sexo'] = 'Sexo';
        $camposNomeTh['rg'] = 'RG';
        $camposNomeTh['cpf'] = 'CPF';
        $camposNomeTh['estado_civil'] = 'Estado Civil';
        $camposNomeTh['data_casamento'] = 'Data de Casamento';
        $camposNomeTh['endereco'] = 'Endereço';
        $camposNomeTh['telefones'] = 'Telefones';
        $camposNomeTh['email'] = 'E-mails';
        $camposNomeTh['profissao'] = 'Profissão';
        $camposNomeTh['igreja'] = 'Igreja';
        $camposNomeTh['num_rol'] = 'Nº Rol';
        $camposNomeTh['data_recebimento_membro'] = 'Data de recebimento como membro';
        $camposNomeTh['data_batismo'] = 'Data do batismo';
        $camposNomeTh['data_profissao_fe'] = 'Data da profissão de fé';
        $camposNomeTh['celebrante_batismo'] = 'Celebrante do batismo';
        $camposNomeTh['local_batismo'] = 'Local do batismo';
        $camposNomeTh['tipo_recebimento'] = 'Tipo de recebimento';
        $camposNomeTh['tipo_membro'] = 'Tipo de membro';
        $camposNomeTh['oficial_igreja'] = 'Oficial da Igreja';
        $camposNomeTh['dizimista'] = 'Dizimista';
        $camposNomeTh['data_cadastro'] = 'Data de cadastro';
        $camposNomeTh['status'] = 'Status';



		$this->loadModel('membros/relatorioEspecificoModel');
		$this->relatorioModel = new relatorioEspecificoModel();
		$this->relatorioModel->setCamposSelect($camposTh); //determina os campos para formarem o select de consulta
		//chamada de cada método para validação separada dos campos
		foreach ($campos as $action)
		{
			if(method_exists($this, $action))
				$this->$action();
		}

		if($this->errroValidate == '')
		{
			$this->relatorioResult = $this->relatorioModel->gerarRelatorio();//retorna o resultado da consulta

			if($this->relatorioResult != false)
			{
				//construção da tabela em HTML e em array
				$template = new template();
	            $th = '';
	            foreach ($camposTh as $value) {
	            							//coluna	
					$this->tabelaArray['thead'][] = $camposNomeTh[$value];
	            	$th .= '<th>'. $camposNomeTh[$value].'</th>';
	            }

	            $thead = '<tr>';
	            $thead .= $th;
				$thead .= '</tr>';

				$tfoot = '<tr>';
	            $tfoot .= $th;
				$tfoot .= '</tr>';

				//inverte os dados de $campoTh como indice para colocar como valores os seus correspondentes do resultado da consulta
				$camposTh = array_fill_keys($camposTh, '&nbsp;');
				//print_r($camposTh);

	            $tbody = '';
	            $i = 0;
	            foreach ($this->relatorioResult as $value)
	            {
	            	$dataFormat = new dataFormat();

			        $tbody  .='<tr>';
			        if(array_key_exists('nome', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['nome_membro'];
			            $camposTh['nome'] = '<td>'.$value['nome_membro'].'</td>';
			        }
			        
			        if(array_key_exists('sobrenome', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['sobrenome_membro'];
			            $camposTh['sobrenome'] = '<td>'.$value['sobrenome_membro'].'</td>';
			        }

			        if(array_key_exists('data_nascimento', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $dataFormat->formatar($value['data_nascimento_membro'],'data');
			            $camposTh['data_nascimento'] = '<td>'.$dataFormat->formatar($value['data_nascimento_membro'],'data').'</td>';
			        }

			        if(array_key_exists('sexo', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['sexo_membro'];
					    $camposTh['sexo'] = '<td>'.$value['sexo_membro'].'</td>';
			        }

					if(array_key_exists('rg', $camposTh))
					{
						$this->tabelaArray['tbody'][$i][] = $value['rg_membro'];
				        $camposTh['rg'] = '<td>'.$value['rg_membro'].'</td>';
					}

				    if(array_key_exists('cpf', $camposTh))
				    {
				    	$this->tabelaArray['tbody'][$i][] = $value['cpf_membro'];
			            $camposTh['cpf'] = '<td>'.$value['cpf_membro'].'</td>';
				    }

			        if(array_key_exists('estado_civil', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['nome_estado_civil'];
						$camposTh['estado_civil'] = '<td>'.$value['nome_estado_civil'].'</td>';
			        }

					if(array_key_exists('data_casamento', $camposTh))
					{
						$this->tabelaArray['tbody'][$i][] = $dataFormat->formatar($value['data_casamento_membro'],'data');
			            $camposTh['data_casamento'] = '<td>'.$dataFormat->formatar($value['data_casamento_membro'],'data').'</td>';
					}

			        if(array_key_exists('endereco', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $this->relatorioModel->getEndereco($value['id_membro']);
			        	$camposTh['endereco'] = '<td>'.$this->relatorioModel->getEndereco($value['id_membro']).'</td>';
			        }

			        if(array_key_exists('telefones', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $this->relatorioModel->getTelefones($value['id_membro']);
			        	$camposTh['telefones'] = '<td>'.$this->relatorioModel->getTelefones($value['id_membro']).'</td>';
			        }
			                        
			        if(array_key_exists('email', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $this->relatorioModel->getEmails($value['id_membro']);
			        	$camposTh['email'] = '<td>'.$this->relatorioModel->getEmails($value['id_membro']).'</td>';
			        }

			        if(array_key_exists('igreja', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['nome_igreja'];
			        	$camposTh['igreja'] = '<td>'.$value['nome_igreja'].'</td>';
			        }

			        if(array_key_exists('num_rol', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['numero_rol_membro'];
			        	$camposTh['num_rol'] = '<td>'.$value['numero_rol_membro'].'</td>';
			        }
				    
				    if(array_key_exists('data_recebimento_membro', $camposTh))
				    {
				    	$this->tabelaArray['tbody'][$i][] = $dataFormat->formatar($value['data_recebimento_membro'],'data');
			        	$camposTh['data_recebimento_membro'] = '<td>'.$dataFormat->formatar($value['data_recebimento_membro'],'data').'</td>';
				    }

			        if(array_key_exists('data_batismo', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $dataFormat->formatar($value['data_batismo'],'data');
			        	$camposTh['data_batismo'] = '<td>'.$dataFormat->formatar($value['data_batismo'],'data').'</td>';
			        }

			        if(array_key_exists('data_profissao_fe', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $dataFormat->formatar($value['data_profissao_fe_membro'],'data');
			        	$camposTh['data_profissao_fe'] = '<td>'.$dataFormat->formatar($value['data_profissao_fe_membro'],'data').'</td>';
			        }

			        if(array_key_exists('celebrante_batismo', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['celebrante_batismo'];
			        	$camposTh['celebrante_batismo'] = '<td>'.$value['celebrante_batismo'].'</td>';
			        }

			        if(array_key_exists('local_batismo', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['local_batismo'];
			        	$camposTh['local_batismo'] = '<td>'.$value['local_batismo'].'</td>';
			        }

			        if(array_key_exists('tipo_recebimento', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['nome_tipo_recebimento'];
			        	$camposTh['tipo_recebimento'] = '<td>'.$value['nome_tipo_recebimento'].'</td>';
			        }

			        if(array_key_exists('tipo_membro', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['nome_tipo_membro'];
			        	$camposTh['tipo_membro'] = '<td>'.$value['nome_tipo_membro'].'</td>';
			        }

			        if(array_key_exists('oficial_igreja', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['nome_tipo_oficio_igreja'].' - '.$value['nome_status_tipo_oficio_igreja'];
			        	$camposTh['oficial_igreja'] = '<td>'.$value['nome_tipo_oficio_igreja'].' - '.$value['nome_status_tipo_oficio_igreja'].'</td>';
			        }

			        if(array_key_exists('dizimista', $camposTh)){
			           	$nDizimista = ($value['dizimista_membro'] == 'Sim') ? ' - Nº '.$value['numero_dizimista'] : "";
			           	$this->tabelaArray['tbody'][$i][] = $value['dizimista_membro'].$nDizimista;
			        	$camposTh['dizimista'] = '<td>'.$value['dizimista_membro'].$nDizimista.'</td>';
			        }

			        if(array_key_exists('data_cadastro', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $dataFormat->formatar($value['data_cadastro_membro'],'datahora');
			        	$camposTh['data_cadastro'] = '<td>'.$dataFormat->formatar($value['data_cadastro_membro'],'datahora').'</td>';
			        }

			        if(array_key_exists('status', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['status_membro'];
			        	$camposTh['status'] = '<td>'.$value['status_membro'].'</td>';
			        }

			        if(array_key_exists('profissao', $camposTh))
			        {
			        	$this->tabelaArray['tbody'][$i][] = $value['profissao_membro'];
			        	$camposTh['profissao'] = '<td>'.$value['profissao_membro'].'</td>';
			        }

			        //insere os valores resgatados no tbody
			        foreach ($camposTh as $value) {
			        	$tbody  .= $value;
			        }

			        $tbody  .='</tr>';
			        $i++;
	            }

	            //cria a tabela em html
	    		$tabela = $template->simplesTabela($thead, $tfoot, $tbody, 'id="tablePrevisualizar"');




	    		//acao que faz salvar o relatorio apenas com a existencia do parâmetro "action"
	    		if(isset($_POST['action']) && $_POST['action'] == 'Salvar')
	    		{
	    			return $this->salvarRelatorio();
	    		}else{
		    		$result = array(
		    			'result' => true,
		    			'tabela'=>$tabela,
		    			'totalReg' => $this->relatorioModel->getTotalReg()
		    		);
	    			echo json_encode($result);
	    		}
			}else{
				$result = array(
	    			'result' => false,
	    			'error' => array(array('erro'=> 'Nenhum registro correspondente'))
	    		);
				echo json_encode($result);	
			}
		}else{
			$result = array(
    			'result' => false,
    			'error' => $this->errroValidate
    		);
			echo json_encode($result);
		}

	}


	/*
	*executa a validação da data de nascimento
	*/
	private function data_nascimento()
	{
		$data_nascimento_de = isset($_POST['data_nascimento_de']) ? filter_var(trim($_POST['data_nascimento_de'])) : '';
		$data_nascimento_ate = isset($_POST['data_nascimento_ate']) ? filter_var(trim($_POST['data_nascimento_ate'])) : '';
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Data de nascimento de', $data_nascimento_de, 'data_nascimento_de')->is_required()->is_date('d/m/Y');
		$validate->set('Data de nascimento até', $data_nascimento_ate, 'data_nascimento_ate')->is_required()->is_date('d/m/Y');

		if ($validate->validate())
		{
			$this->relatorioModel->setDataNascimento($data_nascimento_de, $data_nascimento_ate);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
			
		}
	}

	/*
	*executa a validação do sexo
	*/
	private function sexo()
	{
		$sexo = isset($_POST['sexo']) ? filter_var_array($_POST['sexo']) : array();
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Sexo', $sexo, 'sexo')->is_required();

		if ($validate->validate())
		{
			$this->relatorioModel->setSexo($sexo);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}

	/*
	*executa a validação do estado civil
	*/
	private function estado_civil()
	{
		$estado_civil = isset($_POST['estado_civil']) ? filter_var_array($_POST['estado_civil']) : array();
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Estado civil', $estado_civil, 'estado_civil')->is_required();

		if ($validate->validate())
		{
			$this->relatorioModel->setEstadoCivil($estado_civil);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}

	/*
	*executa a validação da data de casamento
	*/
	private function data_casamento()
	{
		$data_casamento_de = isset($_POST['data_casamento_de']) ? filter_var(trim($_POST['data_casamento_de'])) : '';
		$data_casamento_ate = isset($_POST['data_casamento_ate']) ? filter_var(trim($_POST['data_casamento_ate'])) : '';
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Data de casamento de', $data_casamento_de, 'data_casamento_de')->is_required()->is_date('d/m/Y');
		$validate->set('Data de casamento até', $data_casamento_ate, 'data_casamento_ate')->is_required()->is_date('d/m/Y');

		if ($validate->validate())
		{
			$this->relatorioModel->setDataCasamento($data_casamento_de, $data_casamento_ate);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}


	/*
	*executa a validação da data de recebimento como membro
	*/
	private function data_recebimento_membro()
	{
		$data_recebimento_membro_de = isset($_POST['data_recebimento_membro_de']) ? filter_var(trim($_POST['data_recebimento_membro_de'])) : '';
		$data_recebimento_membro_ate = isset($_POST['data_recebimento_membro_ate']) ? filter_var(trim($_POST['data_recebimento_membro_ate'])) : '';
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Data de recebimento como membro de', $data_recebimento_membro_de, 'data_recebimento_membro_de')->is_required()->is_date('d/m/Y');
		$validate->set('Data de recebimento como membro até', $data_recebimento_membro_ate, 'data_recebimento_membro_ate')->is_required()->is_date('d/m/Y');

		if ($validate->validate())
		{
			$this->relatorioModel->setDataRecebimento($data_recebimento_membro_de, $data_recebimento_membro_ate);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}


	/*
	*executa a validação da data de batismo
	*/
	private function data_batismo()
	{
		$data_batismo_de = isset($_POST['data_batismo_de']) ? filter_var(trim($_POST['data_batismo_de'])) : '';
		$data_batismo_ate = isset($_POST['data_batismo_ate']) ? filter_var(trim($_POST['data_batismo_ate'])) : '';
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Data do batismo de', $data_batismo_de, 'data_batismo_de')->is_required()->is_date('d/m/Y');
		$validate->set('Data do batismo até', $data_batismo_ate, 'data_batismo_ate')->is_required()->is_date('d/m/Y');

		if ($validate->validate())
		{
			$this->relatorioModel->setDataBatismo($data_batismo_de, $data_batismo_ate);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}


	/*
	*executa a validação da data de profissão de fé
	*/
	private function data_profissao_fe()
	{
		$data_profissao_fe_de = isset($_POST['data_profissao_fe_de']) ? filter_var(trim($_POST['data_profissao_fe_de'])) : '';
		$data_profissao_fe_ate = isset($_POST['data_profissao_fe_ate']) ? filter_var(trim($_POST['data_profissao_fe_ate'])) : '';
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Data da profissão de fé de', $data_profissao_fe_de, 'data_profissao_fe_de')->is_required()->is_date('d/m/Y');
		$validate->set('Data da profissão de fé até', $data_profissao_fe_ate, 'data_profissao_fe_ate')->is_required()->is_date('d/m/Y');

		if ($validate->validate())
		{
			$this->relatorioModel->setDataProfissaoFe($data_profissao_fe_de, $data_profissao_fe_ate);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}


	/*
	*executa a validação da data de recebimento
	*/
	private function tipo_recebimento()
	{
		$tipo_recebimento = isset($_POST['tipo_recebimento']) ? filter_var_array($_POST['tipo_recebimento']) : array();
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Tipo de recebimento', $tipo_recebimento, 'tipo_recebimento')->is_required();

		if ($validate->validate())
		{
			$this->relatorioModel->setTipoRecebimento($tipo_recebimento);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}


	/*
	*executa a validação do tipo de membro
	*/
	private function tipo_membro()
	{
		$tipo_membro = isset($_POST['tipo_membro']) ? filter_var_array($_POST['tipo_membro']) : array();
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Tipo de membro', $tipo_membro, 'tipo_membro')->is_required();

		if ($validate->validate())
		{
			$this->relatorioModel->setTipoMembro($tipo_membro);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}


	/*
	*executa a validação do ofícil da igreja
	*/
	private function oficial_igreja()
	{
		$oficial_igreja = isset($_POST['tipo_oficial_igreja']) ? filter_var_array($_POST['tipo_oficial_igreja']) : array();
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Oficial da igreja', $oficial_igreja, 'oficial_igreja')->is_required();

		if ($validate->validate())
		{
			$this->relatorioModel->setOficial_igreja($oficial_igreja);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}

	/*
	*executa a validação do dizimista
	*/
	private function dizimista()
	{
		$dizimista = isset($_POST['dizimista']) ? filter_var_array($_POST['dizimista']) : array();
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Dizimista', $dizimista, 'dizimista')->is_required();

		if ($validate->validate())
		{
			$this->relatorioModel->setDizimista($dizimista);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}


	/*
	*executa a validação da data de cadastro
	*/
	private function data_cadastro()
	{
		$data_cadastro_de = isset($_POST['data_cadastro_de']) ? filter_var(trim($_POST['data_cadastro_de'])) : '';
		$data_cadastro_ate = isset($_POST['data_cadastro_ate']) ? filter_var(trim($_POST['data_cadastro_ate'])) : '';
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Data de cadastro de', $data_cadastro_de, 'data_cadastro_de')->is_required()->is_date('d/m/Y');
		$validate->set('Data de cadastro até', $data_cadastro_ate, 'data_cadastro_ate')->is_required()->is_date('d/m/Y');

		if ($validate->validate())
		{
			$this->relatorioModel->setDataCadastro($data_cadastro_de, $data_cadastro_ate);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}

	/*
	*executa a validação do status
	*/
	private function status()
	{
		$status = isset($_POST['status']) ? filter_var_array($_POST['status']) : array();
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Status', $status, 'status')->is_required();

		if ($validate->validate())
		{
			$this->relatorioModel->setStatus($status);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}

	/*
	*executa a validação da igreja
	*/
	private function igreja()
	{
		$igreja = isset($_POST['igreja']) ? filter_var_array($_POST['igreja']) : array();
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Igreja', $igreja, 'igreja')->is_required();

		if ($validate->validate())
		{
			$this->relatorioModel->setIgreja($igreja);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}


	/*
	*executa a validação da busca específica
	*/
	private function busca_especifica()
	{
		$busca_especifica = isset($_POST['busca_especifica']) ? filter_var(strip_tags($_POST['busca_especifica'])) : '';
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Busca específica', $busca_especifica, 'busca_especifica')->is_required();

		if ($validate->validate())
		{
			$this->relatorioModel->setBusca_especifica($busca_especifica);
		}else
		{
			$this->errroValidate[] = $validate->get_errors();
		}
	}



	/*
	*salva o relatório no banco
	* este método é executado apenas se existir o parâmetro "action"
	*/
	public function salvarRelatorio()
	{
		$nome_relatorio = isset($_POST['nome_relatorio']) ? filter_var($_POST['nome_relatorio']) : '';
		$relatorio = json_encode($this->tabelaArray);
		echo $this->relatorioModel->inserir($nome_relatorio, $relatorio);
	}



	/**
	*Atualiza o status 
	*/
	public function atualizarStatus()
	{
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$status =isset($_POST['status']) ? $_POST['status'] : '';

		if($status == '')
		{
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status. Campo status não encontrado'));	
			return false;
		}

		$this->loadModel('membros/relatorioEspecificoModel');
		$this->relatorioModel = new relatorioEspecificoModel();
		$this->relatorioModel->setId($id);
		$this->relatorioModel->setStatus($status);
		if($this->relatorioModel->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
		
			
	}

}

/*
DISPOSIÇÃO DO ARRAY DO RELATÓRIO PARA SALVAR COMO JSON NO BANCO
EXEMPLO:
			   col
$table['thead'][0] = "nome";
$table['thead'][1] = "sobrenome";
$table['thead'][2] = "endereco";

			   li Co
$table['tbody'][1][0] = "Nome do primeiro registro";
$table['tbody'][1][1] = "Sobrenome do primeiro registro";
$table['tbody'][1][2] = "Endereço do primeiro registro";

$table['tbody'][2][0] = "Nome do segundo registro";
$table['tbody'][2][1] = "Sobrenome do segundo registro";
$table['tbody'][2][2] = "Endereço do segundo registro";

*/

/**
*
*class: relatorio_especifico
*
*location : controllers/rol-de-membros/relatorios/relatorio_especifico.controller.php
*/