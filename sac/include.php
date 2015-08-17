<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!function_exists('autoload'))
{
    /*** nullify any existing autoloads ***/
    spl_autoload_register(null, false);
    /*** specify extensions that may be loaded ***/
    spl_autoload_extensions('.php, .class.php');
    /*** register the loader functions ***/ 
            
    function includeFile($file)
    {
        require_once(str_replace('\\', '/', $file));
    }

    function autoload($className)
    {
        //library system
        $filename   = $className . '.class.php';
        $file       = BASEPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$filename;
        
        //controller
        //$filename   = $className . '.controller.php';
       // $file1      = BASEPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.$filename;
        
        //model
        $filename   = $className . '.model.php';
        $file2      = BASEPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.$filename;

        //library system
        $filename   = $className . '.class.php';
        $file3      = BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$filename;

        if (file_exists($file)) 
            includeFile($file);
        else
       // if(file_exists($file1))
            //includeFile($file1);
        //else
        if(file_exists($file2))
            includeFile($file2);
        else
        if(file_exists($file3))
            includeFile($file3);
    }

    spl_autoload_register('autoload');

}


//define('DS',DIRECTORY_SEPARATOR);  
//define('ROOT',dirname(__FILE__));  
define('BASEPATH',dirname(__FILE__).'/');
require_once(BASEPATH.'system'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
require_once(BASEPATH.'system'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'Load.class.php');
require_once(BASEPATH.'system'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'Controller.class.php');
//require_once(BASEPATH.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'Model.class.php');
function checkConfig()
{
	if(	!defined('HOSTNAME') 
		|| !defined('USERNAME') 
		|| !defined('PASSWORD') 
		|| !defined('DBNAME') 
		|| !defined('MYSQLPORT')
		|| !defined('BASEPATH')
		|| !defined('MODELS')
		|| !defined('VIEWS')
		|| !defined('CONTROLLERS')
	){
		die('Arquivo de configuração não está configurado corretamente. Configure o caminho do servidor mysql, com porta login e senha.');
	}
}

checkConfig();