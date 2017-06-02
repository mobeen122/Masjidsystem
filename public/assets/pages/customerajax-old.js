var Customersystem = function() {

    var cust = function() {
    	$('#product_id').change(function(e){        
        	debugger;
    		//var index = e.currentTarget.indexOf('product_id');
        	var id = e.currentTarget.selectedOptions[0].value;
    	    //alert("ATTACHED - Selected Id " + id + index);
    		//debugger;
            $this = $(e.target);
            //debugger;
            $.ajax({
                type: "POST",
                url: "/supplierbalance/productinfo/" + id,
                data: { country: $this.val() },
                success:function(data){
                	debugger;
                	 //alert("Returned Data is : " + data);
                	var obj = JSON.parse(data);
                	var strTable = "";
                	
                	var CostPrice = obj.Cost;
                	obj = obj.Bandings;      
                	
                	$.each(obj, function(k, v) {
                    	debugger;
                    	strTable += '<div class="row">';                	
                    	strTable += '<div class="col-md-8">';
                    	strTable += '<h4 class="form-section">' + v.name + '</h3>';
                    	strTable += "</div>";
                    	strTable += '<div class="col-md-2">';
                    	strTable += '<div class="form-group">';
                    	strTable += '<label class="control-label" style="font-size: 75%;">Sale price</label>';
                    	strTable += '<input type="text" id="defprice[' + v.id + ']" name="defprice[' + v.id + ']" class="form-control" value="' + v.price + '" onchange="UpdateMarginPercentage(this);">';
                    	strTable += "</div>";
                    	strTable += "</div>";
                    	strTable += '<div class="col-md-2">';
                    	strTable += '<div class="form-group">';
                    	strTable += '<label class="control-label" style="font-size: 75%;">Margin %</label>';
                    	strTable += '<input type="text" id="defmargin[' + v.id + ']" name="defmargin[' + v.id + ']" class="form-control mask_margin" value="" readonly>';
                    	strTable += "</div>";
                    	strTable += "</div>";
                    	strTable += "</div>"; 
                    });
                	
                	// $('#divOutputDeliveryRoute').append('<br/>' + key + ' : ' + value);
                	// $('#divOutputDeliveryRoute').append("");
                	$('#divOutputDeliveryRoute').html(strTable);
                	
                	document.getElementById("costprice").value = CostPrice;
                	$("#costprice").change();
                }
            });
        });
        
    	// This Event is registered with Supplier Balance -> Order Form -> Cost Price element [Lable is Unit Price on Form]
    	$('#costprice').change(function (e) {
    		debugger;
    	    var arrSalePrice = document.getElementsById("defprice");
    	    // Do On Change of Unit Price
    	    for (var i = 0; i < arrSalePrice.length; i++) {
    	        UpdateMarginPercentage(arrSalePrice[i]);
    	    }
    	});
    	

        UpdateMarginPercentage = function(e) {
            debugger;
            var dSalePrice = e.value;
            var ctlMarginId = e.id.replace("price", "margin"); // alert(ctlMarginId);

            if ($.trim(dSalePrice) != "") {
                var dUnitPrice = document.getElementById("costprice").value; // $("#costprice").val(); // 
                
                dSalePrice = (dSalePrice == null || dSalePrice == undefined) ? 0 : parseFloat(dSalePrice);
                dUnitPrice = (dUnitPrice == null || dUnitPrice == undefined) ? 0 : parseFloat(dUnitPrice);
                // alert("Sale Price: " + dSalePrice + " Unit / Cost Price: " + dUnitPrice);

                var dGain = dSalePrice - dUnitPrice;
                dGain = (dGain / dUnitPrice * 100).toFixed(2);
                document.getElementById(ctlMarginId).value = dGain;
            }
            else {
                document.getElementById(ctlMarginId).value = "";
            }
        };
        
        
        CustomerOrderProduct_SelectedIndexChange = function(e) {
    		debugger;
    		var strPrefix = e.name.replace("[product_id]", "");
    		var ProductId = e.selectedOptions[0].value;
    		// alert("NEW ->> " + e.id + " " + ProductId);
    		var CustomerId = document.getElementById("customer_id").value
	       	
    		$.ajax({
                type: "POST",
                url: "/balance/productinfo/" + ProductId + "/" + CustomerId,
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

                    // Assign Blank Values
                	$(document.getElementsByName(strPrefix + "[qty]"))[0].value = null;
                	$(document.getElementsByName(strPrefix + "[salesprice]"))[0].value = null;
                	$(document.getElementsByName(strPrefix + "[marginpound]"))[0].value = null;
                	$(document.getElementsByName(strPrefix + "[marginpercentage]"))[0].value = null;                	
                }
            });
        };
        
        
        CustomerOrderQuantity_OnChange = function(e) {
    		debugger;
    		var strPrefix = e.name.replace("[qty]", "");
    		var ProductId = $(document.getElementsByName(strPrefix + "[product_id]"))[0];
    		ProductId = ProductId.selectedOptions[0].value;
    		
    		var iQty = e.valueAsNumber;
    		// alert(e.name + " " + iQty + " " + ProductId);
    		
    		$.ajax({
                type: "POST",
                url: "/balance/Getsalesprice/" + ProductId + "/" + iQty,
                data: {},
                success:function(data){
                	
                	// last = Sale Price
                	$(document.getElementsByName(strPrefix + "[salesprice]"))[0].value = data;
                    
                    // Calcualte Margin
                    CalcualteMargin(strPrefix);
                }
            });
        };
        
        CustomerOrderSalesPrice_OnChange = function(e) {
    		debugger;
    		// alert("CustomerOrderSalesPrice_OnChange");
    		var strPrefix = e.name.replace("[salesprice]", "");
    		CalcualteMargin(strPrefix);
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
    		iQty = parseInt(iQty);
    		
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
    		iQty = parseInt(iQty);
    		
    		if ($.trim(fPrice) == "") fPrice = 0;
    		fPrice = parseFloat(fPrice);
    		
    		var fTotal = (iQty * fPrice).toFixed(2);
    		$(document.getElementById("edittotal")).val(fTotal);
    	}
        
        
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
                url: "/balance/savedelivery/" + invoiceId + "/" + id,
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
                url: "/balance/saveordertype/" + invoiceId + "/" + id,
                data: {},
                success:function(data){                	
                	$( "#divOrderForm" ).removeClass( "row hidden" ).addClass( "row visible" );
                }
            });
        });        
    	
    }

    return {
        //main function to initiate the module
        init: function() {
            cust();
        }
    };

}();


if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
    	Customersystem.init();
    });
}