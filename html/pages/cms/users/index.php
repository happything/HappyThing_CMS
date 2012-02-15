<?php        
    $location_url = "users/user";    
    $description = "In this section you may create the users you want wherever you want.\n Don't forget create them with love!";
    $limit = 10;
    $page = 1;
    
    $options = array(                
        "new"=>"user"
    );
    
    include_once 'modules/pagination-set.php';
    
    $read_options = array(
        "fields"=>array("users.name,lastname,users.id,user_types.name as User_Type","user","users.enabled", "email"),        
        "join"=>array(
            "user_types"=>array("id","user_types_id")            
        ),
        "order"=>"users.orden",
        "limit"=> $limit_statement
    );
    $rows_options = array( 
        "description"=>array("name"=>array("User_Type","email")),
        //"image"=>array("db_table"=>"usuarios_images")
    );
    
    //$headers = array("Nombre","Id","Usuario","Options");    
    $db_table = "users";        
    
    include_once 'modules/recordset.php';
?>    