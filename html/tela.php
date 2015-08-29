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
    <script type="text/javascript" src="js/freewall.js"></script>

</head>
<body>
    <div id="wrap" >
        <header class="header">
            <figure class="logo">
                <img src="img/logo/logo.png">
            </figure>

            <div class="user">
                <figure>
                    <img src="img/imagens/1439113442_Client_Male_Light.png">
                </figure>
                <p class="username">Nome do usuário</p>
            </div>
        </header>

        <div class="wrap-content">
            
        </div>
        <div class="menu-container animated fadeOutDown">
            <nav class="navbar-menu">
                <ul id="freewall" class="free-wall">
                    <li ><a href="" class="brick box1"><figure><img src="img/imagens/1439164733_Home.png"></figure>Home</a></li>
                    <li ><a href="" class="brick box2 inactive"><figure><img src="img/imagens/1439113161_provider.png"></figure>Fornecedor</a></li>
                    <li ><a href="" class="brick box3"><figure><img src="img/imagens/benchmarking.png"></figure>Produto</a></li>
                    <li ><a href="" class="brick box4"><figure><img src="img/imagens/1439113094_dollar__.png"></figure>Venda</a></li>
                    <li ><a href="" class="brick box5"><figure><img src="img/imagens/electronic_billing_machine.png"></figure>Caixa</a></li>
                    <li ><a href="" class="brick box6"><figure><img src="img/imagens/1439113073_inventory-maintenance.png"></figure>Estoque</a></li>
                    <li ><a href="" class="brick box3"><figure><img src="img/imagens/1439113228_people.png"></figure>Funcionários</a></li>
                    <li ><a href="" class="brick box1"><figure><img src="img/imagens/bids_and_budget.png"></figure>Relatórios</a></li>
                    <li ><a href="" class="brick box2"><figure><img src="img/imagens/utility.png"></figure>Utilitários</a></li>
                    <li ><a href="" class="brick box4"><figure><img src="img/imagens/config2.png"></figure>Configurações</a></li>
                </ul>   
            </nav>
        </div>
            
        <div id="nav-icon3">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
            
        
    </div><!--wrap-->
</body>

<script type="text/javascript">

            $(function() {
                
            });
        </script>


</html>

<?php

// Terminamos o "contador" e exibimos
list($usec, $sec) = explode(' ', microtime());
$script_end = (float) $sec + (float) $usec;
$elapsed_time = round($script_end - $script_start, 5);
// Exibimos uma mensagem
//echo '<p>Elapsed time: ', $elapsed_time, ' secs. Memory usage: ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb</p>';

?>