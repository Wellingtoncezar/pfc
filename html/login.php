<?php

//TEMPO DE EXECUXÃO
// Iniciamos o "contador"
list($usec, $sec) = explode(' ', microtime());
$script_start = (float) $sec + (float) $usec;
?>
<!DOCTYPE html>
<html lang="pt-br" ng-app>
<head>
    <meta charset="utf-8">
    <!--[if lt IE 9]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>SAC - Sistema de Automação Comercial</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/large_desktops.css" />
    <link rel="stylesheet" type="text/css" href="css/desktops.css" />
    <link rel="stylesheet" type="text/css" href="css/tablets.css" />
    <link rel="stylesheet" type="text/css" href="css/extra_small_devices.css" />
    

    <meta name="robots" content="noindex, nofollow" />
    <!--[if IE]>
        <link rel="shortcut icon" href="img/favicon.ico">
    <![endif]-->
    <link rel="icon" href="img/favicon.png" />
    

    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="js/main.js"></script>

</head>
<body>
    <div id="wrap" >
    	<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="container_login">
    		<div class="box_login">
    			<header>
    				<img src="img/logo/logo.png">
    			</header>
        		<form class="form-horizontal" id="form_login" action="login/logar">
		      		<label class="input-group">
		      			<span class="input-group-addon glyphicon glyphicon-user"></span>
		      			<input type="text" class="form-control" id="login" name="login" placeholder="login">
		      		</label>

		      		<label class="input-group">
		      			<span class="input-group-addon glyphicons glyphicons-keys"></span>
		      			<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha">
		      		</label>

		      		<!--capcha - para 5 ou mais tentativas de login incorreta-->
		      		<label class="captcha input-group">
		      			<div class="img">
		      				<img src="login/captcha" style="width: 96%;">
		      			</div>
		      			<input type="text" class="form-control" id="captcha" name="captcha" placeholder="Insira o código">
		      		</label>

		      		<button type="submit" class="btn btn_login"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Entrar</button>
				</form>
				<a href="" class="recupera">Recuperar senha</a>
    		</div>

    	</section>
	</div><!--wrap-->

</body>
</html>

<?php

// Terminamos o "contador" e exibimos
list($usec, $sec) = explode(' ', microtime());
$script_end = (float) $sec + (float) $usec;
$elapsed_time = round($script_end - $script_start, 5);
// Exibimos uma mensagem
echo '<p>Elapsed time: ', $elapsed_time, ' secs. Memory usage: ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb</p>';

?>