/**
 *  @author Asif Iqbal
 *  Form elements to the used by all the forms in the application 
 */

var FormInputMask = function () {	
	
	var handleInputMasks = function () {
        /*$.extend($.inputmask.defaults, {
        	removeMaskOnSubmit: false,
        });*/

		if (jQuery().datepicker) {
	        $('.datepicker').datepicker({
	            rtl: App.isRTL(),
	            format: 'dd-mm-yyyy',
	            todayHighlight: true,
	            orientation: "left",
	            autoclose: true,
	            todayBtn: 'linked'
	            
	        });
	        //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	    }
        /*$(".mask_ref").inputmask('[99]99999', {
            numericInput: true
        });*/
        $(".mask_ref").inputmask({ 
        	mask: "9999[9999]",
        	placeholder: " ",
        	numericInput: true,
        	greedy: false
        });
        $(".mask_weight").inputmask({ 
        	mask: "[9999]9.9",
        	placeholder: " ",
        	numericInput: true,
        	greedy: false
        });
        $(".mask_number").inputmask({
            mask: "9",
            repeat: 10,
            greedy: false,
            numericInput: true,
            placeholder: " "
        });
        $(".qty").inputmask({
            mask: "9",
            repeat: 3,
            greedy: false,
            numericInput: true,
            placeholder: " "
        });
        $("#qty").inputmask({
            mask: "9",
            repeat: 5,
            greedy: false,
            numericInput: true,
            placeholder: " "
        });
        $(".weight").inputmask('[99]9.9', {
            numericInput: true
        });
        $(".mask_date").inputmask("d-m-y", {
            "placeholder": "dd-mm-yyyy"
        });
        $("#mask_phone").inputmask('0199 999 9999');
        $(".mask_phone").inputmask('0199 999 9999');
        $("#mask_mobile").inputmask("mask", {
            "mask": "0799 999 9999",
        });
        $("#mask_telephone").inputmask("mask", {
            "mask": "0999 999 9999",
        });
        $('.date-picker').datepicker({
        	rtl: App.isRTL(),
            format: 'dd-mm-yyyy',
            autoclose: true
        });
        
        $(".mask_currency").inputmask('[99999]9.99', {
            numericInput: true,
            greedy: false,
            placeholder: " "
        });
        $(".charges").inputmask('[99]9.99', {
            numericInput: true
        });
        
    }
    return {
        init: function () {
            handleInputMasks();
        }
    };
}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {
        FormInputMask.init(); // init metronic core componets
    });
}