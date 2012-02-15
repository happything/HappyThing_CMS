<?php

/*
 * Class: Modules
 * Type: Abstract
 * Function: Show a selected module file with $_GET variables
 */

abstract class Cs_Modules {    
    public function show($module,$get,$language,$link = null){
        $content = include_once("html/modules/".$module.".php");
        return substr($content,0,strlen($content)-1);
    }
}
?>
