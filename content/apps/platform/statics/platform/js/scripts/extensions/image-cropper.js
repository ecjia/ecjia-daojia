/*=========================================================================================
    File Name: image-cropper.js
    Description: Image Cropper
    --------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


$(document).ready(function(){

    /********************************
    *           Crop Demo           *
    ********************************/
    var $image = $('.main-demo-image');
    var $download = $('.download');
    var $dataX = $('.main-demo-dataX');
    var $dataY = $('.main-demo-dataY');
    var $dataHeight = $('.main-demo-dataHeight');
    var $dataWidth = $('.main-demo-dataWidth');
    var $dataRotate = $('.main-demo-dataRotate');
    var $dataScaleX = $('.main-demo-dataScaleX');
    var $dataScaleY = $('.main-demo-dataScaleY');
    var options = {
        viewMode: 1,
        aspectRatio: 16 / 9,
        preview: '.img-preview',
        crop: function(e) {
            $dataX.val(Math.round(e.x));
            $dataY.val(Math.round(e.y));
            $dataHeight.val(Math.round(e.height));
            $dataWidth.val(Math.round(e.width));
            $dataRotate.val(e.rotate);
            $dataScaleX.val(e.scaleX);
            $dataScaleY.val(e.scaleY);
        }
    };

    // Cropper
    $image.cropper(options);

    // Get Data
    $('.get-data-btn').on('click',function(){
        result = $image.cropper("getData");
        $('.get-data').val(JSON.stringify(result));
    });

    // Get Image Data
    $('.get-image-data-btn').on('click',function(){
        result = $image.cropper("getImageData");
        $('.get-image-data').val(JSON.stringify(result));
    });

    // Get Container Data
    $('.get-container-data-btn').on('click',function(){
        result = $image.cropper("getContainerData");
        $('.get-container-data').val(JSON.stringify(result));
    });

    // Get Canvas Data
    $('.get-canvas-data-btn').on('click',function(){
        result = $image.cropper("getCanvasData");
        $('.get-canvas-data').val(JSON.stringify(result));
    });

    // Get Cropbox Data
    $('.get-cropbox-data-btn').on('click',function(){
        result = $image.cropper("getCropBoxData");
        $('.get-cropbox-data').val(JSON.stringify(result));
    });

    // Download Cropped Canvas
    $('.download-cropped-canvas-btn').on('click',function(){

    });

    // Rotate Image -45 Degree
    $('.rotate-m45-deg').on('click',function(){
        $image.cropper('rotate', -45);
    });

    // Rotate Image 45 Degree
    $('.rotate-45-deg').on('click',function(){
        $image.cropper('rotate', 45);
    });

    // Rotate Image 180 Degree
    $('.rotate-180-deg').on('click',function(){
        $image.cropper('rotate', 180);
    });

    // Flip Horizontal
    $('.flip-horizontal').on('click',function(){
        var dataOption = $(this).data('option');
        $image.cropper('scaleX', -dataOption);
        $(this).data('option', -dataOption);
    });

    // Flip Vertical
    $('.flip-vertical').on('click',function(){
        var dataOption = $(this).data('option');
        $image.cropper('scaleY', -dataOption);
        $(this).data('option', -dataOption);
    });

    // Zoom In
    $('.zoom-in').on('click',function(){
        $image.cropper('zoom', 0.1);
    });


    /***********************************
    *           Basic Cropper          *
    ***********************************/
    $('.basic-cropper').cropper({
        viewMode: 1,
        restore: false,
        zoomOnWheel: false
    });


    /*********************************
    *           No Overlay           *
    *********************************/
    $('.no-overlay').cropper({
        viewMode: 1,
        modal: false,
        restore: false,
        zoomOnWheel: false
    });

    /****************************************
    *           16:9 Aspect Ratio           *
    ****************************************/
    $('.aspect-ratio-16-9').cropper({
        viewMode: 1,
        aspectRatio: 16/9,
        autoCropArea: 0.65,
        restore: false,
        zoomOnWheel: false
    });


    /***************************************
    *           4:3 Aspect Ratio           *
    ***************************************/
    $('.aspect-ratio-4-3').cropper({
        viewMode: 1,
        aspectRatio: 4/3,
        autoCropArea: 0.65,
        restore: false,
        zoomOnWheel: false
    });

    /*************************************
    *           Fixed Crop Box           *
    *************************************/
    $('.fixed-crop-box').cropper({
        viewMode: 1,
        dragMode: 'none',
        autoCropArea: 0.65,
        restore: false,
        cropBoxMovable: false,
        zoomOnWheel: false
    });

    /******************************************
    *           Fixed Size Crop Box           *
    ******************************************/
    $('.fixed-size-crop-box').cropper({
        viewMode: 1,
        dragMode: 'none',
        autoCropArea: 0.65,
        restore: false,
        cropBoxResizable: false,
        zoomOnWheel: false
    });

    /*************************************
    *           Disable Guides           *
    *************************************/
    $('.disable-guides').cropper({
        viewMode: 1,
        autoCropArea: 0.65,
        guides: false,
        restore: false,
        zoomOnWheel: false
    });

    /***********************************************
    *           Disable Center Indicator           *
    ***********************************************/
    $('.disable-center-indicator').cropper({
        viewMode: 1,
        autoCropArea: 0.65,
        center: false,
        restore: false,
        zoomOnWheel: false
    });

    /****************************************
    *           Disable Auto Crop           *
    ****************************************/
    $('.disable-auto-crop').cropper({
        autoCrop: false,
        viewMode: 1,
        autoCropArea: 0.65,
        restore: false,
        zoomOnWheel: false
    });


    /*******************************************
    *           Disable New Crop Box           *
    *******************************************/
    $('.disable-new-crop-box').cropper({
        dragMode: 'none',
        viewMode: 1,
        autoCropArea: 0.65,
        restore: false,
        zoomOnWheel: false
    });

    /************************************
    *           Movable Image           *
    ************************************/
    $('.movable-image').cropper({
        viewMode: 1,
        dragMode: 'move',
        autoCropArea: 0.65,
        restore: false,
        cropBoxMovable: false,
        cropBoxResizable: false,
        zoomOnWheel: false
    });


    /*************************************
    *           Zoomable Image           *
    *************************************/
    $('.zoomable-image').cropper({
        viewMode: 1,
        dragMode: 'crop',
        autoCropArea: 0.65,
        restore: false,
        zoomable: true,
        zoomOnTouch: true,
        cropBoxMovable: false,
        cropBoxResizable: false
    });

    /****************************************
    *           Minimum Crop Area           *
    ****************************************/
    $('.min-crop-area').cropper({
        minCropBoxWidth: 100,
        minCropBoxHeight: 100,
        viewMode: 1,
        autoCropArea: 0.65,
        dragMode: 'crop',
        restore: false,
        zoomOnWheel: false
    });

    /*****************************************
    *           Disable Background           *
    *****************************************/
    $('.disable-background').cropper({
        background: false,
        viewMode: 1,
        autoCropArea: 0.65,
        dragMode: 'crop',
        restore: false,
        zoomOnWheel: false
    });


    /***********************************
    *           Rotate Image           *
    ***********************************/
    $('.rotate-image').cropper({
        viewMode: 1,
        autoCropArea: 0.65,
        dragMode: 'crop',
        restore: false,
        zoomOnWheel: false,
        built: function () {
            $('.rotate-image').cropper('rotate', 45);
        }
    });

    /**********************************
    *           Scale Image           *
    **********************************/
    $('.scale-image').cropper({
        viewMode: 1,
        autoCropArea: 0.65,
        dragMode: 'crop',
        restore: false,
        zoomOnWheel: false,
        built: function () {
            $('.scale-image').cropper('scale', -1); // Flip both horizontal and vertical
        }
    });

});