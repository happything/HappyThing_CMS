<?php
    if(isset($_POST["type"])){
        include_once '../config/connection.php';                
        $type = $_POST["type"]; $id = $_POST["id"]; $table = $_POST["table"];
        
        if($type == "enable") { $enable = $_POST["enable"]; if($enable == 0) $statement = "(enabled * -1)"; else $statement = $enable; $sql = "UPDATE ".$table." SET enabled = ".$statement." WHERE id IN (".$id.")"; if(mysql_query($sql,$link)) echo 1; else echo 0; } 
        else if($type == "remove") { $sql = "DELETE FROM ".$table." WHERE id IN (".$id.")"; if(mysql_query($sql,$link)) echo 1; else echo 0; }
        else if($type == "sort") { $ids = str_replace("row-", "", $id); $ids_arr = explode(",", $ids); for($i=0; $i<count($ids_arr); $i++){ $sql = "UPDATE ".$table." SET orden = ".($i+1)." WHERE id = ".$ids_arr[$i]; mysql_query($sql,$link); } }
        else if($type == "duplicate") { $fields = mysql_list_fields($connection["db_name"], $table, $link); $sql = "SHOW COLUMNS FROM ".$table; $result = mysql_query($sql,$link); $fields = ""; while($row = mysql_fetch_assoc($result)) { if($row["Field"]!="id") $fields .= $row["Field"].","; } $fields = substr($fields, 0,  strlen($fields)-1); $sql = "INSERT INTO ".$table."(".$fields.") (SELECT ".$fields." FROM ".$table." WHERE id = ".$id.")"; if(mysql_query($sql,$link)) echo 1; else echo 0; }
    } else echo "La variable 'type','id','table' es obligatoria.";
?>
