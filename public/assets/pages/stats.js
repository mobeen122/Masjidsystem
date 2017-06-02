/**
 *  attendance stats
 */
var Stat = function() {

    return {
    	initEasyPieCharts: function() {
            if (!jQuery().easyPieChart) {
                return;
            }

            $('.easy-pie-chart .number.present').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 3,
                barColor: App.getBrandColor('green')
            });

            $('.easy-pie-chart .number.late').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 3,
                barColor: App.getBrandColor('yellow')
            });

            $('.easy-pie-chart .number.absent').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 3,
                barColor: App.getBrandColor('red')
            });

        },
        init: function() {
            this.initEasyPieCharts(); 
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
    	Stat.init(); 
    });
}