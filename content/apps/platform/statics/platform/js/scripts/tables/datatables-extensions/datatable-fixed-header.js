/*=========================================================================================
    File Name: datatables-fixedheader.js
    Description: fixed Header Datatable
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

    /************************************
     *       Basic initialisation        *
     ************************************/

    var dataexFixhBasic = $('.dataex-fixh-basic').DataTable( {
        fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight()
        }
    });

    if ($('body').hasClass('vertical-layout')) {
        var menuWidth = $('.main-menu').outerWidth();
        $('.fixedHeader-floating').css('margin-left',menuWidth+'px');
    }

    /********************************************
     *       Enable / disable FixedHeader        *
     ********************************************/

    var tableEnablDeisable = $('.dataex-fixh-enabledisable').DataTable({
        fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight()
        }
    });

    $('#enable').on('click', function() {
        tableEnablDeisable.fixedHeader.enable();
    });

    $('#disable').on('click', function() {
        tableEnablDeisable.fixedHeader.disable();
    });

    /***************************************
     *       Show / hide FixedHeader        *
     ***************************************/

    var tableHideHeader = $('.dataex-fixh-hideheader').DataTable({
        fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight()
        }
    });

    var visible = true;
    var tableContainer = $(tableHideHeader.table().container());

    $('#toggle').on('click', function() {
        tableContainer.css('display', visible ? 'none' : 'block');
        tableHideHeader.fixedHeader.adjust();

        visible = !visible;
    });

    /********************************************
     *       Enable / disable FixedHeader        *
     ********************************************/

    var tableResponsive = $('.dataex-fixh-responsive').DataTable({
        responsive: true
    });

    new $.fn.dataTable.FixedHeader(tableResponsive,{
            header: true,
            headerOffset: $('.header-navbar').outerHeight()
        });

    /**************************************************
     *       Responsive integration (Bootstrap)        *
     **************************************************/

    var tableResponsiveBootstrap = $('.dataex-fixh-responsive-bootstrap').DataTable({
        responsive: true
    });

    new $.fn.dataTable.FixedHeader(tableResponsiveBootstrap,{
            header: true,
            headerOffset: $('.header-navbar').outerHeight()
    });

    /**************************************
     *       ColReorder integration        *
     **************************************/

    var tableColReorder = $('.dataex-fixh-reorder').DataTable({
        fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight()
        },
        colReorder: true
    });

    // Resize datatable on menu width change and window resize
    $(function () {

        $(".menu-toggle").on('click', resize);

        // Resize function
        function resize() {
            setTimeout(function() {

                // ReDraw DataTable
                dataexFixhBasic.draw();
                tableEnablDeisable.draw();
                tableHideHeader.draw();
                tableResponsive.draw();
                tableResponsiveBootstrap.draw();
                tableColReorder.draw();
            }, 400);
        }
    });


});