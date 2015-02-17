<?php

namespace DBO;  //Namespace for Don! Briggs Objects

/**
 * Display an array record set as a nicely formatted HTML table. Allows setting
 * of CSS classes for various elements
 */
class Tableizer {
    
    private $_html        = null;
    private $_records     = null;
    private $_numCols     = null;
    private $_title       = null;
    private $_tableClass  = null;
    private $_tableId     = null;
    private $_tableTitleClass = null;
    private $_fieldMeta   = null;


    public function __construct($recordArray = null, $transform = null) {
        if(!is_null($recordArray)) {
            $this->_setRecordArray($recordArray, $transform);
        }
    }
    
    public function render() {
        $this->getHTML();
        echo $this->_html;
    }
    
    public function getHTML() {
        $html = "";
        $head = $this->_getTableHead();        
        $body = $this->_getTableBody();
        $tableClass = $this->_getTableClass();
        $html = "\n<table$tableClass>\n" . $head .$body ."</table>\n";
        $this->_html = $html;
        return $this->_html;
    }
    
    public function setTableClass($class) {
        $this->_tableClass = $class;
        return $this;
    }
    
    public function setTableTitleClass($class) {
        $this->_tableTitleClass = $class;
        return $this;
    }
    
    public function setTitle($title) {
        $this->_title = $title;
        return $this;
    }
    
    
    public function setTableId($id) {
        $this->_tableId= $id;
        return $this;
    }
    
    public function setColumnTitles(array $columnTitles) {
        
        $columnNumber = null;
        
        foreach($columnTitles as $columnName => $title) {
        
            if(is_numeric($columnName)) {
                //Field was specified by number
                if($columnName < $this->_numCols) {
                    $columnNumber = $columnName;
                } else {
                    throw new \Exception("Column Number is out of bounds");
                }
            } else {
               //Field was specified by name
               for($i=0; $i < $this->_numCols; $i++) {
                   if($this->_fieldMeta[$i]['fieldName'] == $columnName) {
                       $columnNumber = $i;
                       break;
                   }
               }
            }
            
            if(is_null($columnNumber)) {
                throw new \Exception("Could not find column: $columnName");
            }
            
            $this->_fieldMeta[$columnNumber]['colTitle'] = trim(htmlentities($title));
        }
        return $this;
    }
    
    protected function _setFieldMeta() {
        if(is_array($this->_records)) {
            $rec = $this->_records[0];    //Grab first record out of list
            $i=0;
            $this->_fieldMeta = array();
            foreach ($rec as $fieldname => $value) {
                $this->_fieldMeta[$i]['fieldNumber'] = $i;
                $this->_fieldMeta[$i]['fieldName'] = $fieldname;
                $this->_fieldMeta[$i]['showColHead'] = true;
                $this->_fieldMeta[$i]['showHeadClass'] = true;
                $this->_fieldMeta[$i]['colHeadClass'] = 'col_title';
                $this->_fieldMeta[$i]['colHeadId'] = 'col_title_' .$fieldname;
                $this->_fieldMeta[$i]['showRowClass'] = true;
                $this->_fieldMeta[$i]['rowClass'] = 'col_' .$fieldname;
                $i++;
            }
        }
    }
    
    
    /**
     * Transforms an associative array ($key => $value) into a record array. 
     
     * $recordArray array Associative array of records
     * $transformFields array List of fieldnames to be used
     */
    
    public static function transform($recordArray, array $transformFields) {
        $numRecs = count($recordArray);
        $aryTransform = array();
        $i = 0;
        foreach ($recordArray as $field1 => $field2) {
            $aryTransform[$i][$transformFields[0]] = $field1;                
            $aryTransform[$i][$transformFields[1]] = $field2;
            $i++;
        }
        
        return $aryTransform;
    }
    
    protected function _getColumnTitles() {
        $html = "    <tr>\n";
        for($i=0; $i<$this->_numCols; $i++) {
            $colData = $this->_fieldMeta[$i];
            if($colData['showColHead'] == true) {
                $classHTML = $this->_getColumnTitleClass($colData);
                $idHTML = $this->_getColumnTitleId($colData);
                if(key_exists('colTitle', $colData)) {
                    $html .= "      <th$classHTML$idHTML>" .trim(htmlspecialchars($colData['colTitle'])) ."</th>\n";
                } else {
                    $html .= "      <th$classHTML$idHTML>" .trim(htmlspecialchars($colData['fieldName'])) ."</th>\n";                    
                }
            } else {
                $html .= "&nbsp;";
            }
        }
        $html .= "    </tr>\n";
        return $html;
    }

    protected function _getTableClass() {
        
        if(!empty($this->_tableClass)) {
            return " class='" .$this->_tableClass ."'";
        } else {
            return '';
        }
    }
    
    protected function _getTableTitleClass() {
        
        if(!empty($this->_tableTitleClass)) {
            return " class='" .$this->_tableTitleClass ."'";
        } else {
            return '';
        }
    }
    
    protected function _getColumnTitleClass(array $fieldMeta) {
        $html = '';
        if($fieldMeta['showHeadClass'] == true) {
            $html = " class='" .$fieldMeta['colHeadClass'] ."'";
        }
        return $html;
    }
    
    protected function _getColumnTitleId(array $fieldMeta) {
        $html = '';
        if($fieldMeta['colHeadId'] == true) {
            $html = " id='" .$fieldMeta['colHeadId'] ."'";
        }
        return $html;
    }
    
    protected function _getColumnClass(array $fieldMeta) {
        $html = '';
        if($fieldMeta['showRowClass'] == true) {
            $html = " class='" .$fieldMeta['rowClass'] ."'";
        }
        return $html;
    }
    
    protected function _getTableHead() {
      
        $tableTitleClass = $this->_getTableTitleClass();
        $html = "    <tr><th"
              .  $tableTitleClass 
              .  " colspan='" .$this->_numCols ."'>"
              . $this->_title ."</th></tr>\n";
        $html = "  <thead>\n" .$html ."  </thead>\n";
        return $html;        
    }
    
    protected function _getTableBody() {
        $numRows = count($this->_records);
        if(!$numRows) {
            $html ="<tr><td>[No Records in Dataset]</td><tr>";
        } else {
            $html = "";
            $html .= $this->_getColumnTitles();
            for($i=0; $i<$numRows; $i++) {
                $html .=$this->_getTableRow($this->_records[$i]);
            }
            $html = "  <tbody>\n" .$html ."  </tbody>\n";
            return $html;
        }
    }
    
    protected function _getTableRow($rowRec) {

        $html = "";
        $i=0;
        foreach($rowRec as $colName => $colVal) {
            $fieldMeta = $this->_fieldMeta[$i];
            $classHTML = $this->_getColumnClass($fieldMeta);
            $html .= "      <td$classHTML>" .$colVal ."</td>\n";
            $i++;
        }
        $html = "    <tr>\n" .$html ."    </tr>\n";
        return $html;
    }
    
    protected function _setRecordArray($recordArray, $transform = false) {

        if(!is_array($recordArray)) {
            throw new \Exception("Parameter 'recordArray' must be of type Array");
        }
                
        if(count($recordArray)) {
            //We were passed a record array with records. Process it
            if(is_array($transform)) {
                $recordArray = static::transform($recordArray, $transform);
            }
            $this->_records = $recordArray;
            $this->_numCols = count($recordArray[0]);
            $this->_setFieldMeta();
        } else {
            //We were passed a record array with no records. Handle gracefully
            $this->_records = null;
            $this->_numCols = 0;
            $this->_fieldMeta = array();
        }
    }
    


}

?>
