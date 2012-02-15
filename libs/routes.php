<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Routes{
    var $url = "";
    var $routes = array();
    var $languages = "";
    
    function __construct($url,$routes,$languages){
        $this->url = $url;
        $this->routes = $routes;
        $this->languages = $languages;
    }
    
    function search(){
        //keys of the routes
        $keys = array_keys($this->routes);
        //Return value empty
        $return = array();          
        
        for($i=0; $i<count($keys); $i++){            
            $url_keys = array_keys($this->routes[$keys[$i]]);            
            for($j=0; $j<count($url_keys); $j++){
                //Language of the menu
                $language_keys = array_keys($this->routes[$keys[$i]]);
                //If url is equal of selected route
                if($this->routes[$keys[$i]][$language_keys[$j]] == $this->url) {                    
                    for($k=0; $k<count($language_keys);$k++){
                        if($language_keys[$j] == $this->languages) {                            
                            $return = array("route"=>$keys[$i],"get"=>null);
                            return $return;
                        }                        
                    }
                } else if(strrpos($this->routes[$keys[$i]][$language_keys[$j]],"*") !== false){                    
                    if(strpos($this->url,"/") !== false) $url_tmp = substr($this->url, 0, strrpos($this->url,"/"));
                    else $url_tmp = $this->url;
                    //$url_tmp = $this->url;                    
                    
                    $route_tmp = substr($this->routes[$keys[$i]][$language_keys[$j]], 0, strrpos($this->routes[$keys[$i]][$language_keys[$j]],"*")-1);                                        
                    $found = false;                    
                    $url_get_tmp = $url_tmp;
                    
                    //return $route_tmp;
                    
                    while(strpos($route_tmp,"*") !== false){                                                
                        if(substr_count($route_tmp, "*") >= 1) {
                            $route_tmp = substr($route_tmp, 0, strrpos($route_tmp,"*")-1);
                            $url_tmp = substr($url_tmp, 0, strpos($url_tmp,"/"));  
                           
                            if($route_tmp == $url_get_tmp) {
                                $url_tmp = $url_get_tmp;                                
                                $found = true;    
                                break;
                            }                            
                            $url_get_tmp = substr($url_get_tmp, 0, strpos($url_get_tmp,"/"));                                
                        }
                    }
                    
                    while(strpos($url_get_tmp,"/") !== false){                        
                        if(($url_get_tmp == $route_tmp) || ($route_tmp == $this->url)) {
                            $url_tmp = $url_get_tmp;
                            $found = true;
                            break;
                        }                        
                        $url_get_tmp = substr($url_get_tmp, 0,strrpos($url_get_tmp,"/"));
                    }
                    
                    if(($route_tmp == $url_tmp) || ($route_tmp == $this->url) || ($found)) {                             
                        for($k=0; $k<count($language_keys); $k++){
                            if($language_keys[$j] == $this->languages) { 
                                $get_str = str_replace($route_tmp, "", $this->url);
                                $get_str = substr($get_str, 1,  strlen($get_str));
                                
                                if(strpos($get_str, "/")!==false) $get_str = explode("/", $get_str);
                                
                                $return = array("route"=>$keys[$i],"get"=>$get_str);
                                
                                return $return;
                            }                        
                        }                    
                    }                     
                }
            }
        }
        
        return $return;
    }
}

?>
