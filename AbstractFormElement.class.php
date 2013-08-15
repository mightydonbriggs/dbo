<?php

namespace DBO;

abstract class AbstractFormElement
{
    protected $_name        = null;
    protected $_id          = null;
    protected $_class       = null;
    protected $_label       = null;
    protected $_labelClass  = null;    
    protected $_type        = null;
    protected $_value       = null;
    protected $_appendBr    = false;
    protected $_index       = null;
    
    /**
     * 
     * @param string $name HTML Name attribute for this element
     */
    public function __construct($name) {
        $this->_name = $name;
    }
    
    public function setName($name) {
        $this->_name = $name;
        return $this;                
    }
    
    public function setId($id) {
        $this->_id = $id;
        return $this;                
    }
    
    public function setClass($class) {
        $this->_class = $class;
        return $this;                
    }
    
    public function setLabel($label) {
        $this->_label = $label;
        return $this;                
    }
    
    public function setLabelClass($labelClass) {
        $this->_labelClass = $labelClass;
        return $this;                
    }
    
    public function setValue($value) {
        $this->_value = $value;
    }
    

    
    public function setAppendBr($appendBr) {
        if($appendBr) {
            $this->_appendBr = true;
        } else {
            $this->_appendBr = false;
        }
    }
    
    public function setIndex($index) {
        $this->_index = $index;
    }
    
    public function getHtml() {
        
    }
    
    public function getIndex() {
        return $this->_index;
    }
    
    public function getElementName() {
        return $this->_name;
    }
    
    public function getValue() {
        return $this->_value;
    }
    
    protected function _getName() {
        return " name='" .$this->_name ."'";
    }
    
    protected function _getId() {
        return " id='" .$this->_id ."'";
    }
    
    protected function _getLabel() {
        $html = "     <label for='"
              . $this->_name ."'"
              . $this->_getlabelClass()
              . ">" .$this->_label
              . "</label>\n";
        return $html;
    }
    
    protected function _getlabelClass() {
        if(is_null($this->_labelClass)) {
            return " class='dbo_label'";
        } else {
            return " class='" .$this->_labelClass ."'";
        }
    }
    protected function _getClass() {
        if(!empty($this->_class)) {
            return " class='" .$this->_class ."'";
        } else {
            return "";
        }
    }
    
    protected function _getValue() {
        return " value='" .$this->_value  ."'";
    }
}
?>
