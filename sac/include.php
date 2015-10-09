<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
define('BASEPATH',dirname(__FILE__).'/');

require_once(BASEPATH.'system'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

if(!function_exists('autoload'))
{
    /*** nullify any existing autoloads ***/
    spl_autoload_register(null, false);
    /*** specify extensions that may be loaded ***/
    spl_autoload_extensions('.php, .class.php, .library.php, .model.php, .controller.php');
    /*** register the loader functions ***/ 
            
    function includeFile($file)
    {
        require_once(str_replace('\\', '/', $file));
    }

    function _autoload($className)
    {
        //library app
        $filename   = $className . '.library.php';
        $file       = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$filename;

        //model app
        $filename   = $className . '.model.php';
        $file1      = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.$filename;

        //controller app
        $filename   = $className . '.controller.php';
        $file2      = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.$filename;

        //library system
        $filename   = $className . '.library.php';
        $file3       = BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$filename;
        
        //core system
        $filename   = $className . '.php';
        $file4       = BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.$filename;

        //database system
        $filename   = $className . '.php';
        $file5       = BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.$filename;


        if (file_exists($file)) 
            includeFile($file);
        else
        if(file_exists($file1))
            includeFile($file1);
        else
        if(file_exists($file2))
            includeFile($file2);
        else
        if(file_exists($file3))
            includeFile($file3);
        else
        if(file_exists($file4))
            includeFile($file4);
        else
        if(file_exists($file5))
            includeFile($file5);
    }

    spl_autoload_register('_autoload');

}


// function checkConfig()
// {
// 	if(	!defined('HOSTNAME') 
// 		|| !defined('USERNAME') 
// 		|| !defined('PASSWORD') 
// 		|| !defined('DBNAME') 
// 		|| !defined('MYSQLPORT')
// 		|| !defined('BASEPATH')
// 		|| !defined('MODELS')
// 		|| !defined('VIEWS')
// 		|| !defined('CONTROLLERS')
// 	){
// 		die('Arquivo de configuração não está configurado corretamente. Configure o caminho do servidor mysql, com porta login e senha.');
// 	}
// }

// checkConfig();