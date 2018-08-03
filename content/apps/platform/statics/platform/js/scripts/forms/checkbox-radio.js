/*=========================================================================================
    File Name: checkbox-radio.js
    Description: Checkbox & Radio buttons with icheck, bootstrap switch & switchery etc..
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function(window, document, $) {
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
            /*console.log(element);
            console.log(element_class);*/
          element.attr('class', element_class);
        });

        skin.data('icheckbox', checkbox_default + color);
        skin.data('iradio', radio_default + color);
        self.addClass('active');
      }
    });

    $('.skin-line input').each(function(){
      var self = $(this),
        label = self.next(),
        label_text = label.text();

      label.remove();
      self.iCheck({
        checkboxClass: 'icheckbox_line-blue',
        radioClass: 'iradio_line-blue',
        insert: '<div class="icheck_line-icon"></div>' + label_text
      });
    });
    // Checkbox & Radio 2
    $('.icheck_minimal input').iCheck({
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

})(window, document, jQuery);