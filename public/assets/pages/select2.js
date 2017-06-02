/**
 *  for select2 activation
 */
var Select2 = function() {

    var handleDemo = function() {
    	
    	$.fn.select2.defaults.set("theme", "bootstrap");

        var placeholder = "Select a Option";

        $(".select2").select2({
            placeholder: placeholder,
            width: null
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleDemo();
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        Select2.init();
    });
}