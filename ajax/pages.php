<?php       
    include_once '../config/connection.php';
    if(isset($_POST["type"])){
        $type = $_POST["type"];
        
        if($type == "section-remove"){
            $id = $_POST["id"];
            $sql = "DELETE FROM sections WHERE id = ".$id;
            if(mysql_query($sql,$link)) {
                $sql = "DELETE FROM areas WHERE sections_id = ".$id;
                mysql_query($sql,$link);
                echo 1;                
            }
            else echo 0;
        } else if($type == "section-add"){
            $section = $_POST["section"];
            $section_id = $_POST["section_id"];
                        
            $sql = "INSERT INTO sections SET ";
            if($section_id != -1) $sql = "UPDATE sections SET ";            
                $sql .= "section = '".utf8_decode($section)."' ";            
            if($section_id != -1) $sql .= " WHERE id = ".$section_id;
            
            if(mysql_query($sql,$link)) {
                if($section_id == -1) echo mysql_insert_id($link);
                else echo $section_id;
            }
            else echo 0;            
        } else if($type == "section-save"){
            $title = $_POST["title"];
            $subtitle = $_POST["subtitle"];
            $content = $_POST["content"];            
            $section = $_POST["section"]; 
            $id = $_POST["id"];
            
            $sql = "INSERT INTO areas SET ";
            if($id!=0) $sql = "UPDATE areas SET ";
            $sql .= "title = '".  utf8_decode($title)."', subtitle = '".  utf8_decode($subtitle)."', content = '".  utf8_decode($content)."', sections_id = ".$section;
            if($id!=0) $sql .= " WHERE id = ".$id;
            
            if(mysql_query($sql,$link)) {
                if($id == 0) echo mysql_insert_id($link);
                else echo $id;
            }
            else echo 0;
        } else if($type == "area-remove"){
            $id = $_POST["id"];
            $sql = "DELETE FROM areas WHERE id = ".$id;
            if(mysql_query($sql,$link)) echo 1;
            else echo 0;
        } else if($type == "area-see"){
            $id = $_POST["id"];
            $sql = "SELECT title,subtitle,sections_id,content FROM areas WHERE id = ".$id;
            $result = mysql_query($sql,$link);
            $row = mysql_fetch_assoc($result);
            
            $new_row = array(); $new_row["title"] = utf8_encode(htmlentities($row["title"])); $new_row["subtitle"] = utf8_encode(htmlentities($row["subtitle"])); $new_row["content"] = utf8_encode(htmlentities($row["content"])); $new_row["sections_id"] = $row["sections_id"];
            
            echo utf8_encode(json_encode($new_row));
        }
    } else echo "We need the variable TYPE";
?>
