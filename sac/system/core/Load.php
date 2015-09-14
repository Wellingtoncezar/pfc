<?php
/**
* @author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');

class Load extends conn{
    private static $data = array();
    protected $load;
    protected $include;
    private $instance = 'instance';
    public function __construct(){
        parent::__construct();
        $this->load = $this;
        $this->_autoloadComplement();
    }

    /**
     *  Autoload das classes 
     * @access private
     * 
     */
    private function _autoloadComplement(){
        require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'autoload.php');
        if(!empty($autoload['libraries']))
        {
            foreach ($autoload['libraries'] as $loadLibrary){
                $this->load->library($loadLibrary);
            }
        }

        if(!empty($autoload['model']))
        {
            foreach ($autoload['model'] as $loadModel){
                $this->load->library($loadModel);
            }
        }
    }



    public function __set($name , $value ){
        self::$data[$name] = $value;
    }

    public function __get($name)
    {   
        if (array_key_exists($name, self::$data)) {
            return self::$data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }


    /**  As of PHP 5.1.0  */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }


    private function _isloaded($class)
    {
        if (array_key_exists($class, self::$data)) {
            return true;
        }else
            return false;
    }
    /*
    *Verifica se o diretório existe
    */
    public function checkDir($dir){
        if(is_dir(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.$dir))
            return true;
        else
            return false;
    }


    /*LOADCONTROLLER*/
    public function controller($filename, $autoExec = true)
    {
        $filename = str_replace('\\', '/', $filename);
        $name = explode('/',rtrim($filename));
        $name = end($name);
        spl_autoload_register(array($this,'controller'));
        $filename = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.$filename.'.controller.php';
        if(!$this->_isloaded($name))
        {
            if(file_exists($filename)){
                require_once(str_replace('\\', '/', $filename));
                if($autoExec == true)
                    $this->$name = new $name();
                return true;
            }else
                return false;
                //die('Class controller '.$name .' not found');
        }
    }



    /*LOADLIBRARY*/
    public function library($filename, $parameters = null, $autoExec = true)
    {
        $filename = str_replace('\\', '/', $filename);
        $name = explode('/',rtrim($filename));
        $name = end($name);

        spl_autoload_register(array($this,'library'));
        $file = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$filename.'.library.php';
        $file2 = BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$filename.'.library.php';
        if(!$this->_isloaded($name))
        {
            if(file_exists($file)){
                require_once(str_replace('\\', '/', $file));
                if($autoExec == true)
                    $this->$name = new $name($parameters);
                return true;
            }else
            if(file_exists($file2)){
                require_once(str_replace('\\', '/', $file2));
                if($autoExec == true)
                    $this->$name = new $name($parameters);
                return true;
            }else{
                return false;
            }
        }else
            return false;
    }



    /*LOADMODEL*/
    public function model($filename , $parameters = null, $autoExec = true)
    {
        $filename = str_replace('\\', '/', $filename);
        $name = explode('/',rtrim($filename));
        $name = end($name);
        spl_autoload_register(array($this,'model'));
        $file = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.$filename.'.model.php';
        
        if(!$this->_isloaded($name))
        {
            if(file_exists($file)){
                require_once(str_replace('\\', '/', $file));
                if($autoExec == true)
                    $this->$name = new $name($parameters);
                return true;
            }else{
                return false;
            }
        }else
            return false;
    }

    /*LOADMODEL*/
    public function dao($filename , $parameters = null, $autoExec = true)
    {
        $filename = str_replace('\\', '/', $filename);
        $name = explode('/',rtrim($filename));
        $name = end($name);
        spl_autoload_register(array($this,'model'));
        $file = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.$filename.'.dao.php';
        
        if(!$this->_isloaded($name))
        {
            if(file_exists($file)){
                require_once(str_replace('\\', '/', $file));
                if($autoExec == true)
                    $this->$name = new $name($parameters);
                return true;
            }else{
                return false;
            }
        }else
            return false;
    }


    /*LOADVIEW*/
    public function view($filename, $param = array())
    {
        spl_autoload_register(array($this,'view'));
        $filename = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.VIEWS.DIRECTORY_SEPARATOR.$filename.'.phtml';
        if(file_exists($filename)){
            $instance = '';
            $instance =& get_instance();
            //extrai as variaveis

            if(is_array($param) && !empty($param)){
                extract($param);
            }
            //$titulo = 'testeee';
      
            require_once(str_replace('\\', '/', $filename));
            return true;
        }else{
            $_message_error = "<p><strong>DESCULPE-NOS</strong></p>
                                <p>A página que você procura não foi encontrada.</p>
                                <p>Verifique o endereço digitado ou tente novamente mais tarde.</p>";
            require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.ERRORDIR.DIRECTORY_SEPARATOR.'error_404.php');
            //return false;
        }
    }
}