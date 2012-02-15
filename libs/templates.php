<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Templates {
    var $template = "";
    
    function __construct($template,$content,$menu,$title,$language,$link,$get){
        $this->template = $template;
        
        include_once("html/templates/".$template.".php");
    }
}
?>
