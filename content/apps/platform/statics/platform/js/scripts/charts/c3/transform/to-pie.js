/*=========================================================================================
    File Name: to-pie.js
    Description: c3 to pie transform chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// To Pie Transfrom chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the to pie transform chart, passes in the data and draws it.
    var toPieTranform = c3.generate({
        bindto: "#to-pie",
        size: {height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 130, 100, 140, 200, 150, 50]
            ]
        }
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function () {
        toPieTranform.transform('pie');
    }, 1000);

    setTimeout(function () {
        toPieTranform.transform('line');
    }, 2000);

    setTimeout(function () {
        toPieTranform.transform('pie');
    }, 3000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        toPieTranform.resize();
    });
});