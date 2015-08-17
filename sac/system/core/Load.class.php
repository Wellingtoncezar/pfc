<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso não permitido');

class Load extends conn{
    public function __construct(){
        parent::__construct();
    }
    /*
    *Verifica se o diretório existe
    */
    public function checkDir($dir){
        if(is_dir(BASEPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.$dir))
            return true;
        else
            return false;
    }
    /*LOADCONTROLLER*/
    public function loadController($filename)
    {
        spl_autoload_register(array($this,'loadController'));
        $filename = BASEPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.$filename.'.controller.php';
        if(file_exists($filename)){
            require_once(str_replace('\\', '/', $filename));
            return true;
        }else
            return false;
        spl_autoload_unregister(array($this,'loadController'));
    }

    /*LOADLIBRARY*/
    public function loadLibrary($filename)
    {
        spl_autoload_register(array($this,'loadLibrary'));
        $filename = BASEPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$filename.'.class.php';
        $filename2 = BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$filename.'.class.php';
        if(file_exists($filename)){
            require_once(str_replace('\\', '/', $filename));
            return true;
        }else
        {
            if(file_exists($filename2)){
                require_once(str_replace('\\', '/', $filename));
                return true;
            }else
                return false;
        }
        spl_autoload_unregister(array($this,'loadLibrary'));
    }

    /*LOADMODEL*/
    public function loadModel($filename)
    {

        spl_autoload_register(array($this,'loadModel'));
        $filename = BASEPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.$filename.'.model.php';
        if(file_exists($filename)){
            require_once(str_replace('\\', '/', $filename));
            return true;
        }else
            return false;
        spl_autoload_unregister(array($this,'loadModel'));
    }


    /*LOADVIEW*/
    public function loadView($filename,$param = array())
    {
        spl_autoload_register(array($this,'loadView'));
        $filename = BASEPATH.DIRECTORY_SEPARATOR.VIEWS.DIRECTORY_SEPARATOR.$filename.'.phtml';
        if(file_exists($filename)){
            //extrai as variaveis
            if(is_array($param) && !empty($param))
                extract($param);
            require_once(str_replace('\\', '/', $filename));
            return true;
        }else
            return false;
        spl_autoload_unregister(array($this,'loadView'));
    }
}