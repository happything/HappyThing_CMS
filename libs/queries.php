<?php     
    class Queries {
        private $link;
        private $sql;
        
        function __construct($link) {
            $this->link = $link;
        }
        
        /* Function Name: Save
        * Description: Make an INSERT/UPDATE query
        * Attributes: 
        *   Post    : Array with the values to save.
        *   Table   : The table to insert. 
        *   Validate: Array with spesific validate options.
        *             IGNORE,ENCRYPT,TYPE   
        *   Id      : Id to update        
        */
        function save($post,$table,$validate,$id = null){
            //If the post is an array
            if(is_array($post)){
                //Get all the keys
                $post_keys = array_keys($post);
                //Init sql
                $sql = "";
                //Return variable
                $return = array();
                
                //If id is not null, the query will be an UPDATE. Else, INSERT INTO
                if(isset($id)) $sql = "UPDATE "; else $sql = "INSERT INTO ";       
                //Table name
                $sql .= $table." SET ";

                //Query fields loop   
                for($i=0; $i<count($post); $i++){
                    //If key is in the validate var, include in the query
                    if(!isset($validate[$post_keys[$i]]["ignore"])){
                        
                        $post_value = trim(htmlentities (utf8_decode($post[$post_keys[$i]])));
                                                
                        $sql .= $post_keys[$i]." = ";
                        
                        if(isset($validate[$post_keys[$i]]["encrypt"])) $post_value = substr(sha1($post_value), 0,13);                        
                        
                        if(isset($validate[$post_keys[$i]]["type"])) {
                            
                            if($validate[$post_keys[$i]]["type"] == "string") $sql .= "'".$post_value."'";
                            else if($validate[$post_keys[$i]]["type"] == "number") $sql .= $post_value;
                            else if($validate[$post_keys[$i]]["type"] == "boolean") $sql .= $post_value;
                            else if($validate[$post_keys[$i]]["type"] == "checkbox") $sql .= "1";
                            else if($validate[$post_keys[$i]]["type"] == "radio") $sql .= $post_value;
                            else if($validate[$post_keys[$i]]["type"] == "date") $sql .= "'".$post_value."'";
                            else if($validate[$post_keys[$i]]["type"] == "text") $sql .= "'".$post_value."'";
                            
                        } else {
                            $sql .= "'".$post_value."'";
                        }
                        
                        $sql .= ", ";                        
                    }                    
                }    
                
                //Delete the last comma
                $sql = substr($sql, 0, strlen($sql)-2);
                if(isset($id)) $sql .= " WHERE id = ".$id;
                
                //If the query is successful
                if(mysql_query($sql,$this->link)){
                    $return["success"] = 1;
                    $return["insert_id"] = mysql_insert_id($this->link);
                    $return["error"] = 0;
                    $return["query"] = $sql;
                    
                    //Creating a PO file using the selected fields                    
                    /*$validate_keys = array_keys($validate);
                    for($i=0; $i<count($validate_keys); $i++){
                        if(isset($validate[$validate_keys[$i]]["locale"])){
                            $value = $post[$validate_keys[$i]];
                            //Here PO code start
                                
                            //Here PO code finish
                        }
                    }*/
                } else {
                    $return["success"] = 0;
                    $return["insert_id"] = -1;
                    $return["error"] = mysql_error($this->link);
                    $return["query"] = $sql;
                }
                
                return $return;
            } else {
                //If the post is not an array
                return -1;
            }           
        }
        
        /* Function Name: Read
        * Description: Make an SELECT query
        * Attributes:         
        *   Table   : The table to insert. 
        *   Options : Array with spesific options.
        *             FIELDS,WHERE,JOIN,ORDER,LIMIT 
        *   Example:
        *   $options = array(
                "fields"=>array("id,name,user"),
                "where"=>array(
                    array("id","1","AND"),                    
                    array("last_name","=","'Bojorquez'","AND"),
                    array("user","'Yorsh'")            
                ),
                "join"=>array(
                    "user_type"=>array("id","user_type_id")            
                )
            );    
        */
        function read($table,$options = null){   
            //Init variables 
            $return = array();
            $sql = "SELECT ";
            
            //If the options var is an array
            if(is_array($options)){
                //Option fields is the columns of the database who gonna be showed    
                if(isset($options["fields"])){
                    for($i=0; $i<count($options["fields"]); $i++){
                        $sql .= $options["fields"][$i].",";
                    }
                    $sql = substr($sql, 0,  strlen($sql)-1);
                } else {
                    //If not exist, show all
                    $sql .= "*";
                }
                
                //Using the selected table
                $sql .= " FROM ".$table;
                
                //Argument JOIN
                if(isset($options["join"])){
                    $join_keys = array_keys($options["join"]);
                    for($i= 0; $i<count($options["join"]); $i++){                        
                        if(count($options["join"][$join_keys[$i]]) == 2){
                            $sql .= " LEFT JOIN ".$join_keys[$i]." ON ".$join_keys[$i].".".$options["join"][$join_keys[$i]][0]."=".$options["join"][$join_keys[$i]][1];
                        }                        
                    }                    
                }
                //Argument WHERE
                if(isset($options["where"])){
                    $sql .= " WHERE ";
                    //If is an array
                    if(is_array($options["where"])){
                        for($i=0; $i<count($options["where"]); $i++){
                            //When are 2 indexes, default is an EQUAL statement
                            if(count($options["where"][$i])==2){
                                $sql .= $options["where"][$i][0]." = ".$options["where"][$i][1]." ";                                                                
                            } else if(count($options["where"][$i])==3){
                                //When are 3 indexes, it can be an EQUAL statement or MULTIPLE WHERE
                                if($options["where"][$i][1] == "!=") $sql .= $options["where"][$i][0]."!=".$options["where"][$i][2]." ";
                                else $sql .= $options["where"][$i][0]."=".$options["where"][$i][1]." ".$options["where"][$i][2]." ";
                            } else if(count($options["where"][$i])>=4){
                                //When are 4 indexes, it has an spesific statements
                                $sql .= $options["where"][$i][0]." ".$options["where"][$i][1]." ".$options["where"][$i][2]." ".$options["where"][$i][3]." ";
                            }                            
                        }
                    }
                }
                //Argument ORDER
                if(isset($options["order"])){
                    $sql .= " ORDER BY ".$options["order"];
                }
                //Argument LIMIT
                if(isset($options["limit"])){
                    $sql .= " LIMIT ".$options["limit"];
                }
            } else {
                //If is not an array, it is a simple SELECT query
                $sql .= "* FROM ".$table;
            }
            
            $result = mysql_query($sql,$this->link);
            if($result !== false){
                $return["success"] = 1;
                $return["result"] = $result;
                $return["query"] = $sql;
                $return["error"] = 0;
            } else {
                $return["success"] = 0;
                $return["result"] = $result;
                $return["query"] = $sql;
                $return["error"] = mysql_error($this->link);
            }
            
            return $return;            
        }
        
        function query($sql){            
            return mysql_query($sql,$link);
        }        
        
    }
?>
