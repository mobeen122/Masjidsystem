var Customersystem = function() {

    var cust = function() {
        CustomerOrderProduct_SelectedIndexChange = function(e, blnAutoCall) {
    		debugger;
    		var strPrefix = e.name.replace("[product_id]", "");
    		var ProductId = e.selectedOptions[0].value;
    		// alert("NEW ->> " + e.id + " " + ProductId);
    		var CustomerId = document.getElementById("customer_id").value
	       	
    		var GroupType = $(document.getElementsByName(strPrefix + "[group_type]"))[0];
    		if(GroupType.length > 0)
    			GroupType = GroupType.selectedOptions[0].value;
    		
    		if(GroupType == "" || GroupType == null)
    			GroupType = 1;
    		
    		console.log("/api/productinfo/" + ProductId + "/" + CustomerId + "/" + GroupType);
    		
    		$.ajax({
                type: "POST",
                url: "/api/productinfo/" + ProductId + "/" + CustomerId + "/" + GroupType,
                data: {},
                success:function(data){
                	debugger;
                	// alert("Returned Data is : " + data);
                	var obj = JSON.parse(data);
                	
                	var fUnitPrice = 0; 
                	var fSalePrice = 0;
                	var fPrice = 0;
                	
                	if(obj != null) {
                		fUnitPrice = parseFloat(obj.unit);               	
                		fSalePrice = parseFloat(obj.sale);
                		fPrice = parseFloat(obj.price);
                	}
                	
                	// cost = Unit Price
                	$(document.getElementsByName(strPrefix + "[unitprice]"))[0].value = obj.unit;
                	
                	// default = Price
                	$(document.getElementsByName(strPrefix + "[price]"))[0].value = obj.price;

                	if(blnAutoCall != true) {
	                	// Assign Blank Values
	                	$(document.getElementsByName(strPrefix + "[qty]"))[0].value = null;
	                	$(document.getElementsByName(strPrefix + "[salesprice]"))[0].value = null;
	                	$(document.getElementsByName(strPrefix + "[marginpound]"))[0].value = null;
	                	$(document.getElementsByName(strPrefix + "[marginpercentage]"))[0].value = null;    
                	
	                	$.ajax({
	                        type: "POST",
	                        url: "/api/productgroup/" + ProductId,
	                        data: {},
	                        success:function(data){
	                        	debugger;
	                        	
	                        	var obj = JSON.parse(data);
	                        	var oUnit = null;
	                        	var oGroup = null;
	                        	
	                        	if(obj != null) {
	                        		if(obj.length >= 1) {
	                        			oUnit = new Option(obj[0].UnitDetails.Name, obj[0].UnitDetails.Value);
	                        			if(obj[0].GroupDetails != null)
	                        				oGroup = new Option(obj[0].GroupDetails.Name, obj[0].GroupDetails.Value);
	                            	}	
	                        	}
	                        	
	                        	var ctlGroupType = document.getElementsByName(strPrefix + "[group_type]");
	                        	if(ctlGroupType != null) {
	                        		ctlGroupType = ctlGroupType[0];
	                        		ctlGroupType.length = 0;
	                        		
	                        		ctlGroupType.options[ctlGroupType.options.length]= oUnit;
	                        		if(oGroup != null)
	                        			ctlGroupType.options[ctlGroupType.options.length]= oGroup;
	                        	}
	                        		
	                        }
	                    });
	                	$("#linkCopyProductGrid").click();
                	}
                }
            });
        };
        
        CustomerOrderGroupType_SelectedIndexChange = function(e) {
    		debugger;
    		var strPrefix = e.name.replace("[group_type]", "");
    		var ctlProduct = $(document.getElementsByName(strPrefix + "[product_id]"))[0];
    		CustomerOrderProduct_SelectedIndexChange(ctlProduct, true);
        }
        
        CustomerOrderQuantity_OnChange = function(e) {
    		debugger;
    		var strPrefix = e.name.replace("[qty]", "");
    		var ctlProduct = $(document.getElementsByName(strPrefix + "[product_id]"))[0];
    		CustomerOrderProduct_SelectedIndexChange(ctlProduct, true);
    		
    		var ProductId = $(document.getElementsByName(strPrefix + "[product_id]"))[0];
    		var GroupType = $(document.getElementsByName(strPrefix + "[group_type]"))[0];
    		
    		ProductId = ProductId.selectedOptions[0].value;
    		GroupType = GroupType.selectedOptions[0].value;
    		
    		var iQty = e.valueAsNumber;
    		// alert(e.name + " " + iQty + " " + ProductId);
    		
    		$.ajax({
                type: "POST",
                url: "/api/Getsalesprice/" + ProductId + "/" + iQty + "/" + GroupType,
                data: {},
                success:function(data){
                	
                	// last = Sale Price
                	$(document.getElementsByName(strPrefix + "[salesprice]"))[0].value = data;
                    
                    // Calcualte Margin
                    CalcualteMargin(strPrefix);
                    
                    CalculateRunningTotal();
                }
            });
        };
        
        CustomerOrderSalesPrice_OnChange = function(e) {
    		debugger;
    		// alert("CustomerOrderSalesPrice_OnChange");
    		var strPrefix = e.name.replace("[salesprice]", "");
    		CalcualteMargin(strPrefix);
    		
    		CalculateRunningTotal();
        };
        
        CalcualteMargin = function(strPrefix) {
        	// Calcualte Margin
            var fUnitPrice = $(document.getElementsByName(strPrefix + "[unitprice]"))[0].value;
            var fSalePrice = $(document.getElementsByName(strPrefix + "[salesprice]"))[0].value;
            var fPrice = $(document.getElementsByName(strPrefix + "[price]"))[0].value;
            var iQty = $(document.getElementsByName(strPrefix + "[qty]"))[0].valueAsNumber;
            
            if ($.trim(fUnitPrice) == "") fUnitPrice = 0;
            if ($.trim(fSalePrice) == "") fSalePrice = 0;
            if ($.trim(fPrice) == "") fPrice = 0;

            fUnitPrice = parseFloat(fUnitPrice);
            fSalePrice = parseFloat(fSalePrice);
            fPrice = parseFloat(fPrice);

            var fMargin = 0;
            var fMarginPercentage = 0;

            fMargin = (fSalePrice - fUnitPrice).toFixed(2);
            if (fUnitPrice > 0)
                fMarginPercentage = ((fMargin * 100) / fUnitPrice);

            // Margin = Sale Price - Unit Price
            $(document.getElementsByName(strPrefix + "[marginpound]"))[0].value = fMargin * iQty;

            // Margin % = Margin * 100 / Unit Price                	
            $(document.getElementsByName(strPrefix + "[marginpercentage]"))[0].value = fMarginPercentage.toFixed(2);
            
            // Update Total
            CalculateAndUpdateTotal(strPrefix);
        }

        
    	CalculateAndUpdateTotal = function(strPrefix) {
    		debugger;
    		var iQty = $(document.getElementsByName(strPrefix + "[qty]"))[0].valueAsNumber;
    		var fPrice = $(document.getElementsByName(strPrefix + "[price]"))[0].value;
    		var fSalesPrice = $(document.getElementsByName(strPrefix + "[salesprice]"))[0].value;
    		
    		if ($.trim(iQty) == "") iQty = 0;
    		iQty = parseFloat(iQty);
    		
    		if ($.trim(fSalesPrice) == "") fSalesPrice = 0;
    		fSalesPrice = parseFloat(fSalesPrice);
    		
    		var fTotal = (iQty * fSalesPrice).toFixed(2);
    		$(document.getElementsByName(strPrefix + "[total]"))[0].value = fTotal;
    	}
    	
    	
    	CalculateAndUpdateEditTotal = function(e) {
    		debugger;
    		var iQty = document.getElementById("editqty").valueAsNumber;
    		var fPrice = $(document.getElementById("editprice")).val();
    		
    		if ($.trim(iQty) == "") iQty = 0;
    		iQty = parseFloat(iQty);
    		
    		if ($.trim(fPrice) == "") fPrice = 0;
    		fPrice = parseFloat(fPrice);
    		
    		var fTotal = (iQty * fPrice).toFixed(2);
    		$(document.getElementById("edittotal")).val(fTotal);
    	}
        
    	$('#invoice_date').change(function(e){        
        	debugger;
        	var dtDate = e.currentTarget.value;
        	//alert("Date Changed: " + dtDate);        	
        	var invoiceId = document.getElementById("invoice_id").value;
        	
        	$.ajax({
                type: "POST",
                url: "/api/invoicedate/" + invoiceId + "/" + dtDate,
                data: {},
                success:function(data){                	
                }
            });
        });
    	
        $('#price').change(function(e){        
        	debugger;
        	var price = e.currentTarget.value;
        	// alert(price);
        	
        	// Calcualte Margin
            CalcualteMargin();
        });
        
        $('#editprice').change(function(e){        
        	debugger;
        	
        	// Update Total
        	CalculateAndUpdateEditTotal();
        });
        $('#editqty').change(function(e){        
        	debugger;
        	
        	// Update Total
        	CalculateAndUpdateEditTotal();
        });
        
        $('#ddlDeliveryRoute').change(function(e){        
        	debugger;
        	var id = e.currentTarget.selectedOptions[0].value;        	
        	var invoiceId = document.getElementById("invoice_id").value;
    	    // alert("ddlDeliveryRoute - Selected Id " + "/balance/savedelivery/" + invoiceId + "/" + id);
    	    
    	    $.ajax({
                type: "POST",
                url: "/api/savedelivery/" + invoiceId + "/" + id,
                data: {},
                success:function(data){
                	
                }
            });
        });
        
        $('#ddlDeliveryOrderType').change(function(e){        
        	debugger;
        	var id = e.currentTarget.selectedOptions[0].value;
        	var invoiceId = document.getElementById("invoice_id").value;
        	// alert("ddlDeliveryOrderType - Selected Id " + "/balance/saveordertype/" + invoiceId + "/" + id);
        	
        	$.ajax({
                type: "POST",
                url: "/api/saveordertype/" + invoiceId + "/" + id,
                data: {},
                success:function(data){                	
                	$( "#divOrderForm" ).removeClass( "row hidden" ).addClass( "row visible" );
                }
            });
        });        
    	
        CalculateRunningTotal = function() {
    		debugger;
    		var dTotal = $("#running_total_p").val();
    		if(dTotal != "" && dTotal != null && dTotal != undefined)
    			dTotal = parseFloat(dTotal);
    		else
    			dTotal = 0;
    		
    		var dMarginTotal = $("#total_pound_margin_p").val();
    		if(dMarginTotal != "" && dMarginTotal != null && dMarginTotal != undefined)
    			dMarginTotal = parseFloat(dMarginTotal);
    		else
    			dMarginTotal = 0;
    		
    		var dMarginTotalPercentage = $("#number_of_items").val();// $("#total_percent_margin_p").val();
    		if(dMarginTotalPercentage != "" && dMarginTotalPercentage != null && dMarginTotalPercentage != undefined)
    			dMarginTotalPercentage = parseFloat(dMarginTotalPercentage);
    		else
    			dMarginTotalPercentage = 0;
    		
    		var iProductTotalMarginPercentageCount = $("#number_of_items").val();// $("#total_percent_margin_p").val();
    		if(iProductTotalMarginPercentageCount != "" && iProductTotalMarginPercentageCount != null && iProductTotalMarginPercentageCount != undefined)
    			iProductTotalMarginPercentageCount = parseInt(iProductTotalMarginPercentageCount);
    		else
    			iProductTotalMarginPercentageCount = 0;
    		
    		// alert("Load complete.... \n" + dTotal + "\n" + dMarginTotal + "\n" + dMarginTotalPercentage);
    		
    		
    		var dTotal_Running = 0;
    		var dMarginTotal_Running = 0;
    		var dMarginTotalPercentage_Running = 0;
    		
    		// Get Product Total Price
    		var arrProductTotalPrice = $( "input[name*='][total]']" );
    	    for (var i = 0; i < arrProductTotalPrice.length; i++) {
    	        var e = arrProductTotalPrice[i];
    	    	if(e.value != "" && e.value != null && e.value != undefined)
    	    		dTotal_Running += parseFloat(e.value);
    	    }
    	    
    	    // Get Product Total Margin
    		var arrProductTotalMargin = $( "input[name*='][marginpound]']" );
    	    for (var i = 0; i < arrProductTotalMargin.length; i++) {
    	        var e = arrProductTotalMargin[i];
    	    	if(e.value != "" && e.value != null && e.value != undefined)
    	    		dMarginTotal_Running += parseFloat(e.value);
    	    }
    	    
    	    // Get Product Total Margin %
    		var arrProductTotalMarginPercentage = $( "input[name*='][marginpercentage]']" );    		 
    	    for (var i = 0; i < arrProductTotalMarginPercentage.length; i++) {
    	        var e = arrProductTotalMarginPercentage[i];
    	    	if(e.value != "" && e.value != null && e.value != undefined) {
    	    		dMarginTotalPercentage_Running += parseFloat(e.value);
    	    		iProductTotalMarginPercentageCount++;
    	    	}
    	    }
    	    
    	    dTotal_Running += dTotal;
    	    dMarginTotal_Running += dMarginTotal;
    	    dMarginTotalPercentage_Running += dMarginTotalPercentage;
    	    
    	    // alert("Running Total, Margin, Margin %: " + dTotal_Running + "\n" + dMarginTotal_Running + "\n" + dMarginTotalPercentage_Running);
    	    
    	    $("#running_total").val(dTotal_Running.toFixed(2));
    	    $("#total_pound_margin").val(dMarginTotal_Running.toFixed(2));
    	    
    	    if(iProductTotalMarginPercentageCount > 0)
    	    	dMarginTotalPercentage_Running = dMarginTotalPercentage_Running / iProductTotalMarginPercentageCount;
    	    $("#total_percent_margin").val(dMarginTotalPercentage_Running.toFixed(2));
        }
    }

    return {
        //main function to initiate the module
        init: function() {
            cust();
            CalculateRunningTotal();
        }
    };

}();


if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
    	Customersystem.init();
    });
}