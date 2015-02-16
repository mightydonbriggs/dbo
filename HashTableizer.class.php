<?php

namespace DBO;

class HashTableizer extends \DBO\Tableizer
{

    protected function _setRecordArray($recordArray) {

        if(!is_array($recordArray)) {
            throw new \Exception("Parameter 'recordArray' must be of type Array");
        }
        
        if(count($recordArray)) {
            $this->_records = $recordArray;
            $this->_numCols = 2;
            $this->_setFieldMeta();
        } else {
//            $this->_records = null;
            $this->_numCols = 0;
            $this->_fieldMeta = array();
        }
    }
    
    protected function _getTableBody() {
        $html = "";
        $numFields = count($this->_fieldMeta);
        for($i=0; $i<$numFields; $i++) {
            $html .= $this->_getTableRow($this->_fieldMeta[$i]);
        }
        $html = "  <tbody>\n" .$html ."  </tbody>\n";
        return $html;
    }
    
    protected function _getTableRow($rowRec) {
        $html = "";
        $html .= "  <tr>\n    <td>" .$rowRec['fieldName']
              ."</td>\n    <td>" .$rowRec['fieldValue'] ."</td>\n  </tr>\n";
        return $html;
    }
    
    protected function _setFieldMeta() {
        $i=0;
        $this->_fieldMeta = array();
        $this->_numCols = 2;
        foreach ($this->_records as $fieldname => $value) {
            $this->_fieldMeta[$i]['fieldNumber'] = $i;
            $this->_fieldMeta[$i]['fieldName'] = $fieldname;
            $this->_fieldMeta[$i]['fieldValue'] = $value;
            $this->_fieldMeta[$i]['showColHead'] = true;
            $this->_fieldMeta[$i]['showHeadClass'] = true;
            $this->_fieldMeta[$i]['colHeadClass'] = 'col_title_' .$fieldname;
            $this->_fieldMeta[$i]['showRowClass'] = true;
            $this->_fieldMeta[$i]['rowClass'] = 'col_' .$fieldname;
            $i++;
        }
    }

}
