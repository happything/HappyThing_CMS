<div class="control-group" style="margin-left: 160px; margin-top: 20px; ">
    <div class="file-input">
        <div>
            <div class="fileupload-buttonbar">
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span> Add files</span>
                    <input id="archivos" type="file" name="archivos[]" multiple />
                </span>
                <button type="button" class="btn btn-primary start" style="display: none;"><i class="icon-upload icon-white"></i> Upload files</button>
                <button type="button" class="btn danger delete" style="display: none;">Delete files</button>
            </div>
        </div>
    </div>
</div>
<ul data-toggle="modal-gallery" data-target="#modal-gallery" class="media-grid media-list files clearfix">

</ul>
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