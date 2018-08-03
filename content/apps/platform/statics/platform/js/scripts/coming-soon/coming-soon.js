/*=========================================================================================
    File Name: coming-soon.js
    Description: Coming Soon
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

/*******************************
*       js of Countdown        *
********************************/

$(document).ready(function() {

    $('#clockImage').countdown('2018/8/10').on('update.countdown', function(event) {
      var $this = $(this).html(event.strftime(''
        + '<div class="clockCard p-2 mr-1 mb-3 bg-cyan bg-darken-4 box-shadow-2"> <span>%-w</span> <br> <p class="lead mb-0">Week%!w </p> </div>'
        + '<div class="clockCard p-2 mr-1 mb-3 bg-cyan bg-darken-4 box-shadow-2"> <span>%d</span> <br> <p class="lead mb-0">Day%!d </p> </div>'
        + '<div class="clockCard p-2 mr-1 mb-3 bg-cyan bg-darken-4 box-shadow-2"> <span>%H</span> <br> <p class="lead mb-0">Hour%!H </p> </div>'
        + '<div class="clockCard p-2 mr-1 mb-3 bg-cyan bg-darken-4 box-shadow-2"> <span>%M</span> <br> <p class="lead mb-0">Minute%!M </h5> </div>'
        + '<div class="clockCard p-2 mb-3 bg-cyan bg-darken-4 box-shadow-2"> <span>%S</span> <br> <p class="lead mb-0"> Second%!S </p> </div>'))
    });

    $('#clockFlat').countdown('2018/8/10').on('update.countdown', function(event) {
      var $this = $(this).html(event.strftime(''
        + '<div class="clockCard p-1"> <span>%-w</span> <br> <p class="bg-amber clockFormat lead p-1 mt-1 black"> Week%!w </p> </div>'
        + '<div class="clockCard p-1"> <span>%d</span> <br> <p class="bg-amber clockFormat lead p-1 mt-1 black"> Day%!d </p> </div>'
        + '<div class="clockCard p-1"> <span>%H</span> <br> <p class="bg-amber clockFormat lead p-1 mt-1 black"> Hour%!H </p> </div>'
        + '<div class="clockCard p-1"> <span>%M</span> <br> <p class="bg-amber clockFormat lead p-1 mt-1 black"> Minute%!M </p> </div>'
        + '<div class="clockCard p-1"> <span>%S</span> <br> <p class="bg-amber clockFormat lead p-1 mt-1 black"> Second%!S </p> </div>'))
    });

    $('#clockMinimal').countdown('2018/8/10').on('update.countdown', function(event) {
      var $this = $(this).html(event.strftime(''
        + '<div class="clockCard white p-2"> <span>%-w</span> <br> <p class="lead white"> Week%!w </p> </div>'
        + '<div class="clockCard white p-2"> <span>%d</span> <br> <p class="lead white"> Day%!d </p> </div>'
        + '<div class="clockCard white p-2"> <span>%H</span> <br> <p class="lead white"> Hour%!H </p> </div>'
        + '<div class="clockCard white p-2"> <span>%M</span> <br> <p class="lead white"> Minute%!M </p> </div>'
        + '<div class="clockCard white p-2"> <span>%S</span> <br> <p class="lead white"> Second%!S </p> </div>'))
    });

    // YouTube video
    // Uncomment following code to enable YouTube background video
    if($('.comingsoonVideo').length > 0){
        $('.comingsoonVideo').tubular({videoId: 'iGpuQ0ioPrM'});
    }

    // Custom Video
    // Comment / Uncomment to show / hide your custom video. Please exchange your video name and paths accordingly.
    // var BV = new $.BigVideo({useFlashForFirefox:false});
    // BV.init();
    // BV.show([
    //     { type: "video/mp4",  src: "../../../app-assets/videos/481479901.mp4" },
    //     { type: "video/webm", src: "../../../app-assets/videos/481479901.webm" },
    //     { type: "video/ogg",  src: "../../../app-assets/videos/481479901.ogv" }
    // ]);
});
