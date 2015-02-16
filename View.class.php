<?php

namespace DBO;

class View
{
    protected $_templateFile = null;
    protected $_data         = array();  
    public    $content       = null;


    public function __construct($template = null) {
        if(!is_null($template)) {
            $this->_setTemplate($template);
        }
    }
    
    public function __set($name, $value) {
        $this->_data[$name] = $value;
    }
    
    public function __get($propName) {
//print "PropName: $propName \n"        ;
        if(key_exists($propName, $this->_data)) {
//print "Found it!\n";            
            return $this->_data[$propName];
        } else {
            return null;
        }
    }
    
    public function setTemplate($templateFile) {
        $this->_setTemplate($templateFile);
        return $this;
    }
    
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
    public function render() {
        require($this->_templateFile);
        return $this;
    }
    
    protected function _setTemplate($template) {
        if($_SESSION['DBODEBUG']) { print "<pre>Template: " .$_SESSION['viewPath'] .DIRECTORY_SEPARATOR .$template ."</pre>"; }
        $templateFile = realpath($_SESSION['viewPath'] .DIRECTORY_SEPARATOR . $template);
        if($_SESSION['DBODEBUG']) { print "<pre>Realpath: " .$templateFile ."</pre>"; }
        
        if($templateFile === false) {
            throw new \Exception("Template file: $template could not be located");
        } elseif (!is_readable($templateFile)) {
            throw new \Exception("Template file: $template was found, but is not readable");            
        }
        
        $this->_templateFile = $templateFile;
    }
}