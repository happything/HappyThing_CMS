<?php
    $table = "users";
    $description = "In this section you may create the users you want whenever you want.\n Don't forget create them with love!";
    $id = $get;

    include_once 'modules/forms.php';

    $forms = new Forms($select_row);

    $forms->create(array("id"=>"user-form", "data-form" => "user"));
    $forms->input("name",null,array("class"=>'required input-xlarge'));
    $forms->input("lastname","Last Name",array("class"=>"required input-xlarge"));
    $forms->input('email','Email',array('type'=>'email','class'=>'email required input-xlarge'));
    $forms->input("user",null,array('class'=>'input-xlarge required user'));
    $forms->input('password','Password',array('type'=>'password','class'=>'required input-xlarge'));
    $forms->input('confirmPassword', 'Confirm password', array('type' => 'password', 'class' => 'input-xlarge'));
    $forms->select("user_types_id", "User type", null, null, array("link"=>$link,"table"=>"user_types","value_field"=>"id","show_field"=>"name"),array("required"=>true,'class'=>'input-xlarge'));
    $forms->input('archivos',null,array('type'=>'file'));
    $forms->input('seccion',null,array('type' => 'hidden', 'value' => 'user'));
    $forms->input('id', null, array('type' => 'hidden', 'value' => $id));
    $forms->input('enabled',null,array('type' => 'hidden', 'value' => '1'));
    $forms->input('orden', null, array('type' => 'hidden', 'value' => '10000'));
    $forms->input('date', null, array('type' => 'hidden', 'value' => date('Y-m-d')));
    $forms->submit();
    include 'modules/sidebar.php';
?>

<script>
    var insert_id = $('#id').val();
    var global_data = 0;
</script>
<script src="/js/libs/validate.js"></script>
<script>
    $(document).ready(function(){
        jQuery.validator.addMethod('user', function(value, element){
            return this.optional(element) || /^[a-zA-Z0-9-_]+$/.test(value);
        }, "The user is not allowed");
       $('#user-form').validate({
            errorElement   : 'span',
            errorPlacement : function(error, element){
                error.appendTo(element.next('.help-inline'));
            },
            rules          : {
                confirmPassword : {
                    equalTo : '#password'
                }
            }
        });
        
        $('.preview .pop-over').live('mouseover', function(){
            $(this).find('.media-actions').css('display', 'block'); 
        });
        $('.preview .pop-over').live('mouseout', function(){
            $(this).find('.media-actions').css('display', 'none');
        });
               
        $('input[type=file]').change(function(){
            $('input.submit').val('Save & upload'); 
        });
        
        $('input.submit').click(function(event){
            if($('#user-form').valid()){
                event.preventDefault();
                var form = $('#user-form').serializeArray();
                var values = {};
                for (var i in form){
                    values[form[i].name] = form[i].value;
                }
                $.ajax({
                    url      : '/modules/forms.php',
                    type     : 'POST',
                    dataType : 'JSON',
                    data     : {
                        table    : 'users',
                        validate : {
                            password        : { encrypt : true },
                            confirmPassword : { ignore  : true },
                            archivos        : { ignore  : true },
                            seccion         : { ignore  : true }
                        },
                        form     : values
                    },
                    success  : function(result){
                        if($('input.submit').val() == "Save & upload"){
                            if(insert_id){
                                global_data.formData = {
                                    insert_id : insert_id,
                                    seccion   : 'user'
                                }
                            }else{
                                global_data.formData = {
                                    insert_id : result.insert_id,
                                    seccion   : 'user'
                                }
                            }
                            global_data.submit();
                        }
                    }
                });
            }
        });
    });     
</script>