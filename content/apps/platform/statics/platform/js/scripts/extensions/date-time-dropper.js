/*=========================================================================================
    File Name: date-time-dropper.js
    Description: Datepicker and Timepicker plugins based on jQuery
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
$(document).ready(function(){

    /********************************************
    *               Date Dropper                *
    ********************************************/

    // Options


    // Animate
    $('#animate').dateDropper({
        dropWidth: 200
    });

    // Init Animation
    $('#init_animation').dateDropper({
        dropWidth: 200,
        init_animation: 'bounce'
    });

    // Format
    $('#format').dateDropper({
        dropWidth: 200,
        format: 'j l, F, Y'
    });

    // Lang
    $('#lang').dateDropper({
        dropWidth: 200,
        lang: 'ar' // Arabic
    });

    // Lock
    $('#lock').dateDropper({
        dropWidth: 200,
        lock: 'from' // To select date after today, 'to' to select date before today
    });

    // Max Year
    $('#maxYear').dateDropper({
        dropWidth: 200,
        maxYear: '2020'
    });

    // Min Year
    $('#minYear').dateDropper({
        dropWidth: 200,
        minYear: '2001'
    });

    // Years Range
    $('#yearsRange').dateDropper({
        dropWidth: 200,
        yearsRange: '5'
    });


    // Styles

    // Drop Primary Color
    $('#dropPrimaryColor').dateDropper({
        dropWidth: 200,
        dropPrimaryColor: '#F6BB42',
        dropBorder: '1px solid #F6BB42'
    });

    // Drop Text Color
    $('#dropTextColor').dateDropper({
        dropWidth: 200,
        dropPrimaryColor: '#10617E',
        dropBorder: '1px solid #10617E',
        dropBackgroundColor: '#23b1e3',
        dropTextColor: '#FFF'
    });

    // Drop Background Color
    $('#dropBackgroundColor').dateDropper({
        dropWidth: 200,
        dropBackgroundColor: '#ACDAEC',
    });

    // Drop Border
    $('#dropBorder').dateDropper({
        dropWidth: 200,
        dropPrimaryColor: '#2fb594',
        dropBorder: '1px solid #2dad8d',
    });

    // Drop Border Radius
    $('#dropBorderRadius').dateDropper({
        dropWidth: 200,
        dropPrimaryColor: '#e8273a',
        dropBorder: '1px solid #e71e32',
        dropBorderRadius: '0'
    });

    // Drop Shadow
    $('#dropShadow').dateDropper({
        dropWidth: 200,
        dropPrimaryColor: '#fa4420',
        dropBorder: '1px solid #fa4420',
        dropBorderRadius: '20',
        dropShadow: '0 0 10px 0 rgba(250, 68, 32, 0.6)'
    });

    // Drop Width
    $('#dropWidth').dateDropper({
        dropWidth: 250
    });

    // Drop Text Weight
    $('#dropTextWeight').dateDropper({
        dropWidth: 200,
        dropTextWeight: 'normal'
    });


    /********************************************
    *               Time Dropper                *
    ********************************************/

    // Options


    // Auto Switch
    $('#autoswitch').timeDropper();

    // Meridians
    $('#meridians').timeDropper({
        meridians: true
    });

    // Format
    $('#timeformat').timeDropper({
        format: 'HH:mm A'
    });

    // Mousewheel
    $('#mousewheel').timeDropper({
        mousewheel: true
    });

    // Init Animation
    $('#time_init_animation').timeDropper({
        init_animation: 'dropDown',
        meridians: true
    });

    // Set Current Time
    $('#setCurrentTime').timeDropper();



    // Styles


    // Primary Color
    $('#primaryColor').timeDropper({
        primaryColor: '#2fb594',
        borderColor: '#2fb594'
    });

    // Text Color
    $('#textColor').timeDropper({
        primaryColor: '#2fb594',
        textColor: '#e8273a'
    });

    // Background Color
    $('#backgroundColor').timeDropper({
        primaryColor: '#FFF',
        backgroundColor: '#fa4420',
        borderColor: '#781602',
        textColor: '#781602'
    });

    // Border Color
    $('#borderColor').timeDropper({
        primaryColor: '#FFF',
        backgroundColor: '#23b1e3',
        borderColor: '#FFF',
        textColor: '#FFF'
    });

});