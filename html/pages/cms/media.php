<!--[if lt IE 7]>
<style type="text/css">
/* The following is required for Modals to work on IE6 */
.modal {
    position: absolute;
    top: 50%;
    filter: none;
}
#gallery-modal.fullscreen {
    overflow: hidden;
}
</style>
<![endif]-->
<h1 class="recordset">Media files</h1>
<p>Here are all your images ready for use on your news or blog (If you have any of this serves as a media folder). Use this area to manage the images correctly, is in your hands.</p>
<form id="media-form" method="post" action="/ajax/uploader.php" data-form="media">
    <div class="control-group">
        <div class="file-input">
            <div>
                <div class="fileupload-buttonbar">
                    <span class="btn btn-success fileinput-button">
                        <i class="icon-plus icon-white"></i>
                        <span> Add files</span>
                        <input type="file" name="files[]" multiple />
                    </span>
                    <button type="button" class="btn btn-primary start"><i class="icon-upload icon-white"></i> Upload files</button>
                    <button type="button" class="btn danger delete" style="display: none;">Delete files</button>
                    <input type="hidden" value="media" name="seccion" />
                </div>
            </div>
        </div>
    </div>
    <ul data-toggle="modal-gallery" data-target="#modal-gallery" class="media-grid media-list files clearfix">
    
    </ul>
</form>
<div id="modal-gallery" class="modal modal-gallery hide fade">
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
<script src="/js/upload/media.js"></script>
<script src="/js/upload/jquery.iframe-transport.js"></script>
<script src="/js/upload/jquery.fileupload.js"></script>
<script src="/js/upload/jquery.fileupload-ui.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE >= 8 -->
<script src="/js/upload/jquery.xdr-transport.js"></script>
<script>
    $(document).ready(function(){
        $('.preview .pop-over').live('mouseover', function(){
            $(this).find('.media-actions').css('display', 'block'); 
        });
        $('.preview .pop-over').live('mouseout', function(){
            $(this).find('.media-actions').css('display', 'none');
        });
    });
</script>