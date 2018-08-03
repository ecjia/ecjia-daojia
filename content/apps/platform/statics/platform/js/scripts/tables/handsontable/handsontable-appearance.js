/*=========================================================================================
    File Name: handsontable-appearance.js
    Description: Handsontable Appearance.
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

document.addEventListener("DOMContentLoaded", function() {

    /************************************
     *      Conditional formatting       *
     ************************************/

    var data = [
            ['', 'Kia', 'Nissan', 'Toyota', 'Honda'],
            ['2014', -5, '', 12, 13],
            ['2015', '', -11, 14, 13],
            ['2016', '', 15, -12, 'readOnly']
        ],
        container,
        hot1;

    function firstRowRenderer(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.fontWeight = 'bold';
        td.style.color = 'green';
        td.style.background = '#CEC';
    }

    function negativeValueRenderer(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);

        // if row contains negative number
        if (parseInt(value, 10) < 0) {
            // add class "negative"
            td.className = 'make-me-red';
        }

        if (!value || value === '') {
            td.style.background = '#EEE';
        } else {
            if (value === 'Nissan') {
                td.style.fontStyle = 'italic';
            }
            td.style.background = '';
        }
    }
    // maps function to lookup string
    Handsontable.renderers.registerRenderer('negativeValueRenderer', negativeValueRenderer);

    container = document.getElementById('formatting');
    hot1 = new Handsontable(container, {
        data: data,
        afterSelection: function(row, col, row2, col2) {
            var meta = this.getCellMeta(row2, col2);

            if (meta.readOnly) {
                this.updateSettings({ fillHandle: false });
            } else {
                this.updateSettings({ fillHandle: true });
            }
        },
        cells: function(row, col, prop) {
            var cellProperties = {};

            if (row === 0 || this.instance.getData()[row][col] === 'readOnly') {
                cellProperties.readOnly = true; // make cell read-only if it is first row or the text reads 'readOnly'
            }
            if (row === 0) {
                cellProperties.renderer = firstRowRenderer; // uses function directly
            } else {
                cellProperties.renderer = "negativeValueRenderer"; // uses lookup map
            }

            return cellProperties;
        }
    });

    /*********************************
     *      Customizing borders       *
     *********************************/

    var container = document.getElementById('borders'),
        hot;

    hot = Handsontable(container, {
        data: Handsontable.helper.createSpreadsheetData(70, 20),
        rowHeaders: true,
        fixedColumnsLeft: 2,
        fixedRowsTop: 2,
        colHeaders: true,
        customBorders: [{
            range: {
                from: {
                    row: 1,
                    col: 1
                },
                to: {
                    row: 3,
                    col: 4
                }
            },
            top: {
                width: 2,
                color: '#5292F7'
            },
            left: {
                width: 2,
                color: 'orange'
            },
            bottom: {
                width: 2,
                color: 'red'
            },
            right: {
                width: 2,
                color: 'magenta'
            }
        }, {
            row: 2,
            col: 2,
            left: {
                width: 2,
                color: 'red'
            },
            right: {
                width: 1,
                color: 'green'
            }
        }]
    });


    /************************************
     *      Highlighting selection       *
     ************************************/

    function getCarData() {
        return [
            ["Nissan", 2012, "black", "black"],
            ["Nissan", 2013, "blue", "blue"],
            ["Chrysler", 2014, "yellow", "black"],
            ["Volvo", 2015, "white", "gray"]
        ];
    }

    var data = [
            ['', 'Kia', 'Nissan', 'Toyota', 'Honda'],
            ['2013', 10, 11, 12, 13],
            ['2014', 20, 11, 14, 13],
            ['2015', 30, 15, 12, 13]
        ],
        container = document.getElementById('highlighting'),
        hot;

    hot = Handsontable(container, {
        data: data,
        minRows: 5,
        minCols: 6,
        currentRowClassName: 'currentRow',
        currentColClassName: 'currentCol',
        rowHeaders: true,
        colHeaders: true
    });

    hot.selectCell(2, 2);

    function bindDumpButton() {
        if (typeof Handsontable === "undefined") {
            return;
        }

        Handsontable.Dom.addEvent(document.body, 'click', function(e) {

            var element = e.target || e.srcElement;

            if (element.nodeName == "BUTTON" && element.name == 'dump') {
                var name = element.getAttribute('data-dump');
                var instance = element.getAttribute('data-instance');
                var hot = window[instance];
                console.log('data of ' + name, hot.getData());
            }

            bindDumpButton();

        });
    }

    /*********************************
     *      Mobiles and tablets       *
     *********************************/

    var containerMobilesTablets = document.getElementById('mobilesTablets'),
        hotMobilesTablets;

    hotMobilesTablets = new Handsontable(containerMobilesTablets, {
        data: Handsontable.helper.createSpreadsheetData(100, 100),
        rowHeaders: true,
        colHeaders: true,
        fixedRowsTop: 2,
        fixedColumnsLeft: 2
    });


});
