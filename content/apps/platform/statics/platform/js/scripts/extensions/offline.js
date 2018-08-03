/*=========================================================================================
	File Name: list.js
	Description: Adds search, sort, filters and flexibility to plain HTML lists
	----------------------------------------------------------------------------------------
	Item Name: Robust - Responsive Admin Template
	Version: 2.0
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(document).ready(function(){

	$('.browser iframe').each(function(){
        var _this = this;
        var themeName = $(this).data('theme');

        doc = (this.contentWindow || this.documentWindow).document;
        doc.open();
        doc.write('' +
            '<link rel="stylesheet" href="../../../app-assets/vendors/css/extensions/offline/themes/offline-theme-' + themeName + '.css" />' +
            '<link rel="stylesheet" href="../../../app-assets/vendors/css/extensions/offline/themes/offline-language-english' + (themeName.match(/\-indicator$/) ? '-indicator' : '') + '.css" />' +
            '<div data-phase="0" class="offline-ui offline-ui-down offline-ui-down-5s"><div class="offline-ui-content"></div><a class="offline-ui-retry"></a></div>' +
        '');
        doc.close();
    });

    var phases = [
        [5, 'offline-ui offline-ui-down offline-ui-down-5s', '', ''],
        [3, 'offline-ui offline-ui-down offline-ui-connecting offline-ui-waiting', '5 seconds', '5s'],
        [1, 'offline-ui offline-ui-down offline-ui-connecting offline-ui-waiting', '4 seconds', '4s'],
        [1, 'offline-ui offline-ui-down offline-ui-connecting offline-ui-waiting', '3 seconds', '3s'],
        [1, 'offline-ui offline-ui-down offline-ui-connecting offline-ui-waiting', '2 seconds', '2s'],
        [1, 'offline-ui offline-ui-down offline-ui-connecting offline-ui-waiting', '1 seconds', '1s'],
        [1, 'offline-ui offline-ui-up offline-ui-up-5s', '', '']
    ];

    var nextPhase = function() {
        var phase;

        $('.browser iframe').each(function(){
            var $offline = $(this).contents().find('.offline-ui'),
                $content = $offline.find('.offline-ui-content');

            phase = parseInt($offline.attr('data-phase'), 10);

            $offline.get(0).className = phases[phase][1];
            $content.attr('data-retry-in', phases[phase][2]);
            $content.attr('data-retry-in-abbr', phases[phase][3]);

            phase = (phase + 1) % phases.length;
            $offline.attr('data-phase', phase);
        });

        setTimeout(function(){
            nextPhase();
        }, phases[phase][0] * 1000);
    };

    nextPhase();


	Offline.check();

	var
        $online = $('.avatar-online'),
        $offline = $('.avatar-off');

    Offline.on('confirmed-down', function () {
        $online.removeClass('.avatar-online').addClass('avatar-off');
    });

    Offline.on('confirmed-up', function () {
        $offline.removeClass('.avatar-off').addClass('avatar-online');
    });

});