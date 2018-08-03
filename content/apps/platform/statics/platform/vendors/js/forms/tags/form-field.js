(function(window, document, $) {
    'use strict';
    

    $(window).on('load',function(){
        $('.form-group-style .form-control').focus(function() {
            $(this).parent(".form-group-style").addClass('focus');
            console.log($(this).val());
            if($(this).val() !== ""){
                 $(this).parent(".form-group-style").children("label").addClass("filled");
            }
            else{
                 $(this).parent(".form-group-style").children("label").removeClass("filled");
            }
        });
        $('.form-group-style .form-control').focusout(function() {
            if($(this).parent(".form-group-style").hasClass('focus')){
                $(this).parent(".form-group-style").removeClass('focus');
            }
            if($(this).val() !== ""){
                $(this).parent(".form-group-style").children("label").addClass("filled");
            }
            else{
                $(this).parent(".form-group-style").children("label").removeClass("filled");
            }
        });
    });
})(window, document, jQuery);