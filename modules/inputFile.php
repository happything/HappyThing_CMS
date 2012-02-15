<div class="control-group file hide">
    <div class="controls">
        <div>
            <div class="fileupload-buttonbar">
                <div class="progress progress-info progress-striped active fileupload-progressbar"><div class="bar" style="width: 0%"></div></div>
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span> Add files</span>
                    <input type="file" name="files[]" multiple />
                </span>
                <button type="button" class="btn btn-primary start"><i class="icon-upload icon-white"></i> Upload files</button>
                <button type="reset" class="btn btn-warning cancel"><i class="icon-ban-circle icon-white"></i> Cancel</button>
                <button type="button" class="btn btn-danger delete"><i class="icon-trash icon-white"></i> Delete selected</button>
                <input type="checkbox" class="toggle" />
            </div>
        </div>
        <br />
        <div>
            <div>
                <table class="table table-striped">
                    <tbody class="files" data-target="#modal-gallery" data-toggle="modal-gallery"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>