<?php

require_once('class.phpmailer.php'); //chama a classe de onde você a colocou.
require_once('class.smtp.php');
require_once('class.pop3.php');

$mail = new PHPMailer(); // instancia a classe PHPMailer

$mail->IsSMTP();

//configuração do gmail
$mail->Port = '465'; //porta usada pelo gmail.
$mail->Host = 'smtp.gmail.com'; 
$mail->IsHTML(true); 
$mail->Mailer = 'smtp'; 
$mail->SMTPSecure = 'ssl';

//configuração do usuário do gmail
$mail->SMTPAuth = true;
$mail->Username = 'prysmarket@gmail.com'; // usuario gmail.   
$mail->Password = 'prysmarket123'; // senha do email.

$mail->SingleTo = true; 

// configuração do email a ver enviado.
$mail->From = "prysmarket@gmail.com"; 
$mail->FromName = "welington"; 

$mail->addAddress("prysmarket@gmail.com"); // email do destinatario.

$mail->Subject = "Mudança de Data Agendada"; 
$mail->Body = ".";

if(!$mail->Send())
    echo "Erro ao enviar Email:" . $mail->ErrorInfo;


// define('SYSTEMPATH','system');
// define('LIBRARYPATH','library');
// define('APPPATH','app');
// require_once('include.php');
/*config::getInstance();
config::getConfig();
require_once(BASEPATH.'/app/DAO/produtos/marcasDao.php');
require_once(BASEPATH.'/app/models/produtos/marcasModel.php');

class testeMarca extends PHPUnit_Framework_TestCase{
	// public function testeListar(){
	// 	$marca = new marcasDao();
 //        $this->assertEquals(Array(), $marca->listar());
	// }

	// public function testeConsultar(){
	// 	$marcasModel = new marcasModel();
	// 	$marcasModel->setId(1);
	// 	$marca = new marcasDao();
 //        $this->assertEquals($marcasModel, $marca->consultar($marcasModel));
	// }

	// public function testeInserir(){
	// 	$marcasModel = new marcasModel();
	// 	$marcasModel->setNome('Coca');
	// 	$marcasModel->setStatus('ATIVO');
	// 	$marcasModel->setDataCadastro(date('Y-m-d H:i:s'));
	// 	$marca = new marcasDao();
	// 	$this->assertTrue($marca->inserir($marcasModel));
	// }


	// public function testeAtualizar(){
	// 	$marcasModel = new marcasModel();
	// 	$marcasModel->setId(9);
	// 	$marcasModel->setNome('Cocas');
	// 	$marca = new marcasDao();
	// 	$this->assertTrue($marca->atualizar($marcasModel));
	// }

	public function testeAtualizarStatus(){
		$marcasModel = new marcasModel();
		$marcasModel->setId(9);
		$marcasModel->setStatus('INAT');
		// var_dump($marcasModel);
		$marca = new marcasDao();
		$this->assertTrue($marca->atualizarStatus($marcasModel));
	}

}
*/
// $email = new email();
// $email->de('prysmarket@gmail.com');
// $email->para('prysmarket@gmail.com');
// $email->mensagem('teste');
// if($email->send())
// 	echo 'E-mail Enviado';
// else
// 	echo 'Erro ao enviar';

