<?php
    class Table {
        private $table = "";
        private $url_key = "id";
        private $url = "";
        private $db_table = "";
        private $page;
        private $limit;
                
        function __construct() {
            
        }
        
        function create($db_table,$url,$url_key = "id",$page = null,$limit = null,$options = null){
            $this->url = $url;
            $this->url_key = $url_key;
            $this->db_table = $db_table;
            $this->page = $page;
            $this->limit = $limit;
            
            $table = "<table ";
            if(is_array($options)){
                if(isset($options["id"])) $table .= " id = '".$options["id"]."' "; else $table .= " id = 'recordset-table' ";                
                if(isset($options["class"])) $table .= " class = '".$options["class"]."' ";
            } else $table .= " id = 'recordset-table' ";
            $table .= ">";
            $this->table .= $table;
        }
        
        function fill($rows,$headers = null,$options = null,$link = null){
            if(count($rows)>0){
                $header_keys = array_keys($rows[0]);
                $table = "<thead><tr>";
                if(!isset($headers)){
                    $headers = $header_keys;
                } 
                
                //Header of the table
                $table .= "<th><input type='checkbox' id='check-all' /></th>";
                $table .= "<th>Num</th>";
                if(isset($options["image"])) $table .= "<th>Cover</th>";
                for($i=0; $i<count($headers); $i++){
                    if(!isset($options["description"])) $options["description"] = array();
                    if(!$this->multi_array_search($options["description"], $header_keys[$i]) && $header_keys[$i] != "enabled") $table .= "<th class='header-".$headers[$i]."'>".str_replace(array("-","_"), " ", ucwords($headers[$i]))."</th>";
                }
                $table .= "<th>Options</th>";
                $table .= "</tr></thead><tbody id='fbody'>";
                
                $num_row = 0;
                if(isset($this->page) && isset($this->limit) && is_numeric($this->page)) $num_row = ($this->page-1)*$this->limit;
                if(!isset($options)) $options = array();
                
                //Body of the table
                for($i=0; $i<count($rows); $i++){
                    //Creating row
                    $table .= "<tr id='row-".$rows[$i]["id"]."'>";
                        //Check column
                        $table .= "<td><input type='checkbox' class='single-check' id='check_".($i+1)."' value='".$rows[$i]["id"]."' /></td>";
                        //Num column
                        $table .= "<td id='cell-def-num-".($i+1)."'><a href='/".$this->url."/".$rows[$i][$this->url_key]."' class='cell-def-num-".($i+1)."'>".($num_row+1)."</a></td>";
                        //If the table going to show a cover image
                        if(isset($options["image"])){             
                            //Default cover vars
                            $cover_table = $this->db_table;
                            $cover_where_id = "id";
                            //Custome cover vars
                            if(isset($options["image"]["db_table"])) $cover_table = $options["image"]["db_table"];
                            if(isset($options["image"]["where_id"])) $cover_where_id = $options["image"]["where_id"];
                            
                            //Cover query
                            $sql = "SELECT id,ext FROM ".$cover_table." WHERE parent_id = ".$rows[$i][$cover_where_id]." ORDER BY orden LIMIT 1";                            
                            $cover_result = mysql_query($sql,$link);
                            $cover_row = mysql_fetch_assoc($cover_result);
                            //Cover image URL
                            $image_url = "img/".$cover_table."/".$rows[$i][$cover_where_id]."/def_".$cover_row["id"]."_img.".$cover_row["ext"];
                            //If doens't exist, show unknown image
                            if(!is_file($image_url)) $image_url = "img/non_image.jpg";
                            //Cover column
                            $table .= "<td><img class='cover-image' src='/".$image_url."' /></td>";
                        }
                        //Custom columns
                        for($j=0; $j<count($rows[$i]); $j++){
                            if(isset($options["description"])){
                                //Search if the column is in the description options
                                $exists = $this->multi_array_search($options["description"], $header_keys[$j]);
                            } else $exists = false;
                            //If the column is not ENABLED and is not exist in the description options
                            if(!$exists && $header_keys[$j] != "enabled") {
                                //Create the column
                                $table .= "<td class='indexColumn'>";                            
                                $table .= "<a href='/happycms/".$this->url."/".$rows[$i][$this->url_key]."' id='cell-".$header_keys[$j]."'>".utf8_encode($rows[$i][$header_keys[$j]]);
                            } 
                            
                            //If exist the current column in the description options ...
                            if(isset($options["description"][$header_keys[$j]])) {
                                // and is array
                                if(is_array($options["description"][$header_keys[$j]])){
                                    //Create a container of the description
                                    $table .= "<span class='description'>";
                                    //Read all the descriptions
                                    for($k=0; $k<count($options["description"][$header_keys[$j]]); $k++){                                        
                                        //Print a sub-string of the value (150)
                                        $table .= utf8_encode(substr($rows[$i][$options["description"][$header_keys[$j]][$k]], 0,150));                                        
                                        if(strlen($rows[$i][$options["description"][$header_keys[$j]][$k]]) > 150) $table .= "...";
                                        $table .= " · ";                                        
                                    }
                                    //Delete the last middle point
                                    $table = substr($table, 0, strlen($table)-3);
                                    //Close the description container
                                    $table .= "</span>";
                                }                                
                            }
                            //Ends the column
                            if(!$exists && $header_keys[$j] != "enabled") $table .= "</a></td>";
                        }
                        
                        $table .= "<td><a class='option-row' href='/happycms/".$this->url."/".$rows[$i][$this->url_key]."'>Edit</a>";
                        $table .= "<a class='option-row' href='' onclick='remove(".$rows[$i]["id"]."); return false;'>Delete</a>";
                        $table .= "<a class='option-row' href='' onclick='duplicate(".$rows[$i]["id"]."); return false;'>Duplicate</a>";
                        if(isset($rows[$i]["enabled"])) {
                            if($rows[$i]["enabled"]==1) { $enabled_value = -1; $enabled_class = "Enabled"; }
                            else if($rows[$i]["enabled"]==-1) { $enabled_value = 1; $enabled_class = "Disabled"; }
                        } else {
                            $enabled_value = 0;
                            $enabled_class = "Enabled-Disabled";
                        }                        
                        $table .= "<a href='' id='enabled-".$rows[$i]["id"]."' onclick='enable(".$rows[$i]["id"].",".$enabled_value."); return false;' class='".strtolower($enabled_class)."'>".$enabled_class."</a></td>";
                    $table .= "</tr>";
                    $num_row++;
                }
                
                $this->table .= $table."</tbody>";    
            } else {
                $this->table .= "<thead><tr><th>Registros</th></tr></thead><tbody><tr><td>No hay registros en la tabla.</td></tr></tbody>";
            }
        }
        
        function end(){
            return $this->table .= "</table>";
        }
        
        function multi_array_search($array,$value){
            if(is_array($array)){
                foreach ($array as $sub_array) { if(array_search($value, $sub_array) !== false) return true; }
            } else return false;            
        }
    }
?>
