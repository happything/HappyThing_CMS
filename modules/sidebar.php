<div class="sidebar">
    <div class="desc-section side">
        <h2><?= str_replace('_', ' ', $table); ?></h2>
        <p><?= $description; ?></p>
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
    </div>
    <!--<div class="categorizer side">
        <h2>Tipos de usuario</h2>
        <p>Now that there is the Tec-9, a crappy spray gun from South Miami. </p>
        <label for="user-type">Tipo de Usuario</label>
        <input type="text" id="user-type" class="span4" />
        <ul>
            <li><span>&times;</span><a href="#">Administrador</a></li>
            <li><span>&times;</span><a href="#">Editor</a></li>
            <li><span>&times;</span><a href="#">Usuario</a></li>
            <li><span>&times;</span><a href="#">Cualquiera</a></li>
        </ul>
    </div>-->
</div>
<div class="content">
    <?php
        echo $forms->end(); 
    ?>
</div>
<!--<div id="modal-gallery" class="modal modal-gallery hide fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn btn-small modal-next">Next <i class="icon-arrow-right"></i></a>
        <a class="btn btn-small modal-prev"><i class="icon-arrow-left"></i> Previous</a>
        <a class="btn btn-small modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play"></i> Slideshow</a>
        <a class="btn modal-download" target="_blank"><i class="icon-download"></i> Download</a>
    </div>
</div>
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
<script src="/js/upload/jquery.fileupload-ui.js"></script>-->
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE >= 8 -->
<!--<script src="/js/upload/jquery.xdr-transport.js"></script>
<script src="/js/tablednd.js"></script>-->
