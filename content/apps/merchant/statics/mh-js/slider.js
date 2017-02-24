$(document).ready(function(){
	$('#slider1').slider();

	$('#slider2').slider();

    var RGBChange = function() {
      $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
    };

    var r = $('#R').slider()
            .on('slide', RGBChange)
            .data('slider');
    var g = $('#G').slider()
            .on('slide', RGBChange)
            .data('slider');
    var b = $('#B').slider()
            .on('slide', RGBChange)
            .data('slider');

    $('#eg input').slider();
});

