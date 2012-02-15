<?php
        $validate = array(   
                "password"    => array("encrypt"=>true),
                "confirmPassword" => array('ignore' => true)
           );
        $table = "users";
        $description = "In this section you may create the users you want wherever you want.\n Don't forget create them with love!";
        $id = $get;

        include_once 'modules/forms.php';

           $forms = new Forms($select_row);

           $forms->create(array("id"=>"user-form"));
               $forms->input("name",null,array("class"=>'required input-xlarge'));
               $forms->input("lastname","Last Name",array("class"=>"required input-xlarge"));
               $forms->input('email','Email',array('type'=>'email','class'=>'email required input-xlarge'));
               $forms->input("user",null,array('class'=>'input-xlarge required user'));
               $forms->input('password','Password',array('type'=>'password','class'=>'required input-xlarge'));
               $forms->input('confirmPassword', 'Confirm password', array('type' => 'password', 'class' => 'input-xlarge'));
               $forms->select("user_types_id", "User type", null, null, array("link"=>$link,"table"=>"user_types","value_field"=>"id","show_field"=>"name"),array("required"=>true,'class'=>'input-xlarge'));
               $forms->input('archivos',null,array('type'=>'file'));
               $forms->input('seccion',null,array('type' => 'hidden', 'value' => 'user'));
               $forms->input('enabled',null,array('type' => 'hidden', 'value' => '1'));
               $forms->input('orden', null, array('type' => 'hidden', 'value' => '10000'));
               $forms->input('date', null, array('type' => 'hidden', 'value' => date('Y-m-d')));
               $forms->submit();
               include 'modules/sidebar.php';
    ?>

<script src="/js/libs/validate.js"></script>
<script>
    var fileUploadErrors = {
        maxFileSize : "File is too big",
        minFileSize : "File is too small",
        acceptFileTypes : "File's type doesn't allowed",
        maxNumberOfFiles : "Max number of files exceeded",
        uploadedBytes : "Bytes uploaded exceed the size of the file",
        emptyResult : "Null result"
    }
</script>
<script src="/js/upload/vendor/jquery.ui.widget.js"></script>
<script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
<script src="/js/bootstrap/bootstrap.min.js"></script>
<script src="/js/bootstrap/bootstrap-image-gallery.min.js"></script>
<script src="/js/upload/application.js"></script>
<script src="/js/upload/jquery.iframe-transport.js"></script>
<script src="/js/upload/jquery.fileupload.js"></script>
<script src="/js/upload/jquery.fileupload-ui.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE >= 8 -->
<script src="/js/upload/jquery.xdr-transport.js"></script>
<script>
    jQuery.validator.addMethod('user', function(value, element){
        return this.optional(element) || /^[a-zA-Z0-9-_]+$/.test(value);
    }, "The user is dosen't allowed");
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
</script>