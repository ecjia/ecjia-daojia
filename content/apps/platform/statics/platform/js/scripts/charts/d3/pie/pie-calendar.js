/*=========================================================================================
    File Name: line.js
    Description: D3 simple line chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line chart
// ------------------------------
$(window).on("load", function(){

    // Revealing module pattern to store some global data that will be shared between different functions.
    var d3CalendarGlobals = function() {
        var ele = d3.select("#pie-calendar"),
            // calendarWidth = ele.node().getBoundingClientRect().width,
            calendarWidth = 1380,
            calendarHeight = 820,
            gridXTranslation = 10,
            gridYTranslation = 40,
            cellColorForCurrentMonth = '#EAEAEA',
            cellColorForPreviousMonth = '#FFFFFF',
            counter = 0, // Counter is used to keep track of the number of "back" and "forward" button presses and to calculate the month to display.
            currentMonth = new Date().getMonth(),
            monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datesGroup;

        function publicCalendarWidth() {
            return calendarWidth;
        }

        function publicCalendarHeight() {
            return calendarHeight;
        }

        function publicGridXTranslation() {
            return gridXTranslation;
        }

        function publicGridYTranslation() {
            return gridYTranslation;
        }

        function publicGridWidth() {
            return calendarWidth - 10;
        }

        function publicGridHeight() {
            return calendarHeight - 40;
        }

        function publicCellWidth() {
            return publicGridWidth() / 7;
        }

        function publicCellHeight() {
            return publicGridHeight() / 5;
        }

        function publicGetDatesGroup() {
            return datesGroup;
        }

        function publicSetDatesGroup(value) {
            datesGroup = value;
        }

        function publicIncrementCounter() {
            counter = counter + 1;
        }

        function publicDecrementCounter() {
            counter = counter - 1;
        }

        function publicMonthToDisplay() {
            var dateToDisplay = new Date();
            // We use the counter that keep tracks of "back" and "forward" presses to get the month to display.
            dateToDisplay.setMonth(currentMonth + counter);
            return dateToDisplay.getMonth();
        }

        function publicMonthToDisplayAsText() {
            return monthNames[publicMonthToDisplay()];
        }

        function publicYearToDisplay() {
            var dateToDisplay = new Date();
            // We use the counter that keep tracks of "back" and "forward" presses to get the year to display.
            dateToDisplay.setMonth(currentMonth + counter);
            return dateToDisplay.getFullYear();
        }

        function publicGridCellPositions() {

            // We store the top left positions of a 7 by 5 grid. These positions will be our reference points for drawing
            // various objects such as the rectangular grids, the text indicating the date etc.
            var cellPositions = [];
            for (y = 0; y < 5; y++) {
                for (x = 0; x < 7; x++) {
                    cellPositions.push([x * publicCellWidth(), y * publicCellHeight()]);
                }
            }

            return cellPositions;
        }

        // This function generates all the days of the month. But since we have a 7 by 5 grid, we also need to get some of
        // the days from the previous month and the next month. This way our grid will have all its cells filled. The days
        // from the previous or the next month will have a different color though. 
        function publicDaysInMonth() {
            var daysArray = [];

            var firstDayOfTheWeek = new Date(publicYearToDisplay(), publicMonthToDisplay(), 1).getDay();
            var daysInPreviousMonth = new Date(publicYearToDisplay(), publicMonthToDisplay(), 0).getDate();

            // Lets say the first week of the current month is a Wednesday. Then we need to get 3 days from 
            // the end of the previous month. But we can't naively go from 29 - 31. We have to do it properly
            // depending on whether the last month was one that had 31 days, 30 days or 28.
            for (i = 1; i <= firstDayOfTheWeek; i++) {
                daysArray.push([daysInPreviousMonth - firstDayOfTheWeek + i, cellColorForCurrentMonth]);
            }

            // These are all the days in the current month.
            var daysInMonth = new Date(publicYearToDisplay(), publicMonthToDisplay() + 1, 0).getDate();
            for (i = 1; i <= daysInMonth; i++) {
                daysArray.push([i, cellColorForPreviousMonth]);
            }

            // Depending on how many days we have so far (from previous month and current), we will need
            // to get some days from next month. We can do this naively though, since all months start on
            // the 1st.
            var daysRequiredFromNextMonth = 35 - daysArray.length;

            for (i = 1; i <= daysRequiredFromNextMonth; i++) {
                daysArray.push([i, cellColorForCurrentMonth]);
            }

            return daysArray.slice(0, 35);
        }

        return {
            calendarWidth: publicCalendarWidth(),
            calendarHeight: publicCalendarHeight(),
            gridXTranslation: publicGridXTranslation(),
            gridYTranslation: publicGridYTranslation(),
            gridWidth: publicGridWidth(),
            gridHeight: publicGridHeight(),
            cellWidth: publicCellWidth(),
            cellHeight: publicCellHeight(),
            getDatesGroup: publicGetDatesGroup,
            setDatesGroup: publicSetDatesGroup,
            incrementCounter: publicIncrementCounter,
            decrementCounter: publicDecrementCounter,
            monthToDisplay: publicMonthToDisplay(),
            monthToDisplayAsText: publicMonthToDisplayAsText,
            yearToDisplay: publicYearToDisplay,
            gridCellPositions: publicGridCellPositions(),
            daysInMonth: publicDaysInMonth
        }
    }();

    $(document).ready(function() {
        renderCalendarGrid();
        renderDaysOfMonth();
        $('#back').on('click',displayPreviousMonth);
        $('#forward').on('click',displayNextMonth);
    });

    function displayPreviousMonth() {
        // We keep track of user's "back" and "forward" presses in this counter
        d3CalendarGlobals.decrementCounter();
        renderDaysOfMonth();
    }

    function displayNextMonth() {
        // We keep track of user's "back" and "forward" presses in this counter
        d3CalendarGlobals.incrementCounter();
        renderDaysOfMonth();
    }

    // This function is responsible for rendering the days of the month in the grid.
    function renderDaysOfMonth(month, year) {
        $('#currentMonth').text(d3CalendarGlobals.monthToDisplayAsText() + ' ' + d3CalendarGlobals.yearToDisplay());
        // We get the days for the month we need to display based on the number of times the user has pressed
        // the forward or backward button.
        var daysInMonthToDisplay = d3CalendarGlobals.daysInMonth();
        var cellPositions = d3CalendarGlobals.gridCellPositions;

        // All text elements representing the dates in the month are grouped together in the "datesGroup" element by the initalizing
        // function below. The initializing function is also responsible for drawing the rectangles that make up the grid.
        d3CalendarGlobals.datesGroup
            .selectAll("text")
            .data(daysInMonthToDisplay)
            .attr("x", function(d, i) {
                return cellPositions[i][0];
            })
            .attr("y", function(d, i) {
                return cellPositions[i][1];
            })
            .attr("dx", 20) // right padding
            .attr("dy", 20) // vertical alignment : middle
            .attr("transform", "translate(" + d3CalendarGlobals.gridXTranslation + "," + d3CalendarGlobals.gridYTranslation + ")")
            .text(function(d) {
                return d[0];
            }); // Render text for the day of the week

        d3CalendarGlobals.calendar
            .selectAll("rect")
            .data(daysInMonthToDisplay)
            // Here we change the color depending on whether the day is in the current month, the previous month or the next month.
            // The function that generates the dates for any given month will also specify the colors for days that are not part of the
            // current month. We just have to use it to fill the rectangle
            .style("fill", function(d) {
                return d[1];
            });

        drawGraphsForMonthlyData();

    }

    function drawGraphsForMonthlyData() {
        // Get some random data
        var data = getDataForMonth();
        // Set up variables required to draw a pie chart
        var outerRadius = d3CalendarGlobals.cellWidth / 3;
        var innerRadius = 0;
        var pie = d3.layout.pie();
        // var color = d3.scale.category10();
        var color = d3.scale.ordinal()
        .range(["#99B898", "#FECEA8", "#FF847C", "#E84A5F", "#F8B195", "#F67280", "#C06C84"]);
        var arc = d3.svg.arc().innerRadius(innerRadius).outerRadius(outerRadius);

        // We need to index and group the pie charts and slices generated so that they can be rendered in
        // the appropriate cells. To do that, we call D3's 'pie' function of each of the data elements.
        var indexedPieData = [];
        for (i = 0; i < data.length; i++) {
            var pieSlices = pie(data[i]);
            // This loop is to store an index (j) for each of the slices of a given pie chart. Two different charts
            // on two different days will have the the same set of numbers for slices (eg: 0,1,2). This will help us
            // pick the same colors for the slices for two independent charts. Otherwise, the colors of the slices
            // will be different each day.
            for (j = 0; j < pieSlices.length; j++) {
                indexedPieData.push([pieSlices[j], i, j]);
            }
        }

        var cellPositions = d3CalendarGlobals.gridCellPositions;

        d3CalendarGlobals.chartsGroup
            .selectAll("g.arc")
            .remove();

        var arcs = d3CalendarGlobals.chartsGroup.selectAll("g.arc")
            // use the indexed data so that each pie chart can be draw in a different cell and therefore for a different day
            .data(indexedPieData)
            .enter()
            .append("g")
            .attr("class", "arc")
            .attr("transform", function(d) {
                // This is where we use the index here to translate the pie chart and rendere it in the appropriate cell. 
                // Normally, the chart would be squashed up against the top left of the cell, obscuring the text that shows the day of the month.
                // We use the gridXTranslation and gridYTranslation and multiply it by a factor to move it to the center of the cell. There is probably
                // a better way of doing this though.
                var currentDataIndex = d[1];
                return "translate(" + (outerRadius + d3CalendarGlobals.gridXTranslation * 5 + cellPositions[currentDataIndex][0]) + ", " + (outerRadius + d3CalendarGlobals.gridYTranslation * 1.25 + cellPositions[currentDataIndex][1]) + ")";
            });

        arcs.append("path")
            .attr("fill", function(d, i) {
                // The color is generated using the second index. Each slice of the pie is given a fixed number. This applies to all charts (see the indexing loop above).
                // This way, by using the index we can generate teh same colors for each of the slices for different charts on different days.
                return color(d[2]);
            })
            .attr("d", function(d, i) {
                // Standard functions for drawing a pie charts in D3.
                return arc(d[0]);
            });

        arcs.append("text")
            .attr("transform", function(d, i) {
                // Standard functions for drawing a pie charts in D3.
                return "translate(" + arc.centroid(d[0]) + ")";
            })
            .attr("text-anchor", "middle")
            .text(function(d, i) {
                return d[0].value;
            })
            .style("fill", "#FFF");

    }

    // Generates some random data that can be used to draw pie charts.
    function getDataForMonth() {
        var randomData = [];
        for (var i = 0; i < 35; i++) {
            randomData.push([Math.floor(Math.random() * 100), Math.floor(Math.random() * 100), Math.floor(Math.random() * 100)]);
        }
        return randomData;
    }

    // This is the initializing function. It adds an svg element, draws a set of rectangles to form the calendar grid,
    // puts text in each cell representing the date and does the initial rendering of the pie charts.
    function renderCalendarGrid(month, year) {

        // Add the svg element.
        d3CalendarGlobals.calendar = d3.select("#pie-calendar")
            .append("svg")
            .attr("class", "calendar")
            .attr("width", d3CalendarGlobals.calendarWidth)
            .attr("height", d3CalendarGlobals.calendarHeight)
            .append("g");

        // Cell positions are generated and stored globally because they are used by other functions as a reference to render different things.
        var cellPositions = d3CalendarGlobals.gridCellPositions;

        // Draw rectangles at the appropriate postions, starting from the top left corner. Since we want to leave some room for the heading and buttons,
        // use the gridXTranslation and gridYTranslation variables.
        d3CalendarGlobals.calendar.selectAll("rect")
            .data(cellPositions)
            .enter()
            .append("rect")
            .attr("x", function(d) {
                return d[0];
            })
            .attr("y", function(d) {
                return d[1];
            })
            .attr("width", d3CalendarGlobals.cellWidth)
            .attr("height", d3CalendarGlobals.cellHeight)
            .style("stroke", "#555")
            .style("fill", "white")
            .attr("transform", "translate(" + d3CalendarGlobals.gridXTranslation + "," + d3CalendarGlobals.gridYTranslation + ")");

        var daysOfTheWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        // This adds the day of the week headings on top of the grid
        d3CalendarGlobals.calendar.selectAll("headers")
            .data([0, 1, 2, 3, 4, 5, 6])
            .enter().append("text")
            .attr("x", function(d) {
                return cellPositions[d][0];
            })
            .attr("y", function(d) {
                return cellPositions[d][1];
            })
            .attr("dx", d3CalendarGlobals.gridXTranslation + 5) // right padding
            .attr("dy", 30) // vertical alignment : middle
            .text(function(d) {
                return daysOfTheWeek[d]
            });

        // The intial rendering of the dates for the current mont inside each of the cells in the grid. We create a named group ("datesGroup"),
        // and add our dates to this group. This group is also stored globally. Later on, when the the user presses the back and forward buttons
        // to navigate between the months, we clear and re add the new text elements to this group
        d3CalendarGlobals.datesGroup = d3CalendarGlobals.calendar.append("svg:g");
        var daysInMonthToDisplay = d3CalendarGlobals.daysInMonth();
        d3CalendarGlobals.datesGroup
            .selectAll("daysText")
            .data(daysInMonthToDisplay)
            .enter()
            .append("text")
            .attr("x", function(d, i) {
                return cellPositions[i][0];
            })
            .attr("y", function(d, i) {
                return cellPositions[i][1];
            })
            .attr("dx", 20) // right padding
            .attr("dy", 20) // vertical alignment : middle
            .attr("transform", "translate(" + d3CalendarGlobals.gridXTranslation + "," + d3CalendarGlobals.gridYTranslation + ")")
            .text(function(d) {
                return d[0];
            });

        // Create a new svg group to store the chart elements and store it globally. Again, as the user navigates through the months by pressing 
        // the "back" and "forward" buttons on the page, we clear the chart elements from this group and re add them again.
        d3CalendarGlobals.chartsGroup = d3CalendarGlobals.calendar.append("svg:g");
        // Call the function to draw the charts in the cells. This will be called again each time the user presses the forward or backward buttons.
        drawGraphsForMonthlyData();
    }

    // Resize chart
    // ------------------------------

    // Call function on window resize
    $(window).on('resize', resize);

    // Call function on sidebar width change
    $('.menu-toggle').on('click', resize);

    // Resize function
    // ------------------------------
    function resize() {

        width = ele.node().getBoundingClientRect().width - margin.left - margin.right;

        // Main svg width
        container.attr("width", width + margin.left + margin.right);

        // Width of appended group
        svg.attr("width", width + margin.left + margin.right);


        // Axis
        // -------------------------
        x.range([0, width]);
        svg.selectAll('.d3-xaxis').call(xAxis);


        svg.selectAll('.d3-line').attr("d", line);
    }
});