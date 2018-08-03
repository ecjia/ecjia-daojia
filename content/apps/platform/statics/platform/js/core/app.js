/*=========================================================================================
  File Name: app.js
  Description: Template related app JS.
  ----------------------------------------------------------------------------------------
  Item Name: Robust - Responsive Admin Template
  Version: 2.0
  Author: Pixinvent
  Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

(function(window, document, $) {
    'use strict';
    var $html = $('html');
    var $body = $('body');


    $(window).on('load',function(){
        var rtl;
        var compactMenu = false; // Set it to true, if you want default menu to be compact

        if($('html').data('textdirection') == 'rtl'){
            rtl = true;
        }

        setTimeout(function(){
            $html.removeClass('loading').addClass('loaded');
        }, 1200);

        $.app.menu.init(compactMenu);

        // Navigation configurations
        var config = {
            speed: 300 // set speed to expand / collpase menu
        };
        if($.app.nav.initialized === false){
            $.app.nav.init(config);
        }

        Unison.on('change', function(bp) {
            $.app.menu.change();
        });

        // Tooltip Initialization
        $('[data-toggle="tooltip"]').tooltip({
            container:'body'
        });

        // Top Navbars - Hide on Scroll
        if ($(".navbar-hide-on-scroll").length > 0) {
            $(".navbar-hide-on-scroll.fixed-top").headroom({
              "offset": 205,
              "tolerance": 5,
              "classes": {
                 // when element is initialised
                initial : "headroom",
                // when scrolling up
                pinned : "headroom--pinned-top",
                // when scrolling down
                unpinned : "headroom--unpinned-top",
              }
            });
            // Bottom Navbars - Hide on Scroll
            $(".navbar-hide-on-scroll.fixed-bottom").headroom({
              "offset": 205,
              "tolerance": 5,
              "classes": {
                 // when element is initialised
                initial : "headroom",
                // when scrolling up
                pinned : "headroom--pinned-bottom",
                // when scrolling down
                unpinned : "headroom--unpinned-bottom",
              }
            });
        }

        //Match content & menu height for content menu
        setTimeout(function(){
            if($('body').hasClass('vertical-content-menu')){
                setContentMenuHeight();
            }
        },500);
        function setContentMenuHeight(){
            var menuHeight = $('.main-menu').height();
            var bodyHeight = $('.content-body').height();
            if(bodyHeight<menuHeight){
                $('.content-body').css('height',menuHeight);
            }
        }

        // Collapsible Card
        $('a[data-action="collapse"]').on('click',function(e){
            e.preventDefault();
            $(this).closest('.card').children('.card-content').collapse('toggle');
            $(this).closest('.card').find('[data-action="collapse"] i').toggleClass('ft-minus ft-plus');

        });

        // Toggle fullscreen
        $('a[data-action="expand"]').on('click',function(e){
            e.preventDefault();
            $(this).closest('.card').find('[data-action="expand"] i').toggleClass('ft-maximize ft-minimize');
            $(this).closest('.card').toggleClass('card-fullscreen');
        });

        //  Notifications & messages scrollable
        if($('.scrollable-container').length > 0){
            $('.scrollable-container').perfectScrollbar({
                theme:"dark"
            });
        }

        // Reload Card
        $('a[data-action="reload"]').on('click',function(){
            var block_ele = $(this).closest('.card');

            // Block Element
            block_ele.block({
                message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                timeout: 2000, //unblock after 2 seconds
                overlayCSS: {
                    backgroundColor: '#FFF',
                    cursor: 'wait',
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none'
                }
            });
        });

        // Close Card
        $('a[data-action="close"]').on('click',function(){
            $(this).closest('.card').removeClass().slideUp('fast');
        });

        // Match the height of each card in a row
        setTimeout(function(){
            $('.row.match-height').each(function() {
                $(this).find('.card').not('.card .card').matchHeight(); // Not .card .card prevents collapsible cards from taking height
            });
        },500);


        $('.card .heading-elements a[data-action="collapse"]').on('click',function(){
            var $this = $(this),
            card = $this.closest('.card');
            var cardHeight;

            if(parseInt(card[0].style.height,10) > 0){
                cardHeight = card.css('height');
                card.css('height','').attr('data-height', cardHeight);
            }
            else{
                if(card.data('height')){
                    cardHeight = card.data('height');
                    card.css('height',cardHeight).attr('data-height', '');
                }
            }
        });

        // Add open class to parent list item if subitem is active except compact menu
        var menuType = $body.data('menu');
        if(menuType != 'vertical-compact-menu' && menuType != 'horizontal-menu' && compactMenu === false ){
            if( $body.data('menu') == 'vertical-menu-modern' ){
                if( localStorage.getItem("menuLocked") === "true"){
                    $(".main-menu-content").find('li.active').parents('li').addClass('open');
                }
            }
            else{
                $(".main-menu-content").find('li.active').parents('li').addClass('open');
            }
        }
        if(menuType == 'vertical-compact-menu' || menuType == 'horizontal-menu'){
            $(".main-menu-content").find('li.active').parents('li:not(.nav-item)').addClass('open');
            $(".main-menu-content").find('li.active').parents('li').addClass('active');
        }

        //card heading actions buttons small screen support
        $(".heading-elements-toggle").on("click",function(){
            $(this).parent().children(".heading-elements").toggleClass("visible");
        });

        //  Dynamic height for the chartjs div for the chart animations to work
        var chartjsDiv = $('.chartjs'),
        canvasHeight = chartjsDiv.children('canvas').attr('height');
        chartjsDiv.css('height', canvasHeight);

        if($body.hasClass('boxed-layout')){
            if($body.hasClass('vertical-overlay-menu') || $body.hasClass('vertical-compact-menu')){
               var menuWidth= $('.main-menu').width();
               var contentPosition = $('.app-content').position().left;
               var menuPositionAdjust = contentPosition-menuWidth;
               if($body.hasClass('menu-flipped')){
                    $('.main-menu').css('right',menuPositionAdjust+'px');
               }else{
                    $('.main-menu').css('left',menuPositionAdjust+'px');
               }
            }
        }

        $('.nav-link-search').on('click',function(){
            var $this = $(this),
            searchInput = $(this).siblings('.search-input');

            if(searchInput.hasClass('open')){
                searchInput.removeClass('open');
            }
            else{
                searchInput.addClass('open');
            }
        });
    });


    $(document).on('click', '.menu-toggle, .modern-nav-toggle', function(e) {
        e.preventDefault();

        // Toggle menu
        $.app.menu.toggle();

        setTimeout(function(){
            $(window).trigger( "resize" );
        },200);

        if($('#collapsed-sidebar').length > 0){
            setTimeout(function(){
                if($body.hasClass('menu-expanded') || $body.hasClass('menu-open')){
                    $('#collapsed-sidebar').prop('checked', false);
                }
                else{
                    $('#collapsed-sidebar').prop('checked', true);
                }
            },1000);
        }

        return false;
    });

    /*$('.modern-nav-toggle').on('click',function(){
        var $this = $(this),
        icon = $this.find('.toggle-icon').attr('data-ticon');

        if(icon == 'ft-toggle-right'){
            $this.find('.toggle-icon').attr('data-ticon','ft-toggle-left')
            .removeClass('ft-toggle-right').addClass('ft-toggle-left');
        }
        else{
            $this.find('.toggle-icon').attr('data-ticon','ft-toggle-right')
            .removeClass('ft-toggle-left').addClass('ft-toggle-right');
        }

        $.app.menu.toggle();
    });*/

    $(document).on('click', '.open-navbar-container', function(e) {

        var currentBreakpoint = Unison.fetch.now();

        // Init drilldown on small screen
        $.app.menu.drillDownMenu(currentBreakpoint.name);

        // return false;
    });

    $(document).on('click', '.main-menu-footer .footer-toggle', function(e) {
        e.preventDefault();
        $(this).find('i').toggleClass('pe-is-i-angle-down pe-is-i-angle-up');
        $('.main-menu-footer').toggleClass('footer-close footer-open');
        return false;
    });

    // Add Children Class
    $('.navigation').find('li').has('ul').addClass('has-sub');

    $('.carousel').carousel({
      interval: 2000
    });

    // Page full screen
    $('.nav-link-expand').on('click', function(e) {
        if (typeof screenfull != 'undefined'){
            if (screenfull.enabled) {
                screenfull.toggle();
            }
        }
    });
    if (typeof screenfull != 'undefined'){
        if (screenfull.enabled) {
            $(document).on(screenfull.raw.fullscreenchange, function(){
                if(screenfull.isFullscreen){
                    $('.nav-link-expand').find('i').toggleClass('ft-minimize ft-maximize');
                }
                else{
                    $('.nav-link-expand').find('i').toggleClass('ft-maximize ft-minimize');
                }
            });
        }
    }

    $(document).on('click', '.mega-dropdown-menu', function(e) {
        e.stopPropagation();
    });

    $(document).ready(function(){

        /**********************************
        *   Form Wizard Step Icon
        **********************************/
        $('.step-icon').each(function(){
            var $this = $(this);
            if($this.siblings('span.step').length > 0){
                $this.siblings('span.step').empty();
                $(this).appendTo($(this).siblings('span.step'));
            }
        });
    });

    // Update manual scroller when window is resized
    $(window).resize(function() {
        $.app.menu.manualScroller.updateHeight();
    });

    // TODO : Tabs dropdown fix, remove this code once fixed in bootstrap 4.
    $('.nav.nav-tabs a.dropdown-item').on('click',function(){
        var $this = $(this),
        href = $this.attr('href');
        var tabs = $this.closest('.nav');
        tabs.find('.nav-link').removeClass('active');
        $this.closest('.nav-item').find('.nav-link').addClass('active');
        $this.closest('.dropdown-menu').find('.dropdown-item').removeClass('active');
        $this.addClass('active');
        tabs.next().find(href).siblings('.tab-pane').removeClass('active in').attr('aria-expanded',false);
        $(href).addClass('active in').attr('aria-expanded','true');
    });

    $('#sidebar-page-navigation').on('click', 'a.nav-link', function(e){
        e.preventDefault();
        e.stopPropagation();
        var $this = $(this),
        href= $this.attr('href');
        var offset = $(href).offset();
        var scrollto = offset.top - 80; // minus fixed header height
        $('html, body').animate({scrollTop:scrollto}, 0);
        setTimeout(function(){
            $this.parent('.nav-item').siblings('.nav-item').children('.nav-link').removeClass('active');
            $this.addClass('active');
        }, 100);
    });

})(window, document, jQuery);