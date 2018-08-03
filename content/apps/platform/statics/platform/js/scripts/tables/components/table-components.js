/*=========================================================================================
	File Name: table-components.js
	Description: Table Components js
	----------------------------------------------------------------------------------------
	Item Name: Robust - Responsive Admin Template
	Version: 2.0
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

(function(window, document, $) {
// Bootstrap TouchSpin JS


'use strict';
  var $html = $('html');

    /*  Checkbox & Radio Styles Starts   */
    $('.colors li').on('click', function() {
      var self = $(this);

      if (!self.hasClass('active')) {
        self.siblings().removeClass('active');

        var skin = self.closest('.skin'),
          color = self.attr('class') ? '-' + self.attr('class') : '',
          checkbox = skin.data('icheckbox'),
          radio = skin.data('iradio'),
          checkbox_default = 'icheckbox_minimal',
          radio_default = 'iradio_minimal';

        if (skin.hasClass('skin-square')) {
          checkbox_default = 'icheckbox_square';
          radio_default = 'iradio_square';
          checkbox === undefined && (checkbox = 'icheckbox_square-red', radio = 'iradio_square-red');
        }

        if (skin.hasClass('skin-flat')) {
          checkbox_default = 'icheckbox_flat';
          radio_default = 'iradio_flat';
          checkbox === undefined && (checkbox = 'icheckbox_flat-green', radio = 'iradio_flat-green');
        }

        if (skin.hasClass('skin-line')) {
          checkbox_default = 'icheckbox_line';
          radio_default = 'iradio_line';
          checkbox === undefined && (checkbox = 'icheckbox_line-blue', radio = 'iradio_line-blue');
        }

        checkbox === undefined && (checkbox = checkbox_default, radio = radio_default);

        skin.find('input, .skin-states .state').each(function() {
          var element = $(this).hasClass('state') ? $(this) : $(this).parent(),
            element_class = element.attr('class').replace(checkbox, checkbox_default + color).replace(radio, radio_default + color);

          element.attr('class', element_class);
        });

        skin.data('icheckbox', checkbox_default + color);
        skin.data('iradio', radio_default + color);
        self.addClass('active');
      }
    });
    // Checkbox & Radio 1
    $('.icheck1 input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
    });

    // Checkbox & Radio 2
    $('.icheck2 input').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
    });

    // Square Checkbox & Radio
    $('.skin-square input').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
    });
    //Flat Checkbox & Radio
    $('.skin-flat input').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
    // Polaris Checkbox & Radio
    $('.skin-polaris input').iCheck({
        checkboxClass: 'icheckbox_polaris',
        radioClass: 'iradio_polaris',
        increaseArea: '-10%'
    });
    // Futurico Checkbox & Radio
    $('.skin-futurico input').iCheck({
        checkboxClass: 'icheckbox_futurico',
        radioClass: 'iradio_futurico',
        increaseArea: '20%'
    });
    /*  Checkbox & Radio Styles Ends   */


// Switchery JS


  'use strict';
  $html = $('html');

  /*  Toggle Starts   */
    $('.switch:checkbox').checkboxpicker();

    $('#switch12').checkboxpicker({
        html: true,
        offLabel: '<span class="icon-remove">',
        onLabel: '<span class="icon-ok">'
    });

    // Switchery
    var i = 0;
    if (Array.prototype.forEach) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));

        elems.forEach(function (html) {
            var switchery = new Switchery(html);
        });
    } else {
        var elems1 = document.querySelectorAll('.switchery');

        for (i = 0; i < elems1.length; i++) {
            var switchery = new Switchery(elems1[i]);
        }
    }

    var elemSmall = document.querySelectorAll('.switchery-sm');
    for (i = 0; i < elemSmall.length; i++) {
        new Switchery(elemSmall[i], {className:"switchery switchery-small"});
    }

    var danger = document.querySelectorAll('.switchery-danger');
    for (i = 0; i < danger.length; i++) {
      new Switchery(danger[i], { color: '#DA4453' });
    }
    /*  Toggle Ends   */



//- Checkbox Radio


  'use strict';

    // Basic Select2 select
	$(".select2").select2();

    // Single Select Placeholder
    $(".select2-placeholder").select2({
      placeholder: "Select a state",
      allowClear: true
    });

    // Select With Icon
    $(".select2-icons").select2({
        minimumResultsForSearch: Infinity,
        templateResult: iconFormat,
        templateSelection: iconFormat,
        escapeMarkup: function(es) { return es; }
    });

    // Format icon
    function iconFormat(icon) {
        var originalOption = icon.element;
        if (!icon.id) { return icon.text; }
        var $icon = "<i class='icon-" + $(icon.element).data('icon') + "'></i>" + icon.text;

        return $icon;
    }

    // Theme support
    $(".select2-theme").select2({
      placeholder: "Classic Theme",
      theme: "classic"
    });

    // Templating
    function formatState (state) {
      if (!state.id) { return state.text; }
      else{
        var $state = $(
          '<span><img src="../../../app-assets/images/flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
        );
        return $state;
      }
    }

    $(".select2-templating").select2({
      templateResult: formatState,
      templateSelection: formatState
    });

    // Mini
    $('.select2-size-xs').select2({
        containerCssClass: 'select-xs'
    });



// Bootstrap TouchSpin JS


	'use strict';
	var $html = $('html');

	// Default Spin
	$(".touchspin").TouchSpin({
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            buttondown_txt: '<i class="ft-minus"></i>',
            buttonup_txt: '<i class="ft-plus"></i>'
        });

$("#chart1").sparkline([5,6,7,8,9,10,12,13,15,14,13,12,10,9,8,10,12,14,15,16,17,14,12,11,10,8], {
    type: 'bar',
    width: '100%',
    height: '30px',
    barWidth: 2,
    barSpacing: 4,
    barColor: '#FF5722'
});

$("#chart2").sparkline([ [8,10], [12,8], [9,14], [8,11], [10,13], [7,11], [8,14], [9,12], [10,11], [12,14], [8,12], [9,12], [9,14] ], {
    type: 'bar',
    width: '100%',
    height: '30px',
    barWidth: 4,
    barSpacing: 6,
    stackedBarColor: ['#4CAF50', '#FFEB3B']
});

})(window, document, jQuery);