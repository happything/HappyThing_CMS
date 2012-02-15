<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Menu{
    var $menu = array();
    var $language = "";
    var $section = "";    
    
    function __construct($menu,$language,$section){
        $this->menu = $menu;
        $this->language = $language;
        $this->section = $section;        
    }
    
    function show($menu){
        $menu_arr = array();
        if(array_key_exists($menu, $this->menu) && is_array($this->menu[$menu])){            
            for($i=0; $i<count($this->menu[$menu]);$i++){
                if(!is_array($this->menu[$menu][$i][$this->language])){
                    //The menu is not in this language
                    return false;
                }
                array_push($menu_arr,$this->menu[$menu][$i][$this->language]);                
            }
        } else {
            return false;
            //Menu doesn't exist
        }
        return $this->transform($menu_arr);        
    }
    
    function transform($menu_arr){
        $html = "<ul class='group'>";
        for($i=0; $i<count($menu_arr);$i++){
            $key = array_keys($menu_arr[$i]);
            if(is_array($menu_arr[$i][$key[0]])){
                $html .= "<li class='menu_element list_".$key[0]."'><a href='' onclick='return false;'>".$key[0]."</a><ul class='sub_menu_".$key[0]."'>";
                for($j=0; $j<count($menu_arr[$i][$key[0]]); $j++){
                    $sub_key = array_keys($menu_arr[$i][$key[0]]);
                    $html .= "<li class='menu_subelement sublist_".$this->class_format($sub_key[$j])."'><a href='".$this->class_format(utf8_encode($menu_arr[$i][$key[0]][$sub_key[$j]]))."'>".$sub_key[$j]."</a></li>";
                }
                $html .= "</ul></li>";    
            } else {
                //$this->section;
                $menu_item = str_replace(" ", "-", $key[0]);                
                $selected = "";                
                if($this->class_format(strtolower($this->section)) == $this->class_format(strtolower($menu_item))) $selected = "selected";                
                else if($this->section == "" && $i==0) $selected = "selected";
                $html .= "<li class='menu_element list_".$this->class_format(strtolower($key[0]))." ".$selected."'><a href='".$this->class_format(strtolower(utf8_encode($menu_arr[$i][$key[0]])))."'>".$key[0]."</a></li>";                
            }            
        }
        $html .= "</ul>";
        
        return $html;
    }
    
    function class_format($class){
        
        $signs = array(".","#","!","@","$","%","&","¬","(",")","=",":",";","?","¿");
        $class = str_replace($signs, "", $class);
        $class = str_replace(" ","-",$class);
        $class = str_replace("á","a",$class);
        $class = str_replace("é","e",$class);
        $class = str_replace("í","i",$class);
        $class = str_replace("ó","o",$class);
        $class = str_replace("ú","u",$class);
        $class = str_replace("Á","a",$class);
        $class = str_replace("É","e",$class);
        $class = str_replace("Í","i",$class);
        $class = str_replace("Ó","0",$class);
        $class = str_replace("Ú","u",$class);
        
        return $class;
    }
}
?>
