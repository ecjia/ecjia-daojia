/*=========================================================================================
    File Name: editor-ace.js
    Description: Ace code editor
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/

(function(window, document, $) {
	'use strict';
	// Basic Ace Editor
	var basic = ace.edit("editor_basic");
		basic.getSession().setMode("ace/mode/javascript");

	//Basic Ace with Theme
	var basicTheme = ace.edit("editor_basic_theme");
		basicTheme.getSession().setMode("ace/mode/html");
		basicTheme.setTheme("ace/theme/twilight");
		basicTheme.setShowPrintMargin(false);
		basicTheme.setOptions({
			enableBasicAutocompletion: true,
			enableSnippets: true,
			enableLiveAutocompletion: false
		});

	// Auto Resize
	var autoresize = ace.edit("editor_autoresize");
		autoresize.setTheme("ace/theme/tomorrow_night_eighties");
		autoresize.session.setMode("ace/mode/html");
		autoresize.setAutoScrollEditorIntoView(true);
		autoresize.setOption("maxLines", 100);

	// Keyboard Shortcuts
	var keyboard = ace.edit("editor_keyboard");
		keyboard.setTheme("ace/theme/chaos");
		keyboard.session.setMode("ace/mode/html");

		// add command to lazy-load keybinding_menu extension
		keyboard.commands.addCommand({
			name: "showKeyboardShortcuts",
			bindKey: {win: "Ctrl-Alt-h", mac: "Command-Alt-h"},
			exec: function(keyboard) {
				ace.config.loadModule("ace/ext/keybinding_menu", function(module) {
					module.init(keyboard);
					// Uncemment below line to show keyboard shortcuts on page load.
					// keyboard.showKeyboardShortcuts();
				});
			}
		});
		keyboard.execCommand("showKeyboardShortcuts");

	// CSS Ace Editor
	var css = ace.edit("editor_css");
		css.setTheme("ace/theme/clouds_midnight");
		css.getSession().setMode("ace/mode/css");

	// SASS Ace Editor
	var sass = ace.edit("editor_sass");
		sass.setTheme("ace/theme/github");
		sass.getSession().setMode("ace/mode/sass");

	// JSON Ace Editor
	var json = ace.edit("editor_json");
		json.setTheme("ace/theme/iplastic");
		json.getSession().setMode("ace/mode/json");

	// PHP Ace Editor
	var php = ace.edit("editor_php");
		php.setTheme("ace/theme/merbivore");
		php.getSession().setMode("ace/mode/php");

})(window, document, jQuery);