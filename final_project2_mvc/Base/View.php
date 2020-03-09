<?php

namespace Base;

class View
{
    private $templateDir;

    public function __construct($path = '')
    {
        $this->setTemplateDir($path);
    }

    public function setTemplateDir($path)
    {
        $this->templateDir = trim($path, DIRECTORY_SEPARATOR);
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function render($tplFileName = '')
    {
    	$ds = DIRECTORY_SEPARATOR;
        $tplPath = "{$this->templateDir}{$ds}$tplFileName";
        // var_dump($this->templateDir, $tplName, $tplFileName);die;
        ob_start(null, null,  PHP_OUTPUT_HANDLER_STDFLAGS );
        require $tplPath;
        return ob_get_clean();
    }
    
    // const PATH_TO_TEMPLATES = ROOT_DIR . '/views/templates';
	//     private $templateEngine;
	// 
	//     public function __construct()
	//     {
	//         $this->templateEngine = new Environment(new FilesystemLoader(self::PATH_TO_TEMPLATES), [
	//             'cache' => false,
	//         ]);
	//     }
	// 
	//     public function render($path, $data = [])
	//     {
	//         try {
	//             $path = (stristr($path, '.html')) ? $path : "$path.html";
	//             $result = $this->templateEngine->render($path, !empty($data) ? $data : []);
	//         } catch (Twig_Error $exception) {
	//             $result = $exception->getMessage();
	//         }
	//         return $result;
	//     }
}