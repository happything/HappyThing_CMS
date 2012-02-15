<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class URL{
    private $url = "";
    private $url_arr = array();
    
    function __construct($url) {
        $this->url = $url;
    }
    
    /*
     * Method: Read()
     * Function: Read the url and separate the string converting it in Array
     * Parameters: None
     * Return: URL converted in Array
     * Return Value: Array
     */
    function read(){
        if($this->url != ""){
            if($this->url[strlen($this->url)-1] == "/") {
                $this->url = substr($this->url, 0,(strlen($this->url)-1));
            }
            $this->url_arr = explode("/", $this->url);
        } else {
            $this->url_arr[0] = "";
        }
        
        return $this->url_arr;
    }
}
?>
