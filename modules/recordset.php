<?php    
    //If exist the variable DB_TABLE, create the all section
    if(isset($db_table)){        
        
        
        
        
        //Headers of the table VAR
        if(!isset($headers)) $headers = null;
        //Top options on the section
        if(!isset($options)) $options = null;
        //Key of the recordset array who going to show in the Edit section
        if((!isset($url_key)) || (empty($url))) $url_key = "id";
        //Url using to redirect in the Edit section
        if((!isset($location_url)) || (empty($location_url))) $location_url = "alta";
        
        include_once 'libs/table.php';
        include_once 'libs/queries.php';
        include_once 'libs/paginator.php';
        
        //Queries object
        $queries = new Queries($link);
        //Read method using name of the data base and the options of the query
        $result = $queries->read($db_table,$read_options);
        //If is success
        if($result["success"]==1){
            //Create a rows var to fill with the result query
            $rows = array();
            while($row = mysql_fetch_assoc($result["result"])){
                array_push($rows, $row);
            }
                
?>
    <div class="sidebar">
        <div class="desc-section side">
            <h2><?= ucwords($db_table) ?></h2>
            <p><?= $description ?></p>
        </div>
        <div class="arrow"></div>        
        <div class="categorizer side">
            <h2>Quick Options</h2>
            <?php
                include_once 'modules/quick-options.php';
                if(isset($quick_options) && is_array($quick_options)){
                    $quick_options_keys = array_keys($quick_options);
                    for($i=0; $i<count($quick_options); $i++){
            ?>
            <a href="/<?= $quick_options_keys[$i] ?>" class="quick-option"><?= $quick_options[$quick_options_keys[$i]] ?></a> / 
            <?php            
                    //if($i < (count($quick_options)-1)) echo " / ";
                    }
                }
            ?>
            <a href="<?= $uri_page ?>/all" class="quick-option see">Show'em all</a> / <a href="<?= $uri_page ?>/reorder" class="quick-option see">Re-Order</a>        
        </div>
    </div>
    <div class="content">
    <div class="main-options">
        <?php 
            //If Options var doesn't exist or exists but is visible show the option NEW
            if((isset($options["new"]) && $options["new"] != false) || (!isset($options["new"]))) {
                //New option default value
                $new_href = "alta";
                //If exists a NEW key, overwrite the HREF
                if(isset($options["new"]) && is_string($options["new"])) $new_href = $options["new"];
        ?>
        <a href="<?= $uri_page."/".$new_href ?>" class="main-options-option main-options-new btn btn-success btn-small"><i class="icon-plus icon-white"></i> New</a>
        
        <?php } if((isset($options["delete"]) && $options["delete"] != false) || (!isset($options["delete"]))){ ?>
        <a href="" onclick="remove_all(); return false;" class="main-options-option main-options-delete btn btn-danger btn-small"><i class="icon-trash icon-white"></i> Delete</a>
        
        <?php } if((isset($options["enable"]) && $options["enable"] != false) || (!isset($options["enable"]))){ ?>
        <a href="#" onclick="enable_all(1); return false;" class="main-options-option main-options-enable btn btn-info btn-small"><i class="icon-ok icon-white"></i> Enable</a>
        
        <?php } if((isset($options["disable"]) && $options["disable"] != false) || (!isset($options["disable"]))){ ?>
        <a href="#" onclick="enable_all(-1); return false;" class="main-options-option main-options-disable btn btn-warning btn-small"><i class="icon-remove icon-white"></i> Disable</a>
        <input type="text" id="FilterTextBox" placeholder="Filtro de busqueda" class="span6" style="margin-bottom: 0;"/>
    <?php
        }
        //If exists more options
    if(isset($options)){
        //Get keys of the options
        $option_keys = array_keys($options);
        //Read all the array
        for($i=0; $i<count($options); $i++){
            //If the selected key is an array ...
            if(is_array($options[$option_keys[$i]])){
                $href= "";
                $onclick = "";
                //If the key is HREF, write the href value
                if(isset($options[$option_keys[$i]]["href"])) $href = $options[$option_keys[$i]]["href"];
                //If is ONCLICK, write the onclick value
                if(isset($options[$option_keys[$i]]["onclick"])) $onclick = $options[$option_keys[$i]]["onclick"]."(); return false;";
    ?>        
        <a href="<?= $href ?>" onclick="<?= $onclick ?>" class="main-options-option main-options-extra-option main-options-<?= $option_keys[$i] ?>"><?= $option_keys[$i] ?></a>
    <?php
            }
        }
    }
    ?>
        
    <div class="bottom-options">
<!--        <a href="<?= $uri_page ?>/all">See all</a> <span>/</span> <a href="<?= $uri_page ?>/reorder">Re-Order</a>        -->
    </div>    
        
    </div>
<?php
        //Limit paginator value default
        if(!isset($limit)) $limit = 10;
        if(!isset($rows_options)) $rows_options = null;
        //Table object
        $table = new Table();
        
        //Table option validation
        if(!isset($table_options)) $table_options = null;
        $table_options['class'] = 'table table-striped table-bordered';
        //Creating table using tha name of the data base, the url for the edit section, the key of the db result array, options of the table
        $table->create($db_table,$location_url,$url_key,$page,$limit,$table_options);
            //Fill the table using the resulting rows and the optionals headers
            $table->fill($rows, $headers,$rows_options,$link);
        //Close and prints the table    
        echo $table->end();  
             
        //Paginating the table using data base table, limit and connection
        $paginator = new Paginator ($db_table, $limit, $link, $uri_page);
        //Paginate and prints the paginator using the current page.
        echo $paginator->paginate($page);        
?>

<script src="/js/tablesorter.js"></script>
<script src="/js/tablednd.js"></script>
<script charset="utf-8">
    var url = "/ajax/recordset.php";
    var total = 10;
    var db_table = "<?= $db_table ?>";
    <?php $curr_page = 1; if(is_numeric($page)) $curr_page = $page; ?>
    var page = <?= $curr_page ?>;
    var limit = <?= $limit ?>; 
    var tmp_timeout;
    
    $(document).ready(function(){
        $("#check-all").click(function(){ if($(this).attr("checked")==undefined) $(".single-check").removeAttr("checked"); else $(".single-check").attr("checked","checked"); });
        $("#recordset-table").tablesorter({headers:{0: { sorter: false }}});            
        total = $('table tr').length-1;        
        
        <?php if($get == "reorder"){ ?>
            $("#recordset-table").tableDnD({ onDragClass: "myDragClass", onDrop: function(table, row) { var rows = table.tBodies[0].rows; var debugStr = ""; for (var i=0; i<rows.length; i++) debugStr += rows[i].id+","; debugStr = debugStr.substring(0,debugStr.length-1); $.ajax({ url:url, type:"post", cache:false, data:{type:"sort",id:debugStr,table:db_table},success:function(data){ reorder_nums(); } }); } });
        <?php } ?>
        
        $("#FilterTextBox").keyup(function(){        
         //hide all the rows
                  $("#fbody").find("tr").hide();
         //split the current value of searchInput
                  var data = this.value.split(" ");
         //create a jquery object of the rows
                  var jo = $("#fbody").find("tr");
         //Recursively filter the jquery object to get results. 
                  $.each(data, function(i, v){
                      jo = jo.filter("*:contains('"+v+"')");
                  });
         //show the rows that match.
          jo.show();
        });
    });
    
    function enable(id,enable){ $.ajax({ url:url,type:"post",cache:false,data:{id:id,table:db_table,type:"enable",enable:enable},beforeSend:function(){},success:function(data){$(".single-check").removeAttr("checked"); $("#check-all").removeAttr("checked"); if(data == 1) { var remove_class = "enabled"; var add_class = "disabled"; if(enable == 1) { remove_class = "disabled"; add_class = "enabled"; } if(!is_array(id)) { var tmp_id = id; id = new Array(); id[0] = tmp_id; } else { id = id.split(","); }  for(var i=0; i<id.length; i++) { $("#enabled-"+id[i]).removeClass(remove_class).addClass(add_class).html(add_class).attr("onclick","enable("+id[i]+","+(enable*-1)+"); return false; "); } } } }); }
    function remove(id){ $.ajax({ url:url,type:"post",cache:false,data:{id:id,table:db_table,type:"remove"},beforeSend:function(){},success:function(data){if(data == 1) remove_rows(id);}}); }
    function remove_all(){ var checked_ids = get_checked(); if(checked_ids != "") remove(checked_ids); else alert("Select an element."); }
    function enable_all(enable_selected){ var checked_ids = get_checked(); if(checked_ids != "") enable(checked_ids,enable_selected); else alert("Select an element."); }
    function get_checked(){ var checked_ids = ""; for(var i = 0; i<total; i++){ if($("#check_"+(i+1)).attr("checked")) checked_ids += $("#check_"+(i+1)).val()+","; } if(checked_ids != "") checked_ids = checked_ids.substr(0,checked_ids.length-1); return checked_ids; }
    function remove_rows(ids){ var ids_arr = ids; if(typeof(ids)=="string") { ids_arr = ids.split(","); for(var i = 0; i<ids_arr.length; i++) { $("#row-"+ids_arr[i]).fadeOut(400,function(){$(this).remove(); reorder_nums(); }); } } else $("#row-"+ids_arr).fadeOut(400,function(){$("#row-"+ids_arr).remove(); reorder_nums();}); }   
    function duplicate(id){ $.ajax({ url:url,type:"post",cache:false,data:{id:id,table:db_table,type:"duplicate"},success:function(data){if(data==1) window.location.reload();}});}
    function reorder_nums(){ var rows = document.getElementById("recordset-table").tBodies[0].rows; var start_page = (page - 1) * limit; var row_index = 0; for (var i=start_page; i<(rows.length+start_page); i++){ $("."+rows[row_index].cells[1].id).html(i+1); row_index++; } }
    function is_array(input){ input = input.toString(); var value_return = false; if(input.indexOf(",") != -1) value_return =true ; return value_return; }
    
</script>

<?php
    } else echo $result["error"];
    } else echo "Doesn't exist 'db_table' variable.";
?>
    </div>
