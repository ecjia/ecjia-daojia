/*=========================================================================================
    File Name: handsontable-utilities.js
    Description: Handsontable Utilities.
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/

document.addEventListener("DOMContentLoaded", function() {

    /***********************************************
     *      Context menu with default options       *
     ***********************************************/

    function getData() {
        return [
            ['', 'Kia', 'Nissan', 'Toyota', 'Honda', 'Mazda', 'Ford'],
            ['2012', 10, 11, 12, 13, 15, 16],
            ['2013', 10, 11, 12, 13, 15, 16],
            ['2014', 10, 11, 12, 13, 15, 16],
            ['2015', 10, 11, 12, 13, 15, 16],
            ['2016', 10, 11, 12, 13, 15, 16]
        ];
    }

    var
        example1 = document.getElementById('context'),
        settings1,
        hot1;

    settings1 = {
        data: getData(),
        rowHeaders: true,
        colHeaders: true,
        contextMenu: true
    };
    hot1 = new Handsontable(example1, settings1);


    /**********************************************************
     *      Context menu with fully custom configuration       *
     **********************************************************/


    function getCustomData() {
        return [
            ['', 'Kia', 'Nissan', 'Toyota', 'Honda', 'Mazda', 'Ford'],
            ['2012', 10, 11, 12, 13, 15, 16],
            ['2013', 10, 11, 12, 13, 15, 16],
            ['2014', 10, 11, 12, 13, 15, 16],
            ['2015', 10, 11, 12, 13, 15, 16],
            ['2016', 10, 11, 12, 13, 15, 16]
        ];
    }

    var
        example3 = document.getElementById('configuration'),
        settings3,
        hot3;

    settings3 = {
        data: getCustomData(),
        rowHeaders: true,
        colHeaders: true
    };
    hot3 = new Handsontable(example3, settings3);

    hot3.updateSettings({
        contextMenu: {
            callback: function(key, options) {
                if (key === 'about') {
                    setTimeout(function() {
                        // timeout is used to make sure the menu collapsed before alert is shown
                        alert("This is a context menu with default and custom options mixed");
                    }, 100);
                }
            },
            items: {
                "row_above": {
                    disabled: function() {
                        // if first row, disable this option
                        return hot3.getSelected()[0] === 0;
                    }
                },
                "row_below": {},
                "hsep1": "---------",
                "remove_row": {
                    name: 'Remove this row, ok?',
                    disabled: function() {
                        // if first row, disable this option
                        return hot3.getSelected()[0] === 0
                    }
                },
                "hsep2": "---------",
                "about": { name: 'About this menu' }
            }
        }
    })

    /**************************************
     *      Copy-paste configuration       *
     **************************************/


    function getData() {
        return [
            ['', 'Kia', 'Nissan', 'Toyota', 'Honda', 'Mazda', 'Ford'],
            ['2012', 10, 11, 12, 13, 15, 16],
            ['2013', 10, 11, 12, 13, 15, 16],
            ['2014', 10, 11, 12, 13, 15, 16],
            ['2015', 10, 11, 12, 13, 15, 16],
            ['2016', 10, 11, 12, 13, 15, 16]
        ];
    }

    var
        copyPaste = document.getElementById('copyPaste'),
        hot4;

    hot4 = new Handsontable(copyPaste, {
        data: getData(),
        rowHeaders: true,
        colHeaders: true,
        contextMenu: true,
        contextMenuCopyPaste: {
            swfPath: '/bower_components/zeroclipboard/dist/ZeroClipboard.swf'
        }
    });



    /****************************
     *      Custom buttons       *
     ****************************/


    var
        data = [
            ['', 'Kia', 'Nissan', 'Toyota', 'Honda', 'Mazda', 'Ford'],
            ['2012', 10, 11, 12, 13, 15, 16],
            ['2013', 10, 11, 12, 13, 15, 16],
            ['2014', 10, 11, 12, 13, 15, 16],
            ['2015', 10, 11, 12, 13, 15, 16],
            ['2016', 10, 11, 12, 13, 15, 16]
        ],
        container = document.getElementById('buttons'),
        selectFirst = document.getElementById('selectFirst'),
        rowHeaders = document.getElementById('rowHeaders'),
        colHeaders = document.getElementById('colHeaders'),
        hot;

    hot = new Handsontable(container, {
        rowHeaders: true,
        colHeaders: true,
        outsideClickDeselects: false,
        removeRowPlugin: true
    });
    hot.loadData(data);

    Handsontable.Dom.addEvent(selectFirst, 'click', function() {
        hot.selectCell(0, 0);
    });
    Handsontable.Dom.addEvent(rowHeaders, 'click', function() {
        hot.updateSettings({
            rowHeaders: this.checked
        });
    });
    Handsontable.Dom.addEvent(colHeaders, 'click', function() {
        hot.updateSettings({
            colHeaders: this.checked
        });
    });

    /**********************
     *      Comments       *
     **********************/

    function getData() {
        return [
            ['', 'Kia', 'Nissan', 'Toyota', 'Honda', 'Mazda', 'Ford'],
            ['2012', 10, 11, 12, 13, 15, 16],
            ['2013', 10, 11, 12, 13, 15, 16],
            ['2014', 10, 11, 12, 13, 15, 16],
            ['2015', 10, 11, 12, 13, 15, 16],
            ['2016', 10, 11, 12, 13, 15, 16]
        ];
    }

    var container = document.getElementById('comments'),
        hot1;

    hot1 = new Handsontable(container, {
        data: getData(),
        rowHeaders: true,
        colHeaders: true,
        contextMenu: true,
        comments: true,
        cell: [
            { row: 1, col: 1, comment: 'Some comment' },
            { row: 2, col: 2, comment: 'More comments' }
        ]
    });
});