/*=========================================================================================
    File Name: error-bars.js
    Description: Flot error bars chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Error bars chart
// ------------------------------
$(window).on("load", function(){

    function drawArrow(ctx, x, y, radius){
        ctx.beginPath();
        ctx.moveTo(x + radius, y + radius);
        ctx.lineTo(x, y);
        ctx.lineTo(x - radius, y + radius);
        ctx.stroke();
    }

    function drawSemiCircle(ctx, x, y, radius){
        ctx.beginPath();
        ctx.arc(x, y, radius, 0, Math.PI, false);
        ctx.moveTo(x - radius, y);
        ctx.lineTo(x + radius, y);
        ctx.stroke();
    }

    var data1 = [
        [1,1,.5,.1,.3],
        [2,2,.3,.5,.2],
        [3,3,.9,.5,.2],
        [1.5,-.05,.5,.1,.3],
        [3.15,1.,.5,.1,.3],
        [2.5,-1.,.5,.1,.3]
    ];

    var data1_points = {
        show: true,
        radius: 5,
        fillColor: "blue",
        errorbars: "xy",
        xerr: {show: true, asymmetric: true, upperCap: "-", lowerCap: "-"},
        yerr: {show: true, color: "#DA4453", upperCap: "-"}
    };

    var data2 = [
        [.7,3,.2,.4],
        [1.5,2.2,.3,.4],
        [2.3,1,.5,.2]
    ];

    var data2_points = {
        show: true,
        radius: 5,
        errorbars: "y",
        yerr: {show:true, asymmetric:true, upperCap: drawArrow, lowerCap: drawSemiCircle}
    };

    var data3 = [
        [1,2,.4],
        [2,0.5,.3],
        [2.7,2,.5]
    ];

    var data3_points = {
        //do not show points
        radius: 0,
        errorbars: "y",
        yerr: {show:true, upperCap: "-", lowerCap: "-", radius: 5}
    };

    var data4 = [
        [1.3, 1],
        [1.75, 2.5],
        [2.5, 0.5]
    ];

    var data4_errors = [0.1, 0.4, 0.2];
    for (var i = 0; i < data4.length; i++) {
        data4_errors[i] = data4[i].concat(data4_errors[i])
    }

    var data = [
        {color: "#00A5A8", points: data1_points, data: data1, label: "data1"},
        {color: "#626E82",  points: data2_points, data: data2, label: "data2"},
        {color: "#FF7D4D", lines: {show: true}, points: data3_points, data: data3, label: "data3"},
        // bars with errors
        {color: "#FF4558", bars: {show: true, align: "center", barWidth: 0.25}, data: data4, label: "data4"},
        {color: "#FF4558", points: data3_points, data: data4_errors}
    ];

    $.plot($("#error-bars"), data , {
        legend: {
            position: "sw",
            show: true
        },
        series: {
            lines: {
                show: false
            }
        },
        xaxis: {
            min: 0.6,
            max: 3.1
        },
        yaxis: {
            min: 0,
            max: 3.5
        },
        zoom: {
            interactive: true
        },
        pan: {
            interactive: true
        },
        grid: {
            borderWidth: 1,
            borderColor: "#e9e9e9",
            color: '#999',
            minBorderMargin: 20,
            labelMargin: 10,
            margin: {
                top: 8,
                bottom: 20,
                left: 20
            },
        },
    });
});