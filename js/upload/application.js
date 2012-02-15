/*
 * jQuery File Upload Plugin JS Example 6.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, unparam: true, regexp: true */
/*global $, window, document */

$(function () {
    'use strict';
    
    $.widget('blueimpUIX.fileupload', $.blueimpUI.fileupload, {

        _renderTemplate: function (func, files) {
            return func({
                files: files,
                formatFileSize: this._formatFileSize,
                options: this.options
            });
        },

        _initTemplates: function () {
            this.options.uploadTemplate = function (o) {
                var rows = $();
                $.each(o.files, function (index, file) {
                    var row = $('<tr class="template-upload" draggable="true">' +
                        '<td class="preview"><span class="fade"></span></td>' +
                        '<td class="name" style="vertical-align: middle;"></td>' +
                        '<td class="size" style="vertical-align: middle;"></td>' +
                        (file.error ? '<td class="error" colspan="2" style="vertical-align: middle;"></td>' :
                                    '<td class="start" style="vertical-align: middle;"><button class="btn btn-primary"><i class="icon-upload icon-white"></i> Start</button></td>'
                        ) + '<td class="cancel" style="vertical-align: middle;"><button class="btn btn-warning"><i class="icon-ban-circle icon-white"></i> Cancel</button></td></tr>');
                    row.find('.name').text(file.name);
                    row.find('.size').text(o.formatFileSize(file.size));
                    if (file.error) {
                        row.addClass('ui-state-error');
                        row.find('.error').text(
                            fileUploadErrors[file.error] || file.error
                        );
                    }
                    rows = rows.add(row);
            });
            return rows;
            };
            this.options.downloadTemplate = function (o) {
                var rows = $();
                $.each(o.files, function (index, file) {
                    var row = $('<tr class="template-download">' +
                        (file.error ? '<td></td><td class="name" style="vertical-align: middle;"></td>' +
                            '<td class="size" style="vertical-align: middle;"></td><td class="error" colspan="2" style="vertical-align: middle;"></td>' :
                                '<td class="preview" style="vertical-align: middle;"></td>' +
                                    '<td class="name" style="vertical-align: middle;"><a></a></td>' +
                                    '<td class="size" style="vertical-align: middle;"></td><td colspan="2"></td>'
                        ) + '<td class="delete" style="vertical-align: middle;"><button class="btn btn-danger"><i class="icon-trash icon-white"></i> Delete</button> ' +
                            '<input type="checkbox" name="delete" value="1"></td></tr>');
                    row.find('.size').text(o.formatFileSize(file.size));
                    if (file.error) {
                        row.find('.name').text(file.name);
                        row.addClass('ui-state-error');
                        row.find('.error').text(
                            fileUploadErrors[file.error] || file.error
                        );
                    } else {
                        row.find('.name a').text(file.name);
                        if (file.thumbnail_url) {
                            row.find('.preview').append('<a><img></a>')
                                .find('img').prop('src', file.thumbnail_url);
                            row.find('a').prop('rel', 'gallery').prop('title',file.name);
                        }
                        row.find('a').prop('href', file.url);
                        row.find('.delete button')
                            .attr('data-type', file.delete_type)
                            .attr('data-url', file.delete_url);
                    }
                    rows = rows.add(row);
                });
                return rows;
            };
        }
    });
    
    $('#user-form').fileupload({
        dataType : 'json',
        url      : '../../ajax/uploader.php'
    });
  
    // Settings:
    $('#user-form').fileupload('option', {
       maxFileSize     : 4000000,
       acceptFileTypes : /(\.|\/)(gif|jpe?g|png)$/i,
       previewMaxHeight: 160,
       previewMaxWidth : 160,
       previewAsCanvas : false,
       stop            : function(){
           $('table').tableDnD();
       }
    });
    
    $.getJSON('../../ajax/uploader.php', {'seccion' : $('input[type=hidden]').val()}, function(files){
       var fu = $('#user-form').data('fileupload'),
           template;
       fu._adjustMaxNumberOfFiles(-files.length);
       template = fu._renderDownload(files).appendTo($('.files'));
       
       fu._reflow = fu._transition && template.length && template[0].offsetWidth;
       template.addClass('in');
    });    
});
