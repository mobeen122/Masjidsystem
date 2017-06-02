var Suppliersystem = function() {

    var sup = function() {
    	$('#product_id').change(function(e, blnAutoCall){        
        	debugger;
        	var ProductId = e.currentTarget.selectedOptions[0].value;
    	    $this = $(e.target);
            
    	    $.ajax({
    	        type: "POST",
    	        url: "/api/productgroup/" + ProductId,
    	        data: {},
    	        success: function (data) {
    	            debugger;

    	            var obj = JSON.parse(data);
    	            var oUnit = null;
    	            var oGroup = null;

    	            if (obj != null) {
    	                if (obj.length >= 1) {
    	                    oUnit = new Option(obj[0].UnitDetails.Name, obj[0].UnitDetails.Value);
    	                    if (obj[0].GroupDetails != null)
    	                        oGroup = new Option(obj[0].GroupDetails.Name, obj[0].GroupDetails.Value);
    	                }
    	            }

    	            var ctlGroupType = document.getElementsByName("group_type");
    	            if (ctlGroupType != null) {
    	                ctlGroupType = ctlGroupType[0];
    	                ctlGroupType.length = 0;

    	                ctlGroupType.options[ctlGroupType.options.length] = oUnit;
    	                if (oGroup != null)
    	                    ctlGroupType.options[ctlGroupType.options.length] = oGroup;
    	                
    	                GroupType_SelectedIndexChange();
    	            }
    	        }
    	    });
        });
        
    	GroupType_SelectedIndexChange = function(e) {
    	    debugger;
    	    var ProductId = document.getElementById("product_id").value;

    	    $.ajax({
    	        type: "POST",
    	        url: "/api/supplierproductinfo/" + ProductId,
    	        data: { country: $this.val() },
    	        success: function (data) {
    	            debugger;
    	            var obj = JSON.parse(data);
    	            var strTable = "";

    	            var CostPrice = obj.Cost;
    	            obj = obj.Bandings;

    	            $.each(obj, function (k, v) {
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

    	            document.getElementById("price").value = CostPrice;
    	            document.getElementById("costprice").value = CostPrice;
    	            
    	            CalculateMargin();
    	            $("#costprice").change();
    	        }
    	    });
        }
    	
    	// This Event is registered with Supplier Balance -> Order Form -> Price element [Lable is Price on Form]
    	$('#price').change(function (e) {
    		CalculateMargin();
    	});
    	
    	// This Event is registered with Supplier Balance -> Order Form -> Qty element [Lable is Qty on Form]
    	$('#qty').change(function (e) {
    		CalculateMargin();
    	});
    	
    	CalculateMargin = function(){
    		debugger;
    		var dPrice = document.getElementById("price").value;    		
    		if ($.trim(dPrice) == "") dPrice = 0;
    		dPrice = parseFloat(dPrice);
    		
    		var iGroupTypeQty = document.getElementById("productGroupType_Id").value;
    		if ($.trim(iGroupTypeQty) == "") iGroupTypeQty = 0;
    		iGroupTypeQty = parseFloat(iGroupTypeQty);
    		
    		var iQty = document.getElementById("qty").valueAsNumber;
    		if ($.trim(iQty) == "") iQty = 0;
    		iQty = parseFloat(iQty);
    		    		
    		var dCostPrice = 0;
    		if(iGroupTypeQty > 0)
    			dCostPrice = dPrice / (iGroupTypeQty);
    		
    		document.getElementById("costprice").value = dCostPrice.toFixed(2);
    		
    		var dTotal = 0;
    		if(dPrice > 0 && iQty > 0)
    			dTotal = dPrice * iQty;
    		
    		dTotal = parseFloat(dTotal);
    		document.getElementById("total").value = dTotal.toFixed(2);
    		$('#costprice').change();
    	}
    	
    	// This Event is registered with Supplier Balance -> Order Form -> Cost Price element [Lable is Unit Price on Form]
    	$('#costprice').change(function (e) {
    		debugger;
    	    var arrSalePrice = $( "input[name^='defprice']" );// document.getElementsById("defprice");
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
                if(dGain > 0 && dUnitPrice > 0)
                	dGain = (dGain / dUnitPrice * 100).toFixed(2);
                else 
                	dGain = 100;
                document.getElementById(ctlMarginId).value = dGain;
            }
            else {
                document.getElementById(ctlMarginId).value = "";
            }
        };
 	
    }

    return {
        //main function to initiate the module
        init: function() {
            sup();
        }
    };

}();


if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
    	Suppliersystem.init();
    });
}