<?php
    /*
     * CLASS NAME: Paginator
     * Attrs:
     *  Table - Which table goint to paginate
     *  Options - Option array where going to be all options of the query
     *  Sql - Builded query
     * 
     * 
     * 
     */

    class Paginator {
        private $total;
        private $table;
        private $options;
        private $sql;        
        private $link;
        private $type;     
        private $uri_page;
        
        function __construct($table = null,$total,$link,$uri_page=null,$options = null,$type = "normal",$sql = null) {
            $this->total = $total;
            $this->table = $table;
            $this->options = $options;
            $this->sql = $sql;     
            $this->link = $link;     
            $this->type = $type;  
            $this->uri_page = $uri_page;
        }
        
        function paginate($page = 1){
            //return query variable
            $sql = "";
            //If the class going to build the query
            if(!isset($this->sql)){
                //Building query
                $sql = "SELECT count(".$this->table.".id) FROM ".$this->table." ";
                //If exist options in the query and is array
                if(isset($this->options) && is_array($this->options)){
                    //Keys of the options
                    $keys = array_keys($this->options);
                    //Reading options
                    for($i=0; $i<count($keys); $i++){
                        //If the key is array
                        if(is_array(($this->options[$keys[$i]]))){
                            //Continue with the query
                            $sql .= $keys[$i]." ";
                            //Obtaining all the options
                            for($j=0; $j<count($this->options[$keys[$i]]); $j++){
                                //Option key value that represents the column
                                $option_key = array_keys($this->options[$keys[$i]]);
                                //Continue with the query
                                $sql .= $option_key[$j]." ".$this->options[$keys[$i]][$option_key[$j]]." ";
                            }
                        }
                    }
                } 
            //If the query was builded
            } else if(isset($this->sql)){
                //Finishing the query
                $sql = $this->sql;
            }
            
            //Mysql functions starts -------------------------------------------
                $result = mysql_query($sql,$this->link);
                $row = mysql_fetch_array($result);
            //Mysql functions ends ---------------------------------------------
                
            //Total registers on the table    
            $count_regs = $row[0];
            //Total pages
            $count_pages = ceil($count_regs / $this->total);
            
            //Show the list of pages            
            return $this->show($page, $count_pages);
            
            //return $sql;
        }
        
        function show($page,$count_pages){
            $onclick = '';            
            $return = "<div class='pagination'><ul>";
            
                if($this->type == "ajax") $onclick = "paginate(\"".$this->table."\",1); return false;";
                $return .= "<li><a href='".$this->uri_page."/1' onclick='".$onclick."' class='pag_first'>First</a></li>";
            
                    $before_page = 1;
                    if($page > 1) $before_page = $page - 1;
                
                $onclick = '';
                if($this->type == "ajax") $onclick = "paginate(\"".$this->table."\",".$before_page."); return false;";
                
                $return .= "<li class='prev'><a href='".$this->uri_page."/".$before_page."' onclick='".$onclick."' class='pag_before'>Before</a></li>";

                for($i=1; $i<=$count_pages; $i++){
                    if($this->type == "ajax") $onclick = "paginate(\"".$this->table."\",".$i."); return false;";
                    $class = "";
                    if($page == $i) $class = 'active';
                    $return .= "<li class='".$class."'><a href='".$this->uri_page."/".$i."' onclick='".$onclick."' class='pag_nums'>".$i."</a></li>";
                }

                $next_page = $count_pages;
                if($page < $count_pages) $next_page = $page + 1;
                
                if($this->type == "ajax") $onclick = "paginate(\"".$this->table."\",".$next_page."); return false;";
                $return .= "<li><a href='".$this->uri_page."/".$next_page."' onclick='".$onclick."' class='pag_next'>Next</a></li>";
                
                if($this->type == "ajax") $onclick = "paginate(\"".$this->table."\",".$count_pages."); return false;";
                $return .= "<li class='next'><a href='".$this->uri_page."/".$count_pages."' onclick='".$onclick."' class='pag_last'>Last</a></li>";

                $return .= "</ul></div>";
                
                //If pagination use AJAX, import the paginator.js Javascript Lib.
                if($this->type == "ajax") $return .= "<script src='/js/paginator.js'></script>";
            
            return $return;
        }
        
    }
?>
