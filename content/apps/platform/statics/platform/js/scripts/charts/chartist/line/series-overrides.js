/*=========================================================================================
    File Name: series-overrides.js
    Description: Chartist series overrides chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Series overrides chart
// ------------------------------
$(window).on("load", function(){

    var chart = new Chartist.Line('#series-overrides', {
        labels: ['1', '2', '3', '4', '5', '6', '7', '8'],
        // Naming the series with the series object array notation
        series: [{
            name: 'series-1',
            data: [5, 2, -4, 2, 0, -2, 5, -3]
        }, {
            name: 'series-2',
            data: [4, 3, 5, 3, 1, 3, 6, 4]
        }, {
            name: 'series-3',
            data: [2, 4, 3, 1, 4, 5, 3, 2]
        }]
    }, {
        fullWidth: true,
        // Within the series options you can use the series names
        // to specify configuration that will only be used for the
        // specific series.
        series: {
            'series-1': {
                lineSmooth: Chartist.Interpolation.step()
            },
            'series-2': {
                lineSmooth: Chartist.Interpolation.simple(),
                showArea: true
            },
            'series-3': {
                showPoint: false
            }
        }
    }, [
        // You can even use responsive configuration overrides to
        // customize your series configuration even further!
        ['screen and (max-width: 320px)', {
            series: {
                'series-1': {
                    lineSmooth: Chartist.Interpolation.none()
                },
                'series-2': {
                    lineSmooth: Chartist.Interpolation.none(),
                    showArea: false
                },
                'series-3': {
                    lineSmooth: Chartist.Interpolation.none(),
                    showPoint: true
                }
            }
        }]
    ]);

});