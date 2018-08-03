/*=========================================================================================
    File Name: query-string.js
    Description: internationalization library set language using query string
    --------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


$(document).ready(function(){

    /*****************************************
    *               Query String             *
    *****************************************/
    i18next
        .use(window.i18nextBrowserLanguageDetector)
        .use(window.i18nextXHRBackend)
        .init({
            debug: true,
            detection: {
                lookupQuerystring: 'lng',
            },
            fallbackLng: false,
            backend: {
                loadPath: "../../../app-assets/data/locales/{{lng}}/{{ns}}.json",
            },
            returnObjects: true
        },
        function (err, t) {
            // resources have been loaded
            jqueryI18next.init(i18next, $);

            $('.main-menu').localize();

            if(i18next.language == 'en'){
                $('.lng-nav li a').removeClass('active');
                $('.lng-nav li a[data-lng="en"]').addClass('active');

                $('.lng-dropdown a').removeClass('active');
                var drop_lng = $('.lng-dropdown a[data-lng="en"]').addClass('active');
                $('#dropdown-active-item').html(drop_lng.html());
            }

            if(i18next.language == 'es'){
                $('.lng-nav li a').removeClass('active');
                $('.lng-nav li a[data-lng="es"]').addClass('active');

                $('.lng-dropdown a').removeClass('active');
                var drop_lng = $('.lng-dropdown a[data-lng="es"]').addClass('active');
                $('#dropdown-active-item').html(drop_lng.html());
            }

            if(i18next.language == 'pt'){
                $('.lng-nav li a').removeClass('active');
                $('.lng-nav li a[data-lng="pt"]').addClass('active');

                $('.lng-dropdown a').removeClass('active');
                var drop_lng = $('.lng-dropdown a[data-lng="pt"]').addClass('active');
                $('#dropdown-active-item').html(drop_lng.html());
            }

            if(i18next.language == 'fr'){
                $('.lng-nav li a').removeClass('active');
                $('.lng-nav li a[data-lng="fr"]').addClass('active');

                $('.lng-dropdown a').removeClass('active');
                var drop_lng = $('.lng-dropdown a[data-lng="fr"]').addClass('active');
                $('#dropdown-active-item').html(drop_lng.html());
            }
        });

});