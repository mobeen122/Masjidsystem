/**
 * 
 */
var collEntities = [];
        var collActivities = [];
        var app = angular.module('myApp', ['ngSanitize']);
    	
        function LocalFixed(value) {
        	if(value.toString().indexOf(".00") != -1)
        		return Math.round(value);
        	
        	return value;
        }
        
        app.controller('myCtrl', function ($scope, $http, $timeout, $sce) {
            // debugger;
            $scope.orderByField = 'Category';
            
            $scope.reverseSort = false;
            $scope.list =[];
            
            var iDeliveryRouteId = document.getElementById("delivery_id").value;
            $scope.strUrl = "/api/routebreakdownapi/" + iDeliveryRouteId;
            // alert($scope.strUrl);

            $http.get($scope.strUrl)
            .then(function (response) {                
                $scope.list = response.data;
                
                debugger;
                $scope.Data = [];
                console.log("RAW JSON: " + JSON.stringify($scope.list));

                for (var i = 0; i < $scope.list.length; i++) {
                    var temp = [];

                    var res = alasql('SELECT product_name, qty, show_details, unit_name, group_name, units_in_group, count(product_name) AS [count] \
                                            FROM ? \
                                            GROUP BY product_name, qty, show_details, unit_name, group_name, units_in_group \
                                            ORDER BY product_name DESC', [$scope.list[i].Products]);

                    console.log("Group By JSON - 1: " + JSON.stringify(res));

                    for (var j = res.length - 1; j >= 0; j--) {
                        res[j].qty = LocalFixed(parseFloat(res[j].qty).toFixed(2));

                        for (var k = j - 1; k >= 0; k--) {
                            if (j > 0) {
                                if (res[j].show_details.toLowerCase() == "n" && res[k].show_details.toLowerCase() == "n"
                                    && res[j].product_name.toLowerCase() == res[k].product_name.toLowerCase()) {

                                    // Get Quantity
                                    res[j].qty = ((parseFloat(res[j].qty) * parseFloat(res[j].count)) +
                                                 (parseFloat(res[k].qty) * parseFloat(res[k].count))).toFixed(2);

                                    // Set Count
                                    res[j].count = 1;

                                    var index = res.indexOf(res[k]);
                                    if (index > -1) {
                                        res.splice(index, 1);
                                        j--;
                                    }
                                }
                            }
                        }
                    }
                    console.log("Converted JSON - 1: " + JSON.stringify(res));

                    var objGroupWithDetails = [];
                    var resGroupWithDetails =
                            alasql('SELECT (product_name + "-" + show_details) AS [ProductName], SUM(qty::NUMBER * [count]) AS [Total], count(product_name + "-" + show_details) AS [count] \
                                    FROM ? \
                                    GROUP BY (product_name + "-" + show_details) \
                                    ORDER BY (product_name + "-" + show_details)', [res]);


                    for (var k = 0; k < resGroupWithDetails.length; k++) {
                        var iIndex = resGroupWithDetails[k].ProductName.lastIndexOf("-");
                        var ProductName = resGroupWithDetails[k].ProductName.substr(0, iIndex);
                        var ShowDetails = resGroupWithDetails[k].ProductName.substr(iIndex + 1);
                        // alert(ProductName + " " + ShowDetails);

                        var Items =
                            alasql('SELECT * \
                                    FROM ? \
                                    WHERE product_name = "' + ProductName + '" AND show_details = "' + ShowDetails + '" \
                                    ORDER BY qty', [res]);


                        debugger;
                        var fUnuitInGroup = 0;
                        if (Items[0].units_in_group != "" && Items[0].units_in_group != null)
                            fUnuitInGroup = parseFloat(Items[0].units_in_group);

                        var fDivide = 0;
                        if (fUnuitInGroup > 0)
                            fDivide = parseFloat(resGroupWithDetails[k].Total) / fUnuitInGroup;

                        var iMod = 0;
                        if (fUnuitInGroup > 0)
                            iMod = parseFloat(resGroupWithDetails[k].Total) % fUnuitInGroup;

                        var srtMessage_GroupName = "";
                        if (fDivide >= 1)
                            srtMessage_GroupName = parseInt(fDivide).toString() + " " + Items[0].group_name;

                        var srtMessage_UnitName = "";
                        if (iMod > 0) {
                        	if (srtMessage_GroupName != "")
                                srtMessage_UnitName = ", "
                            srtMessage_UnitName += iMod.toString() + " " + Items[0].unit_name;
                        }

                        var itemProduct = {
                            'ProductName': ProductName,
                            'ShowDetails': ShowDetails,
                            'Total': resGroupWithDetails[k].Total,
                            'Quantity': resGroupWithDetails[k].count,
                            'UnitName': Items[0].unit_name,
                            'GroupName': Items[0].group_name,
                            'UnitsInGroup': Items[0].units_in_group,
                            'Message_GroupName': srtMessage_GroupName,
                            'Message_UnitName': srtMessage_UnitName,
                            'Message': "",
                            'Items': Items,
                        };

                        objGroupWithDetails.push(itemProduct);
                    }
                    console.log("objGroupWithDetails JSON - 1: " + JSON.stringify(objGroupWithDetails));

                    debugger;
                    var item = {
                        'Category': $scope.list[i].Category,
                        'Products': objGroupWithDetails,
                    };

                    $scope.Data.push(item);
                }
                console.log("Final JSON: " + JSON.stringify($scope.Data));

                                
            }, function (response) {
                $scope.content = "Something went wrong";
            });            

            $scope.deliberatelyTrustDangerousSnippet = function () {
                return $sce.trustAsHtml($scope.snippet);
            };

            // This function will be called when use the Filters - Type text is Searchbox
            $scope.filter = function () {
                $timeout(function () {
                    var a = document.getElementsByName("divDesc");
                    // alert(a.length);

                    for (var i = 0; i < a.length; i++) {
                        a[i].innerHTML = a[i].attributes["value"].value;
                    }
                }, 10);
            };

            $scope.navigateToRec = function (strEntityName, recordId) {
                // Open in new Window
                var strUrl = Xrm.Page.context.getClientUrl() + "/main.aspx?etn=" + strEntityName.toLowerCase() + "&pagetype=entityrecord&id=%7B" + recordId + "%7D";
                window.open(strUrl, "", "width=800,height=800");

                // Open in same window
                // Xrm.Utility.openEntityForm("dodd_eig_budget", recordId);
                // alert(recordId);
            };

            $scope.OpenEntityRecord = function (Id, RegardingObjectId) {
                alert("Open new Window... Coming soon.");
            };

            $scope.reLoadPage = function () {
                alert();
                window.location.reload();
            };
        });