<?php
    include_once 'libs/forms.php';
    include 'libs/queries.php';
    
    $queries = new Queries($link);
    $select_row = null;
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($validate)) $validate = null;
        if(!isset($id) || !$id) $id = null;        
        if(isset($table)) $save = $queries->save($_POST, $table, $validate,$id); else  $save = null; 
        
        if(is_array($save)){
            if($save['success'] == 1)
                header ('Location: /happycms/'.$table);
            //print_r($save);
        }
        
        $select_row = $_POST;
        
    } else if(isset($id) && $id!=false){        
        if(isset($table)) $select_sql = "SELECT * FROM ".$table." WHERE id = ".$id;
        else { echo "<p>Selecciona una tabla de la Base de Datos.</p>"; $select_sql = null; }
        
        if(isset($select_sql)){
            $result = mysql_query($select_sql,$link);
            $select_row = mysql_fetch_assoc($result);
        }
        
    }
        
?>
