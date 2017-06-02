var Customersystem = function() {

    var cust = function() {
    	$('#product_id').change(function(e){        
        	// debugger;
        	var id = e.currentTarget.selectedOptions[0].value;
        	// alert("ATTACHED - Selected Id " + id);
            $this = $(e.target);
            $.ajax({
                type: "POST",
                url: "/supplierbalance/productinfo/" + id,
                data: { country: $this.val() },
                success:function(data){
                	debugger;
                	 //alert("Returned Data is : " + data);
                	var obj = JSON.parse(data);
                	var strTable = "";
                	
                	$.each(obj, function(k, v) {
                    	debugger;
                    	strTable += '<div class="row">';                	
                    	strTable += '<div class="col-md-6">';
                    	strTable += '<h4 class="form-section">' + v.name + '</h3>';
                    	strTable += "</div>";
                    	strTable += '<div class="col-md-2">';
                    	strTable += '<div class="form-group">';
                    	strTable += '<label class="control-label">Sale price</label>';
                    	strTable += '<input type="text" id="defprice" name="defprice[' + v.id + ']" class="form-control mask_currency" value="">';
                    	strTable += "</div>";
                    	strTable += "</div>";
                    	strTable += '<div class="col-md-2">';
                    	strTable += '<div class="form-group">';
                    	strTable += '<label class="control-label">Margin %</label>';
                    	strTable += '<input type="text" id="margin" class="form-control mask_margin" value="">';
                    	strTable += "</div>";
                    	strTable += "</div>";
                    	strTable += "</div>"; 
                    });
                	
                	// $('#divOutputDeliveryRoute').append('<br/>' + key + ' : ' + value);
                	// $('#divOutputDeliveryRoute').append("");
                	$('#divOutputDeliveryRoute').html(strTable);
                }
            });
        });
        
        
        $('#CustomerOrderProduct_Id').change(function(e){        
        	// debugger;
        	var id = e.currentTarget.selectedOptions[0].value;
        	var customer = document.getElementById("customer_id").value
        	// alert("ATTACHED - Selected Id " + id);
        	// alert(document.getElementById("customer_id").value);
            $this = $(e.target);
            
            $.ajax({
                type: "POST",
                url: "/balance/productinfo/" + id + "/" + customer,
                data: { country: $this.val() },
                success:function(data){
                	/*debugger;
                	alert("Returned Data is : " + data);*/
                	var obj = JSON.parse(data);
                	
                	var fUnitPrice = 0; 
                	var fSalePrice = 0;
                	var fPrice = 0;
                	var fMargin = 0;
                	var fMarginPercentage = 0;
                	
                	if(obj != null) {
                		fUnitPrice = parseFloat(obj.unit);               	
                		fSalePrice = parseFloat(obj.sale);
                		fPrice = parseFloat(obj.price);
                		
                		fMargin = fSalePrice - fUnitPrice;
                		if(fMargin > 0)
                		fMarginPercentage = ((fMargin * 100) / fUnitPrice);
                	}
                	
                	//var currentOrderProductDiv = e.currentTarget.parentElement.parentElement.parentElement;
                	// cost = Unit Price
                	$(document.getElementById("unitprice")).val(obj.unit);
                	
                	// default = Price
                	$(document.getElementById("price")).val(obj.price);
                	
                	// Margin = Sale Price - Unit Price                	
                	// $(currentOrderProductDiv.getElementsByClassName("mask_currency")[0]).val(fMargin);
                	$(document.getElementById("marginpound")).val(fMargin);
                	
                	// Margin % = Margin * 100 / Unit Price                	
                	$(document.getElementById("marginpercentage")).val(fMarginPercentage);
                	
                }
            });
            
        });
        
        $('#qty').change(function(e){        
        	// debugger;
        	//var qty 	= document.getElementById("qty").value;
        	var qty = e.currentTarget.valueAsNumber;
        	var product = document.getElementById("CustomerOrderProduct_Id").value;
        	
            $.ajax({
                type: "POST",
                url: "/balance/Getsalesprice/" + product + "/" + qty,
                data: { price: $this.val() },
                success:function(data){
                	
                	// last = Sale Price
                	$(document.getElementById("salesprice")).val(data);
                	
                	
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