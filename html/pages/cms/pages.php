<?php

?>
<script src="/js/tiny_mce/tiny_mce.js"></script>
<script>
    $(document).ready(function(){
        tinyMCE.init({
            // General options
            mode : "specific_textareas",
            editor_selector : "textarea-mce",
            theme : "advanced",            

            // Theme options
            theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,forecolor,backcolor",
            theme_advanced_buttons2 : "",                        
            theme_advanced_buttons3 : "",
            theme_advanced_toolbar_location : "bottom",
            theme_advanced_toolbar_align : "left"                       
        });
    });
</script>
<div class="sidebar pages">
    <div class="desc-section side">
        <h2>Pages</h2>
        <p>Hi, this pleace it's for your web site sections, can modify the content of some areas.</p>
    </div>
    <div class="categorizer side">        
        <div>
            <label for="title">Title</label>
            <input type="text" id="title-0" class="span5" placeholder="Here the title ..."  /> 
        </div>        
        <div>
            <label for="subtitle">Sub-Title</label>
            <input type="text" id="subtitle-0" class="span5" placeholder="Here the sub-title ..."  />        
        </div>        
        <div>
            <label for="content">Content</label>
            <textarea id="content-0" class="span5 textarea-mce"></textarea>
        </div>           
        <input type="button" id="save-0" class="btn primary new-page" onclick="section_save(0);" value="New Page" />
        <div class="section-select">
            <label for="section-select">Section</label>
            <select id="section-select-0" class="span2">
                <option value="-1">Select a section</option>
                <?php
                    $sql = "SELECT id,section FROM sections";
                    $result = mysql_query($sql,$link);
                    while($row = mysql_fetch_array($result)){
                ?>
                <option value="<?= $row["id"] ?>"><?= utf8_encode($row["section"]) ?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <img class="section-arrow" src="/img/section-arrow.jpg" />
    </div>
    <div class="categorizer side sections">
        <h2>Sections</h2>
        <p>
            Here get new sections for your website.
        </p>
        <label for="section">Section</label><a href="" id="stop-editing" onclick="stop_editing(); return false;">Stop editing ...</a>
        <input type="text" id="section-input" class="span5" placeholder="A new section ..." />
        <div class="list" id="section-list">
            <?php
                $sql = "SELECT id,section FROM sections";
                $result = mysql_query($sql,$link);
                while($row = mysql_fetch_array($result)){
            ?>
            <span id="section-option-<?= $row["id"] ?>"><a class="del" href="" onclick="section_remove(<?= $row["id"] ?>); return false;">x</a> <a href="" id="section-label-<?= $row["id"] ?>" onclick="section_edit(<?= $row["id"] ?>); return false;"><?= utf8_encode($row["section"]) ?></a></span>
            <?php
                }
            ?>
        </div>
    </div>
</div>
<div class="content sections-content">
    <?php
        $sql = "SELECT areas.id,title,subtitle,content,sections_id,section,sections.id as section_id
                FROM areas 
                RIGHT JOIN sections ON sections_id = sections.id
                ORDER BY sections.id";
        $result = mysql_query($sql,$link);
        $section = -1;        
        while($row = mysql_fetch_array($result)){
            if($section != $row["section_id"]){                
                if($section != -1) {
    ?>   
        </div>
    </div>     
    <?php     
        }
        $section = $row["sections_id"];
    ?>    
    <div class="section-container" id="section-container-<?= $row["section_id"] ?>">
        <a href="" onclick="return false;" class="section-option" id="section-content-option-<?= $row["section_id"] ?>"><?= utf8_encode($row["section"]) ?></a>
        <div class="section-form" id="section-form-<?= $row["section_id"] ?>">
    <?php } if(isset($row["id"])){ ?>
            <div class="area-container" id="area-container-<?= $row["id"] ?>">
                <a href="#" onclick="area_show_form(<?= $row["id"] ?>); return false;" id="area-title-<?= $row["id"] ?>"><?= utf8_encode($row["title"]) ?></a> <a href="" class="delete-area" id="area-remove-<?= $row["id"] ?>" onclick="area_remove(<?= $row["id"] ?>); return false;">(Delete)</a>
                <p> <?= utf8_encode($row["subtitle"]) ?> </p>
<!--                <div class="area-form" id="area-form-<? $row["id"] ?>"></div> -->
            </div>                        
    <?php
            }
        }
    ?>    
</div>

<script charset="utf8">
    var section_id = -1;
    $(document).ready(function(){
        $("#section-input").keyup(function(k){
            if(k.keyCode == 13) {
                $.ajax({
                    url:"/ajax/pages.php",
                    cache:false,
                    type:"post",
                    data:{type:"section-add",section:$("#section-input").val(),section_id:section_id},                    
                    success:function(data){                        
                        if(data != 0) {                                                        
                            if(section_id == -1) { $("#section-list").append('<span id="section-option-'+data+'"><a class="del" href="" onclick="section_remove('+data+'); return false;">x</a> <a href="" id="section-label-'+data+'" onclick="section_edit('+data+'); return false;">'+$("#section-input").val()+'</a></span>'); $("#section-select-0").append("<option value='"+data+"'>"+$("#section-input").val()+"</option>"); $(".sections-content").append('<div class="section-container" id="section-container-'+data+'"><a href="" onclick="return false;" class="section-option" id="section-content-option-'+data+'">'+$("#section-input").val()+'</a><div class="section-form" id="section-form-'+data+'"></div></div>');  $("#section-option-"+data).css("display","none").fadeIn(400,function(){ $("#section-input").val(""); }); }                            
                            else { $('#section-label-'+section_id).html($("#section-input").val()); $("#section-select-0 option[value="+section_id+"]").html($("#section-input").val()); $("#section-content-option-"+section_id).html($("#section-input").val()); $("#section-input").val(""); $("#stop-editing").fadeOut(400); }
                            section_id = -1;
                        } 
                    }
                });
            }
        });
    });
    
    function section_edit(id){ section_id = id; $("#section-input").val($("#section-label-"+id).html()).focus(); $("#stop-editing").fadeIn(400); }
    function stop_editing(){ section_id = -1; $("#section-input").val(""); $("#stop-editing").fadeOut(400); }
    
    function section_remove(id){
        if(confirm("REALLY? Do you want to delete this section? \nIf you remove this, all the areas related goint to be deleted.")){
            var section_label = $("#section-label-"+id).html();       
            $("#section-label-"+id).html("Deleting ...");
            $.ajax({ url:"/ajax/pages.php", type:"post", cache:false, data:{id:id,type:"section-remove"}, success:function(data){ if(data == 1) { $("#section-option-"+id).fadeOut(400, function(){ $("#section-option-"+id).remove(); }); $("#section-container-"+id).fadeOut(400,function(){ $("#section-container-"+id).remove() }); $("#section-select-0 option[value="+id+"]").remove(); } else if(data == 0) $("#section-label-"+id).html(section_label); } });
        }        
    }
    
    function section_save(id){   
        if($("#title-"+id).val() != "" && tinyMCE.get("content-"+id).getContent() != "" && $("#section-select-"+id).val() != -1){
            $("#save-"+id).val("Saving area ...");
            var title = $("#title-"+id).val();
            var subtitle = $("#subtitle-"+id).val();
            $.ajax({
                url:"/ajax/pages.php",
                type:"post",
                cache:false,
                data:{ title:$("#title-"+id).val(),subtitle:$("#subtitle-"+id).val(),content:tinyMCE.get("content-"+id).getContent(),section:$("#section-select-"+id).val(),id:id,type:"section-save" },
                beforeSend:function(){
                    //Disable fields
                    $("#subtitle-"+id).attr("disabled","disabled").val(""); $("#title-"+id).attr("disabled","disabled").val(""); $("#content-"+id).attr("disabled","disabled").val(""); $("#section-select-"+id).attr("disabled","disabled");
                },
                success:function(data){                    
                    if(data != 0) {                                                                        
                        //Re-set area form
                        $("#save-"+id).val("New Page"); $("#subtitle-"+id).removeAttr("disabled"); $("#title-"+id).removeAttr("disabled"); $("#content-"+id).removeAttr("disabled"); $("#section-select-"+id).removeAttr("disabled"); 
                        if(id==0) { $("#section-form-"+$("#section-select-0").val()).append('<div class="area-container" id="area-container-'+data+'"><a href="" onclick="area_show_form('+data+'); return false;" id="area-title-'+data+'">'+title+'</a> <a href="" class="delete-area" id="area-remove-'+data+'" onclick="area_remove('+data+'); return false;">(Delete)</a><p>'+subtitle+'</p></div>'); }
                        else { $("#area-title-"+id).html(title); $("#area-container-"+id+" p").html(subtitle); $("#area-form-"+id).css("padding","0 10px").animate({ height:"0px" },400,function(){ tinyMCE.execCommand( 'mceRemoveControl', true, 'content-'+id); $("#area-form-"+id).remove(); });}
                        tinyMCE.get("content-"+id).setContent(""); $("#section-select-"+id+" option[value=-1]").attr("selected","selected");                        
                    }
                }
            });    
        } else alert("WAIT! Title, Content and Section are obligatory. \nPull it before creating a new area.");        
    }
    
    function area_remove(id){
        if(confirm("REALLY? Do you want to delete this area? \nDon't worry, you can add it whenever you want.")){
            $("#area-remove-"+id).html("Deleting ...");
            $.ajax({ 
                url:"/ajax/pages.php",
                type:"post",
                cache:false,
                data:{id:id,type:"area-remove"},
                success:function(data){
                    if(data == 1) $("#area-container-"+id).fadeOut(400,function(){ $("#area-container-"+id).remove(); });
                    else { $("#area-remove-"+id).html("(Delete)"); alert("Damn! It was not possible delete this area.\nPlease, try again."); }
                }
            });
        }
    }
    
    function area_show_form(id){        
        if($("#area-form-"+id).css("height")==undefined){
            $("#area-container-"+id).append('<div class="area-form" id="area-form-'+id+'"></div>');
            $("#area-form-"+id).css("width","400px").animate({ height:"335px" },{duration:"400",easing:"swing",complete:function(){
                $.ajax({
                    url:"/ajax/pages.php",
                    type:"post",
                    dataType:"json",
                    cache:false,
                    data:{id:id,type:"area-see"},
                    success:function(data){ 
                        $("#area-form-"+id).html('<div><label for="title">Title</label><input type="text" id="title-'+id+'" class="span5" placeholder="Here the title ..." value="'+data.title+'" /> </div> <div> <label for="subtitle">Sub-Title</label> <input type="text" id="subtitle-'+id+'" class="span5" placeholder="Here the sub-title ..."  value="'+data.subtitle+'" /> </div> <div> <label for="content">Content</label> <textarea id="content-'+id+'" class="span5 textarea-mce">'+data.content+'</textarea> </div> <input type="button" id="save-'+id+'" class="btn btn-primary new-page" onclick="section_save('+id+');" value="New Page" /> <input type="hidden" id="section-select-'+id+'" value="'+data.sections_id+'" /><a href="" onclick="hide_form('+id+'); return false;">Hide</a>');
                        $("#title-"+id).focus();
                        tinyMCE.execCommand( 'mceAddControl', true, 'content-'+id);//$('#content-'+id).tinymce().show();
                    }
                });                
            }});         
        } else { $("#area-form-"+id).css("padding","0 10px").animate({ height:"0px" },400,function(){ tinyMCE.execCommand( 'mceRemoveControl', true, 'content-'+id); $("#area-form-"+id).remove(); }); }
    }
    
    function hide_form(id){
        $("#area-form-"+id).css("padding","0 10px").animate({ height:"0px" },400,function(){ tinyMCE.execCommand( 'mceRemoveControl', true, 'content-'+id); $("#area-form-"+id).remove(); });
    }
    
    
</script>