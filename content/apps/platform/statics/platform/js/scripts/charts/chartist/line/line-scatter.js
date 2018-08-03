/*=========================================================================================
    File Name: line-scatter.js
    Description: Chartist line scatter chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line scatter chart
// ------------------------------
$(window).on("load", function(){

    var times = function(n) {
        return Array.apply(null, new Array(n));
    };

    var data = times(52).map(Math.random).reduce(function(data, rnd, index) {
        data.labels.push(index + 1);
        data.series.forEach(function(series) {
            series.push(Math.random() * 100);
        });

        return data;
    }, {
        labels: [],
        series: times(4).map(function() { return new Array() })
    });

    var options = {
        showLine: false,
        axisX: {
            labelInterpolationFnc: function(value, index) {
                return index % 13 === 0 ? 'W' + value : null;
            }
        }
    };

    var responsiveOptions = [
        ['screen and (min-width: 640px)', {
            axisX: {
                labelInterpolationFnc: function(value, index) {
                    return index % 4 === 0 ? 'W' + value : null;
                }
            }
        }]
    ];

    new Chartist.Line('#line-scatter', data, options, responsiveOptions);
});