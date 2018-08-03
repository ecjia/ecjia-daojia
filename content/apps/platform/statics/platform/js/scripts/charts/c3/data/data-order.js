/*=========================================================================================
    File Name: data order.js
    Description: c3 data order chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Data Order chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the data order chart, passes in the data and draws it.
    var dataOrder = c3.generate({
        bindto: '#data-order',
        size: {height:400},
        color: {
            pattern: ['#99B898','#FECEA8', '#FF847C', '#E84A5F', '#2A363B']
        },

        // Create the data table.
        data: {
            columns: [
                ['data1', 130, 200, 320, 400, 530, 750],
                ['data2', -130, 10, 130, 200, 150, 250],
                ['data3', -130, -50, -10, -200, -250, -150]
            ],
            type: 'bar',
            groups: [
                ['data1', 'data2', 'data3']
            ],
            order: 'desc' // stack order by sum of values descendantly. this is default.
    //      order: 'asc'  // stack order by sum of values ascendantly.
    //      order: null   // stack order by data definition.
        },
        grid: {
            x: {
                show: true
            }
        }
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function () {
        dataOrder.load({
            columns: [
                ['data4', 1200, 1300, 1450, 1600, 1520, 1820],
            ]
        });
    }, 1000);

    setTimeout(function () {
        dataOrder.load({
            columns: [
                ['data5', 200, 300, 450, 600, 520, 820],
            ]
        });
    }, 2000);

    setTimeout(function () {
        dataOrder.groups([['data1', 'data2', 'data3', 'data4', 'data5']]);
    }, 3000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        dataOrder.resize();
    });
});