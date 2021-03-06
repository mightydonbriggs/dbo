<?php

namespace DBO;

class Utilities
{
    /**
     * Accept a URL string, and return a properly formatted hyperlink. If the
     * $linkText parameter is passed it will be used for the text of the
     * hyperlink that is returned. Otherwise the URL itself will be used as the
     * link text
     * 
     * @param string $url URL to build hyperlink from
     * @param string|null $linkText text to be used as display text for link
     * @return string properly formatted hyperlink string
     */
    public static function makeHyperlink($url, $linkText = null) {
        
        $url = (string) trim($url);
        if(is_null($linkText)) {
            $linkText = $url;
        }
        
        $hyperlink = "<a href='" .$url ."'>" .$linkText ."</a>";
        return $hyperlink;
    }
    
    /**
     * Clear specified values from $_REQUEST parameter array. All parameters listed
     * in the $filedList parameter array will have their values set to an empty
     * string. If a parameter in $fieldList was not set in the $_REQUEST array, it
     * will be created, and it's value set to an empty string. This utility is 
     * usefull to be sure that the $_REQUEST array contains an empty element for each
     * data field in a table. This is used for creating new records.
     * 
     * @param array $fieldList
     * @return void
     */
    public static function clearRequestFields(array $fieldList) {
        $numFields = count($fieldList);
        for($i=0;  $i<$numFields; $i++) {
            $_REQUEST[$fieldList[$i]] = '';
        }
    }
    
    /**
     * Accept an array of error messages, and generate HTML to display them.
     * 
     * @param array $errors Array of error messages from validators
     * @return null
     */
    public static function genErrorHtml(array $errors) {
        $numErrors = count($errors);
        if($numErrors) {
            $messages = "Please fix the following errors:<br>\n";
            $messages .= implode("<br />\n", $errors);
            $messages .= "<br />\n";
            return $messages;
        } else {
            return null;
        }
    }
    
    /**
     * 
     * @param type $paramName
     * @param type $nulVal
     * @return boolean
     */
    public static function getParam($paramName, $nulVal = null) {
        if(isset($_REQUEST[$paramName]) && $_REQUEST[$paramName] != '')  {
            return trim($_REQUEST[$paramName]);
        } elseif (!is_null($nulVal)) {
            return $nulVal;
        } else {
            return false;
        }
    }
}

?>
