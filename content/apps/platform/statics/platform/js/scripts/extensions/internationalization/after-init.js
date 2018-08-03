/*=========================================================================================
    File Name: after-init.js
    Description: internationalization library showing after init event.
    --------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


$(document).ready(function(){

    /*******************************
    *           After Init         *
    *******************************/
    // Initialize
    i18next
        .use(window.i18nextXHRBackend)
        .init({
            debug: true,
            fallbackLng: false,
            backend: {
                loadPath: "../../../app-assets/data/locales/{{lng}}/{{ns}}.json",
            },
            returnObjects: true
        },
        function (err, t) {
            // resources have been loaded
            jqueryI18next.init(i18next, $);
        });

    // After InIt Event
    i18next.on('initialized', function(options) {

        // Change language
        i18next.changeLanguage('en', function (err, t){
            // resources have been loaded
            $('.main-menu').localize();
        });
    });


    // Navbar Language Click Event
    $('#lng-after-init').on('click', '.lng-nav li a', function(){
        var $this = $(this);
        var selected_lng = $this.data('lng');

        // Change language
        i18next.changeLanguage(selected_lng, function (err, t){
            // resources have been loaded
            $('.main-menu').localize();
        });

        // Set Active Class in navigation
        $this.parent('li').siblings('li').children('a').removeClass('active');
        $this.addClass('active');

        // Change lang in dropdown
        $('#lng-after-init').find('.lng-dropdown .dropdown-menu a').removeClass('active');
        var drop_lng = $('#lng-after-init').find('.lng-dropdown .dropdown-menu a[data-lng="'+selected_lng+'"]').addClass('active');
        $('#lng-after-init #dropdown-active-item').html(drop_lng.html());
    });

    // Dropdown Language Change Event
    $('#lng-after-init').on('click', '.lng-dropdown .dropdown-menu a', function(){
        var $this = $(this);
        var selected_lng = $this.data('lng');

        // Change language
        i18next.changeLanguage(selected_lng, function (err, t){
            // resources have been loaded
            $('.main-menu').localize();
        });

        // Set Active Class in navigation
        $('#lng-after-init .lng-nav li a').removeClass('active');
        $('#lng-after-init .lng-nav li a[data-lng="'+selected_lng+'"]').addClass('active');

        // Change lang in dropdown
        $('#lng-after-init').find('.lng-dropdown .dropdown-menu a').removeClass('active');
        $this.addClass('active');
        $('#lng-after-init #dropdown-active-item').html($this.html());
    });

});