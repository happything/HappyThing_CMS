/*
 * Plugin for listen to a select element and update another bind to them
 * 
 * Example of usage:
 * $(document).ready(function(){
       $(elementToObserve).observe_field(elementToUpdate,referenceToBD,{
           parentName : 'parentColumn'
       });
    });
 *
 * Options:
 * event        - Event to listen
 * selectedText - Default text for element updated
 * parentName   - Parent field
 * fieldName    - (Self explained)
 * url          - URL to the PHP script
 * 
 * Put 'child' class to the element for clearing everytime the first select changes
 * 
 */

(function($) {
    $.fn.observe_field = function(update,className,options){
        
        //Default properties
        var defaults = {
            event        : 'change',
            selectedText : 'Selecciona una opción',
            parentName   : 'parent-id',
            fieldName    : 'name',
            url          : '../../ajax/observed_field.php'
        };
        
        var options = $.extend({},defaults, options);
        
        var $obj = $(this); //Element's object selected
        
        var parentName = options.parentName;
        var fieldName = options.fieldName;
        var selectedText = options.selectedText;
        var event = options.event;
        var url = options.url;      
               
        if(event == 'change'){
            $obj.change(function(){
                $.ajax({
                   type    : 'POST',
                   dataType: 'JSON',
                   url     : url,
                   data    : {
                       className : className,
                       parentID  : $obj.val(),
                       parentName: parentName,
                       fieldName : fieldName
                   },
                   success : function(data){
                       $(".child").html('');
                       $(update).html('').append("<option value='-1'>" + selectedText + "</option>");
                       for(var i = 0; data.length; i++){
                           $(update).append("<option value='"+ data[i].value + "'>" + data[i].name + "</option>");
                       }
                   }
                });
            });
        }
    }
})(jQuery);