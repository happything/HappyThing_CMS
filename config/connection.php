<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$connection = array(
    "server"=>"localhost",
    "username"=>"root",
    "password"=>"Scartissue",
    "db_name"=>"cms_test"
);

$link = mysql_connect($connection["server"], $connection["username"], $connection["password"]);
mysql_select_db($connection["db_name"]);

?>
