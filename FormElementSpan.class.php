<?php

namespace DBO;

class FormElementSpan extends  \DBO\AbstractFormElement
{
    protected $_type      = 'input';
    protected $_inputType = 'text';
    protected $_appendBr  = true;
    
    public function __construct($elementName) {
        parent::__construct($elementName);
    }
    
    
    public function getHtml() {
        
        $html = "     <span"
              . $this->_getName()
              . $this->_getClass()
              . $this->_getId()
              . ">\n"
              . $this->getValue()
              . "</span>\n";
        if($this->_appendBr) {
            $html .= "     <br />\n";
        }
        return $html;
    }    
}
?>
