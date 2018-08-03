/*=========================================================================================
    File Name: handsontable-cell-types.js
    Description: Handsontable Cell Types.
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

document.addEventListener("DOMContentLoaded", function() {

    /********************************************
     *      Rendering custom HTML in cells       *
     ********************************************/

    var
        data = [{
            title: "<a href='http://www.amazon.com/Professional-JavaScript-Developers-Nicholas-Zakas/dp/1118026691'>Professional JavaScript for Web Developers</a>",
            description: "This <a href='http://bit.ly/sM1bDf'>book</a> provides a developer-level introduction along with more advanced and useful features of <b>JavaScript</b>.",
            comments: "I would rate it &#x2605;&#x2605;&#x2605;&#x2605;&#x2606;",
            cover: "http://ecx.images-amazon.com/images/I/51bRhyVTVGL._SL50_.jpg"
        }, {
            title: "<a href='http://shop.oreilly.com/product/9780596517748.do'>JavaScript: The Good Parts</a>",
            description: "This book provides a developer-level introduction along with <b>more advanced</b> and useful features of JavaScript.",
            comments: "This is the book about JavaScript",
            cover: "http://ecx.images-amazon.com/images/I/51gdVAEfPUL._SL50_.jpg"
        }, {
            title: "<a href='http://shop.oreilly.com/product/9780596805531.do'>JavaScript: The Definitive Guide</a>",
            description: "<em>JavaScript: The Definitive Guide</em> provides a thorough description of the core <b>JavaScript</b> language and both the legacy and standard DOMs implemented in web browsers.",
            comments: "I've never actually read it, but the <a href='http://shop.oreilly.com/product/9780596805531.do'>comments</a> are highly <strong>positive</strong>.",
            cover: "http://ecx.images-amazon.com/images/I/51VFNL4T7kL._SL50_.jpg"
        }],
        container1,
        hot1;

    container1 = document.getElementById('rendering');
    hot1 = new Handsontable(container1, {
        data: data,
        colWidths: [200, 200, 200, 80],
        colHeaders: ["Title", "Description", "Comments", "Cover"],
        columns: [
            { data: "title", renderer: "html" },
            { data: "description", renderer: "html" },
            { data: "comments", renderer: safeHtmlRenderer },
            { data: "cover", renderer: coverRenderer }
        ]
    });

    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    function strip_tags(input, allowed) {
        var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
            commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;

        // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
        allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

        return input.replace(commentsAndPhpTags, '').replace(tags, function($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
        });
    }

    function safeHtmlRenderer(instance, td, row, col, prop, value, cellProperties) {
        var escaped = Handsontable.helper.stringify(value);
        escaped = strip_tags(escaped, '<em><b><strong><a><big>'); //be sure you only allow certain HTML tags to avoid XSS threats (you should also remove unwanted HTML attributes)
        td.innerHTML = escaped;

        return td;
    }

    function coverRenderer(instance, td, row, col, prop, value, cellProperties) {
        var escaped = Handsontable.helper.stringify(value),
            img;

        if (escaped.indexOf('http') === 0) {
            img = document.createElement('IMG');
            img.src = value;

            Handsontable.Dom.addEvent(img, 'mousedown', function(e) {
                e.preventDefault(); // prevent selection quirk
            });

            Handsontable.Dom.empty(td);
            td.appendChild(img);
        } else {
            // render as text
            Handsontable.renderers.TextRenderer.apply(this, arguments);
        }

        return td;
    }



    /*********************
     *      Numeric       *
     *********************/



    function getNumericData() {
        return [
            { car: "Mercedes A 160", year: 2011, price_usd: 7000, price_eur: 7000 },
            { car: "Citroen C4 Coupe", year: 2012, price_usd: 8330, price_eur: 8330 },
            { car: "Audi A4 Avant", year: 2013, price_usd: 33900, price_eur: 33900 },
            { car: "Opel Astra", year: 2014, price_usd: 5000, price_eur: 5000 },
            { car: "BMW 320i Coupe", year: 2015, price_usd: 30500, price_eur: 30500 }
        ];
    }

    var containerNumericData = document.getElementById('numericData'),
        hotNumericData;

    hotNumericData = new Handsontable(containerNumericData, {
        data: getNumericData(),
        colHeaders: ['Car', 'Year', 'Price ($)', 'Price (€)'],
        columns: [{
            data: 'car'
                // 1nd column is simple text, no special options here
        }, {
            data: 'year',
            type: 'numeric'
        }, {
            data: 'price_usd',
            type: 'numeric',
            format: '$0,0.00',
            language: 'en-US' // this is the default locale, set up for USD
        }, {
            data: 'price_eur',
            type: 'numeric',
            format: '0,0.00 $',
            language: 'de-DE' // i18n: use this for EUR (German)
                // more locales available on numeraljs.com
        }]
    });

    /******************
     *      Date       *
     ******************/

    function getDateData() {
        return [
            ["Mercedes", "A 160", "01/14/2012", 6999.9999],
            ["Citroen", "C4 Coupe", "12/01/2013", 8330],
            ["Audi", "A4 Avant", "11/19/2014", 33900],
            ["Opel", "Astra", "02/02/2015", 7000],
            ["BMW", "320i Coupe", "07/24/2016", 30500]
        ];
    }

    var
        containerDateData = document.getElementById('dateDate'),
        hotDateData;

    hotDateData = new Handsontable(containerDateData, {
        data: getDateData(),
        colHeaders: ['Car', 'Model', 'Registration date', 'Price'],
        columns: [{
            type: 'autocomplete',
            source: ['Audi', 'BMW', 'Chrysler', 'Citroen', 'Mercedes', 'Nissan', 'Opel', 'Suzuki', 'Toyota', 'Volvo'],
            strict: false
        }, {
            // 2nd cell is simple text, no special options here
        }, {
            type: 'date',
            dateFormat: 'MM/DD/YYYY',
            correctFormat: true,
            defaultDate: '01/01/1900',
            allowEmpty: false,
            // datePicker additional options (see https://github.com/dbushell/Pikaday#configuration)
            datePickerConfig: {
                // First day of the week (0: Sunday, 1: Monday, etc)
                firstDay: 0,
                showWeekNumber: true,
                numberOfMonths: 3,
                disableDayFn: function(date) {
                    // Disable Sunday and Saturday
                    return date.getDay() === 0 || date.getDay() === 6;
                }
            }
        }, {
            type: 'numeric',
            format: '$ 0,0.00',
            language: 'en-US' // this is the default locale, set up for USD
        }]
    });


    /******************
     *      Time       *
     ******************/

    function getTimeData() {
        return [
            ["Mercedes", "A 160", 1332284400000, 6999.9999],
            ["Citroen", "C4 Coupe", '10 30', 8330],
            ["Audi", "A4 Avant", "8:00 PM", 33900],
            ["Opel", "Astra", 1332284400000, 7000],
            ["BMW", "320i Coupe", 1332284400000, 30500]
        ];
    }

    var containerTimeData = document.getElementById('timeData'),
        hotTimeData;

    hotTimeData = new Handsontable(containerTimeData, {
        data: getTimeData(),
        startRows: 7,
        startCols: 4,
        colHeaders: ['Car', 'Model', 'Registration time', 'Price'],
        columnSorting: true,
        contextMenu: true,
        minSpareRows: 1,
        columns: [{
            type: 'autocomplete',
            source: ['Audi', 'BMW', 'Chrysler', 'Citroen', 'Mercedes', 'Nissan', 'Opel', 'Suzuki', 'Toyota', 'Volvo'],
            strict: false
        }, {
            // 2nd cell is simple text, no special options here
        }, {
            type: 'time',
            timeFormat: 'h:mm:ss a',
            correctFormat: true
        }, {
            type: 'numeric',
            format: '$ 0,0.00',
            language: 'en-US' // this is the default locale, set up for USD
        }]
    });

    hotTimeData.validateCells();


    /*****************************************
     *      Checkbox true/false values       *
     ****************************************/

    function getCheckboxData() {
        return [
            { car: "Mercedes A 160", year: 2012, available: true, comesInBlack: 'yes' },
            { car: "Citroen C4 Coupe", year: 2013, available: false, comesInBlack: 'yes' },
            { car: "Audi A4 Avant", year: 2014, available: true, comesInBlack: 'no' },
            { car: "Opel Astra", year: 2015, available: false, comesInBlack: 'yes' },
            { car: "BMW 320i Coupe", year: 2016, available: false, comesInBlack: 'no' }
        ];
    }

    var checkboxCheckboxData = document.getElementById('checkbox'),
        hotCheckboxData;

    hotCheckboxData = new Handsontable(checkboxCheckboxData, {
        data: getCheckboxData(),
        colHeaders: ['Car model', 'Year of manufacture', 'Available'],
        columns: [{
            data: 'car'
        }, {
            data: 'year',
            type: 'numeric'
        }, {
            data: 'available',
            type: 'checkbox'
        }]
    });



    /********************
     *      Select       *
     ********************/

    var containerCheckboxData = document.getElementById("select"),
        hotCheckboxData;

    hotCheckboxData = new Handsontable(containerCheckboxData, {
        data: [
            ['2014', 'Nissan', 10],
            ['2015', 'Honda', 20],
            ['2016', 'Kia', 30]
        ],
        colHeaders: true,
        columns: [
            {}, {
                editor: 'select',
                selectOptions: ['Kia', 'Nissan', 'Toyota', 'Honda']
            },
            {}
        ]
    });



    /**********************
     *      Dropdown       *
     **********************/

    function getDropdownData() {
        return [
            ["Nissan", 2012, "black", "black"],
            ["Nissan", 2013, "blue", "blue"],
            ["Chrysler", 2014, "yellow", "black"],
            ["Volvo", 2015, "white", "gray"]
        ];
    }

    var containerDropdown = document.getElementById('dropdown'),
        hotDropdown;

    hotDropdown = new Handsontable(containerDropdown, {
        data: getDropdownData(),
        colHeaders: ['Car', 'Year', 'Chassis color', 'Bumper color'],
        columns: [
            {},
            { type: 'numeric' }, {
                type: 'dropdown',
                source: ['yellow', 'red', 'orange', 'green', 'blue', 'gray', 'black', 'white']
            }, {
                type: 'dropdown',
                source: ['yellow', 'red', 'orange', 'green', 'blue', 'gray', 'black', 'white']
            }
        ]
    });



    /************************************
     *      Autocomplete lazy mode       *
     ************************************/

    function getAutocompleteData() {
        return [
            ["Nissan", 2013, "black", "black"],
            ["Nissan", 2014, "blue", "blue"],
            ["Chrysler", 2015, "yellow", "black"],
            ["Volvo", 2016, "white", "gray"]
        ];
    }

    var containerAutocomplete = document.getElementById('autocomplete'),
        hotAutocomplete;

    hotAutocomplete = new Handsontable(containerAutocomplete, {
        data: getAutocompleteData(),
        colHeaders: ['Car', 'Year', 'Chassis color', 'Bumper color'],
        columns: [{
                type: 'autocomplete',
                source: ['BMW', 'Chrysler', 'Nissan', 'Suzuki', 'Toyota', 'Volvo'],
                strict: false
            },
            { type: 'numeric' }, {
                type: 'autocomplete',
                source: ['yellow', 'red', 'orange and another color', 'green', 'blue', 'gray', 'black', 'white', 'purple', 'lime', 'olive', 'cyan'],
                strict: false,
                visibleRows: 4
            }, {
                type: 'autocomplete',
                source: ['yellow', 'red', 'orange and another color', 'green', 'blue', 'gray', 'black', 'white', 'purple', 'lime', 'olive', 'cyan'],
                strict: false,
                trimDropdown: false
            }
        ]
    });



    /********************************
     *      Password cell type       *
     ********************************/

    function getPasswordData() {
        return [
            { id: 1, name: { first: "Chris", last: "Right" }, password: "plainTextPassword" },
            { id: 2, name: { first: "John", last: "Honest" }, password: "txt" },
            { id: 3, name: { first: "Greg", last: "Well" }, password: "longer" }
        ];
    }

    var containerPassword = document.getElementById('password'),
        hotPassword;

    hotPassword = new Handsontable(containerPassword, {
        data: getPasswordData(),
        colHeaders: ['ID', 'First name', 'Last name', 'Password'],
        columns: [
            { data: 'id' },
            { data: 'name.first' },
            { data: 'name.last' },
            { data: 'password', type: 'password' }
        ]
    });

    /**************************
     *      Handsontable       *
     **************************/

    function getHandsontableData() {
        return [
            ["Nissan", 2013, "black", "black"],
            ["Nissan", 2014, "blue", "blue"],
            ["Chrysler", 2015, "yellow", "black"],
            ["Volvo", 2016, "white", "gray"]
        ];
    }

    var
        carData = getHandsontableData(),
        containerHandsontable = document.getElementById('handsontable'),
        manufacturerData,
        colors,
        color,
        colorData = [],
        hotHandsontable;

    manufacturerData = [
        { name: 'BMW', country: 'Germany', owner: 'Bayerische Motoren Werke AG' },
        { name: 'Chrysler', country: 'USA', owner: 'Chrysler Group LLC' },
        { name: 'Nissan', country: 'Japan', owner: 'Nissan Motor Company Ltd' },
        { name: 'Suzuki', country: 'Japan', owner: 'Suzuki Motor Corporation' },
        { name: 'Toyota', country: 'Japan', owner: 'Toyota Motor Corporation' },
        { name: 'Volvo', country: 'Sweden', owner: 'Zhejiang Geely Holding Group' }
    ];
    colors = ['yellow', 'red', 'orange', 'green', 'blue', 'gray', 'black', 'white'];

    while (color = colors.shift()) {
        colorData.push([
            [color]
        ]);
    }

    hotHandsontable = new Handsontable(containerHandsontable, {
        data: carData,
        colHeaders: ['Car', 'Year', 'Chassis color', 'Bumper color'],
        columns: [{
                type: 'handsontable',
                handsontable: {
                    colHeaders: ['Marque', 'Country', 'Parent company'],
                    data: manufacturerData
                }
            },
            { type: 'numeric' }, {
                type: 'handsontable',
                handsontable: {
                    colHeaders: false,
                    data: colorData
                }
            }, {
                type: 'handsontable',
                handsontable: {
                    colHeaders: false,
                    data: colorData
                }
            }
        ]
    });
});
