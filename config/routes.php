<?php

/*
 Example:
 * 
 *  "file's url"                "link's ref"
 *  "comida/single"=>array('spa'=>'comida/*'),          
 */

    $routes = array(                        
        "cms/login-processing"=>array("spa"=>"happycms/login/processing"),
        "cms/login"=>array("spa"=>"happycms/login/*"),
        "cms/logout"=>array("spa"=>"happycms/logout"),
        "cms/pages"=>array("spa"=>"happycms/pages"),
        "cms/media" => array("spa"=>"happycms/media"),                
        "cms/users/user"=>array("spa"=>"happycms/users/user/*"),
        "cms/users/index"=>array("spa"=>"happycms/users/*"),
        "cms/no-ie" => array("spa" => "happycms/no-ie")
    );
?>
