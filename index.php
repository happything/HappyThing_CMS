<?php
session_start();
header ('Content-type: text/html; charset=utf-8');
$_SESSION["language"] = "spa";
if(session_is_registered("language")) $language = $_SESSION["language"];

//Import lib files start -----------------------------

    include_once("config/routes.php");
    include_once("config/connection.php");
    include_once("config/menu.php");
    include_once("libs/url.php");
    include_once("libs/routes.php");
    include_once("libs/templates.php");
    include_once("libs/menu.php");
    include_once("libs/modules.php");
    include_once("libs/text.php");

//Import lib files end --------------------------------

$url_str = "";
$route = null; 
$get = null;
$uri_page = $_SERVER['REQUEST_URI'];

// If the URL is not empty, use the STR_URL variable to user the Class URL with its parameter URL
if(isset($_GET["url"])) $url_str = $_GET["url"];

$url = new URL($url_str);
$url_arr = $url->read();    
if($url_str != "" && $url_str[strlen($url_str)-1] == "/") $url_str = substr ($url_str, 0,strlen($url_str)-1); 
    
$routes = new Routes($url_str, $routes,$language);
//print_r($route_arr = $routes->search());
$route_arr = $routes->search();

if(isset($route_arr["route"])){
    $route = $route_arr["route"];
    $get = $route_arr["get"];
    
    if(!is_array($get)){
        if(strpos($get, "/")) $get = explode("/", $get);        
    }    
}

$uri_page = str_replace($get, "", $uri_page);
if($uri_page[strlen($uri_page)-1]=="/") $uri_page = substr ($uri_page, 0,  strlen ($uri_page)-1);

if($route || $url_str == ""){
    if($url_str == "") $route = "index";
    
    $title = "";
    
    if(is_file("html/controller/".$route.".php")) include_once("html/controller/".$route.".php");

    //Include the content area --------------------------------
    ob_start();
        include_once("html/pages/".$route.".php");
    $content = ob_get_clean();
    //Finish include the content area -------------------------
    
    $menu_obj = new Menu($menus,$language,$url_arr[0]);

    //Include the template area --------------------------------
    ob_start();    
        if(!isset($template)) $template = "default";        
        $templates = new Templates($template,$content,$menu_obj,$title,$language,$link,$get);        
    $html_content = ob_get_clean();
    //Finish include the template area -------------------------

    echo $html_content; //Show the resultant web page    
} else {    
    //Section doesn't exist
    include_once 'html/pages/404.html';
}

?>
