/*=========================================================================================
    File Name: tagging.js
    Description: tagging js initialization
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function(){
    /*******************************
    *       Simple Options         *
    *******************************/

	// case sensitive
    $(".case-sensitive").tagging({
        "case-sensitive": true,
    });

    // Change or remove closing char
    $(".close-char").tagging({
        "close-char": "",
    });

    // Edit / Delete tag on delete
    $(".edit-on-delete").tagging({
        "edit-on-delete": false,
    });

    // Allow duplicate tags.
    $(".no-duplicate").tagging({
        "no-duplicate": false,
    });

    // Don't allow enter key to add new tag
    $(".no-enter").tagging({
        "no-enter": true,
    });

    // Don't allow comma key to add new tag
    $(".no-comma").tagging({
        "no-comma": true,
    });


    /*******************************
    *       Advance Options        *
    *******************************/

    // Forbidden Chars
    $(".forbidden-chars").tagging({
        "forbidden-chars": ["," , ".", "_", "?"],
    });

    // Forbidden Words
    $(".forbidden-words").tagging({
        "forbidden-words": ["bastard","bitch","biatch","bloody"],
    });

    // Define pre tags separator
    $(".pre-tags-separator").tagging({
        "pre-tags-separator": "/",
    });

    // Tag On Blur
    $(".tag-on-blur").tagging({
        "tag-on-blur": false,
    });

    // Tag Char
    $(".tag-char").tagging({
        "tag-char": "*",
    });

    // Type zone class
    $(".type-zone-class").tagging({
        "type-zone-class": 'tagging-area',
    });


    /******************************
    *       Simple Methods        *
    ******************************/

    $('.add-box').tagging();
    $('.remove-box').tagging();
    var removeAll = $('.remove-all-box').tagging();
    removeAll = removeAll[0];

    var refresh = $('.refresh-box').tagging();
    refresh = refresh[0];

    var reset = $('.reset-box').tagging();
    reset = reset[0];

    $('.destroy-box').tagging();

    $('.add-tagging').on('click',function(){
        $('.add-box').tagging( "add", "Sydney" );
    });

    $('.remove-tagging').on('click',function(){
        $('.remove-box').tagging( "remove", "cairo" );
    });

    $('.remove-all-tagging').on('click',function(){
        removeAll.tagging("removeAll");
    });

    $('.refresh-tagging').on('click',function(){
        refresh.tagging("refresh");
    });

    $('.reset-tagging').on('click',function(){
        reset.tagging("reset");
    });

    $('.destroy-tagging').on('click',function(){
        $('.destroy-box').tagging('destroy');
    });


    /*******************************
    *       Advance Methods        *
    *******************************/

    $('.special-keys-box').tagging();
    $('.focus-input-box').tagging();
    $('.get-data-box').tagging();
    $('.get-special-keys-box').tagging();
    $('.val-input-box').tagging();

    $('.add-special-keys').on('click',function(){
        $('.special-keys-box').tagging( "addSpecialKeys", [ "add", { right_arrow: 39 } ] );
        $('.special-keys-box').tagging( "addSpecialKeys", [ "remove", { left_arrow: 37 } ] );
    });

    $('.focus-input').on('click',function(){
        $('.focus-input-box').tagging( "focusInput" );
    });

    $('.get-special-keys').on('click',function(){
        console.log($('.get-special-keys-box').tagging( "getSpecialKeys" ));
    });

    $('.val-input').on('click',function(){
        // Set Value
        $('.val-input-box').tagging( "valInput", "Cairo" );

        // Get Value
        console.log($('.val-input-box').tagging( "valInput" ));
    });

});