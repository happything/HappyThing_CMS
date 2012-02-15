<?php        
    $location_url = "editar/comida";    
    
    /*$options = array(                
        "new"=>"/muestras/paso-a-paso",
        "play"=>array("onclick"=>"play"),
        "show"=>array("href"=>"alta.php")
    );*/
    
    $limit = 3;
    $page = 1;
    $limit_statement = null;
    if(isset($get) && !empty ($get)) $page = $get;
    if(is_numeric($page)) {
        $start = ($page-1) * $limit;
        $limit_statement = $start.", ".$limit;
    }
    
    $read_options = array(
        "fields"=>array("nombre,apellidos,usuarios.id,tipo_usuarios.name as Tipos_de_Usuarios","usuario","enabled"),        
        "join"=>array(
            "tipo_usuarios"=>array("id","tipo_usuarios")            
        ),
        "order"=>"orden",
        "limit"=> $limit_statement
    );
    $rows_options = array( 
        "description"=>array("nombre"=>array("usuario","Tipos_de_Usuarios")), 
        "image"=>array("db_table"=>"usuarios_images")
    );
    
    //$headers = array("Nombre","Apellidos","Id","Tipo de Usuario");    
    $db_table = "usuarios";        
    
    include_once 'modules/recordset.php';
?>    