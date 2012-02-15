<?php
    /* CLASS NAME: Compressor
     * Description: Compressor class using to finish the project and download it ready to be used.
     */

    class Compressor {
        
       /* Function Name: Compress
        * Description: Compress the selected project
        * Attributes: 
        *   Project_id: ID number of the project that will be created.
        *   Project_name: Name of the prohect that will be created.
        */
    
        function compress($project_id,$project_name){
            $project_name = $this->simplify_name($project_name);
            
            $destination_dir = "projects/".$project_id;            
            $source_dir = "temp_projects/".$project_id;
            
            $this->folders_exist($destination_dir);
            $this->folders_exist($source_dir);
            
            return exec("zip -r ".$destination_dir."/".$project_name.".zip ".$source_dir."/");
        }
        
        /* Function Name: Folders_exist
        * Description: Verify if folders exist, create folders and change permissions
        * Attributes: 
        *   Folder_dir: Dir of the folder that will be verified.
        */
        
        function folders_exist($folder_dir){
            //If there are slashes
            if(strpos($folder_dir,"/") !== false){
                //Convert the String to Array separating for Slashes
                $folder_dir_arr = explode("/",$folder_dir);
            } else {
                //If not, the folder dir keeps
                $folder_dir_arr = $folder_dir;
            }
            
            //If the folder dir is an Array
            if(is_array($folder_dir_arr)){
                //Create a temporal dir to concat the URL and verify if exists
                $folder_dir_tmp = "";
                
                for($i=0; $i<count($folder_dir_arr); $i++){
                    //Concat the temporal dir with the real
                    $folder_dir_tmp .= $folder_dir_arr[$i]."/";
                    //If not exist, create the new dir with all permissions
                    if(!is_dir($folder_dir_tmp)) {
                        //Create the folder
                        mkdir($folder_dir_tmp, 0777);
                    } 
                }
            } else {
                //If not is array means that the Dir is just one folder
                if(!is_dir($folder_dir_arr)) {
                    //If not exist, create the new dir with all permissions
                    mkdir($folder_dir_arr, 0777);
                }
            }            
        }
        
        /* Function Name: Simplify_name
        * Description: Convert the real name to a untrouble name
        * Attributes: 
        *   Name: Real name to convert.
        */
        
        function simplify_name($name){
            $name = str_replace("á", "a", $name);
            $name = str_replace("é", "e", $name);
            $name = str_replace("í", "i", $name);
            $name = str_replace("ó", "o", $name);
            $name = str_replace("ú", "u", $name);
            
            $name = str_replace("@", "", $name);
            $name = str_replace("/", "", $name);
            $name = str_replace("?", "", $name);
            $name = str_replace("\\", "", $name);
            $name = str_replace("\"", "", $name);
            $name = str_replace("'", "", $name);
            $name = str_replace("%", "", $name);
            $name = str_replace(" ", "", $name);
            $name = str_replace("=", "", $name);
            $name = str_replace("&", "", $name);
            
            return $name;
        }
        
    }
?>
