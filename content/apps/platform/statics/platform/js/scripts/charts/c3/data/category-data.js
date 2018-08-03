/*=========================================================================================
    File Name: category-data.js
    Description: c3 category data chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Category Data Chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the category data chart, passes in the data and draws it.
    var categoryData = c3.generate({
        bindto: '#category-data',
        size: {height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            x : 'x',
            columns: [
                ['x', 'www.site1.com', 'www.site2.com', 'www.site3.com', 'www.site4.com'],
                ['download', 30, 200, 100, 400],
                ['loading', 90, 100, 140, 200],
            ],
            groups: [
                ['download', 'loading']
            ],
            type: 'bar'
        },
        axis: {
            x: {
                type: 'category' // this needed to load string x value
            }
        },
        grid: {
            y: {
                show: true
            }
        },
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function () {
        categoryData.load({
            columns: [
                ['x', 'www.siteA.com', 'www.siteB.com', 'www.siteC.com', 'www.siteD.com'],
                ['download', 130, 200, 150, 350],
                ['loading', 190, 180, 190, 140],
            ],
        });
    }, 1000);

    setTimeout(function () {
        categoryData.load({
            columns: [
                ['x', 'www.siteE.com', 'www.siteF.com', 'www.siteG.com'],
                ['download', 30, 300, 200],
                ['loading', 90, 130, 240],
            ],
        });
    }, 2000);

    setTimeout(function () {
        categoryData.load({
            columns: [
                ['x', 'www.site1.com', 'www.site2.com', 'www.site3.com', 'www.site4.com'],
                ['download', 130, 300, 200, 470],
                ['loading', 190, 130, 240, 340],
            ],
        });
    }, 3000);

    setTimeout(function () {
        categoryData.load({
            columns: [
                ['download', 30, 30, 20, 170],
                ['loading', 90, 30, 40, 40],
            ],
        });
    }, 4000);

    setTimeout(function () {
        categoryData.load({
            url: '../../../app-assets/data/c3/c3_string_x.csv'
        });
    }, 5000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        categoryData.resize();
    });
});