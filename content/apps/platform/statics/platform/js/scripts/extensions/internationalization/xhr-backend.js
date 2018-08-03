/*=========================================================================================
    File Name: internationalization.js
    Description: internationalization library for browser or any other javascript environment
    --------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


$(document).ready(function(){

    /********************************
    *           XHR Backend         *
    ********************************/

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


    // Navbar Language Click Event
    $('#lng-direct-switch').on('click', '.lng-nav li a', function(){
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
        $('#lng-direct-switch').find('.lng-dropdown .dropdown-menu a').removeClass('active');
        var drop_lng = $('#lng-direct-switch').find('.lng-dropdown .dropdown-menu a[data-lng="'+selected_lng+'"]').addClass('active');
        $('#lng-direct-switch #dropdown-active-item').html(drop_lng.html());
    });

    // Dropdown Language Change Event
    $('#lng-direct-switch').on('click', '.lng-dropdown .dropdown-menu a', function(){
        var $this = $(this);
        var selected_lng = $this.data('lng');

        // Change language
        i18next.changeLanguage(selected_lng, function (err, t){
            // resources have been loaded
            $('.main-menu').localize();
        });

        // Set Active Class in navigation
        $('#lng-direct-switch .lng-nav li a').removeClass('active');
        $('#lng-direct-switch .lng-nav li a[data-lng="'+selected_lng+'"]').addClass('active');

        // Change lang in dropdown
        $('#lng-direct-switch').find('.lng-dropdown .dropdown-menu a').removeClass('active');
        $this.addClass('active');
        $('#lng-direct-switch #dropdown-active-item').html($this.html());
    });

});