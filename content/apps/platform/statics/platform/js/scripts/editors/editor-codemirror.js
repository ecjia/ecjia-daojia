/*=========================================================================================
    File Name: editor-codemirror.js
    Description: Code Mirror JS for code editor
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
(function(window, document, $) {
	'use strict';

	// Basic CodeMirror
	var code = document.getElementById("codemirror");
	var editor = CodeMirror.fromTextArea(code, {
		lineNumbers: true,
		mode: "javascript",
		theme: "monokai"
	});

	//Theme
	var input = document.getElementById("select");
	var theme = input.options[input.selectedIndex].textContent;
	code = document.getElementById("codemirror-theme");
	var editor1 = CodeMirror.fromTextArea(code, {
		lineNumbers: true,
		styleActiveLine: true,
		mode: "javascript",
		matchBrackets: true,
	});
	$('#select').change(function () {
		var selectedTheme = $(':selected').val();
		var stylesheet = $('[title="theme"]');
		stylesheet.attr('href','../../../app-assets/vendors/css/editors/theme/'+selectedTheme.toLowerCase()+'.css');
		editor1.setOption("theme", selectedTheme);

	});
	function selectTheme() {
		var theme = input.options[input.selectedIndex].textContent;
		editor1.setOption("theme", theme);
		location.hash = "#" + theme;
	}
	var choice = (location.hash && location.hash.slice(1)) ||
				(document.location.search &&
					decodeURIComponent(document.location.search.slice(1)));
	if (choice) {
		input.value = choice;
		editor1.setOption("theme", choice);
	}
	CodeMirror.on(window, "hashchange", function() {
		var theme = location.hash.slice(1);
		if (theme) { input.value = theme; selectTheme(); }
	});

	// LoadMode
	code = document.getElementById("codemirror-loadmode");
	CodeMirror.modeURL = "../../../app-assets/vendors/js/editors/codemirror/mode/*/*.js";
	var editorMode = CodeMirror.fromTextArea(code, {
		lineNumbers: true
	});
	var modeInput = document.getElementById("mode");
	CodeMirror.on(modeInput, "keypress", function(e) {
		if (e.keyCode == 13) change();
	});
	// function change() {
	$('#change').on('click', function(){
		var val = modeInput.value, m, mode, spec;
		if(m = /.+\.([^.]+)$/.exec(val)){
			var info = CodeMirror.findModeByExtension(m[1]);
			if (info) {
				mode = info.mode;
				spec = info.mime;
			}
		} else if (/\//.test(val)) {
			var info = CodeMirror.findModeByMIME(val);
			if (info) {
				mode = info.mode;
				spec = val;
			}
		} else {
			mode = spec = val;
		}
		if (mode) {
			editorMode.setOption("mode", spec);
			CodeMirror.autoLoadMode(editorMode, mode);
			document.getElementById("modeinfo").textContent = spec;
		} else {
			alert("Could not find a mode corresponding to " + val);
		}
	// }
	});

	// Sublime Text bindings
	var value = document.getElementById("codemirror-sublime").value;
	var map = CodeMirror.keyMap.sublime;
	for (var key in map) {
		var val = map[key];
		if (key != "fallthrough" && val != "..." && (!/find/.test(val) || /findUnder/.test(val)))
			value += "	\"" + key + "\": \"" + val + "\",\n";
	}
	value += "}\n\n// The implementation of joinLines\n";
	value += CodeMirror.commands.joinLines.toString().replace(/^function\s*\(/, "function joinLines(").replace(/\n	/g, "\n") + "\n";
	code = document.getElementById("codemirror-sublime");
	var editor = CodeMirror.fromTextArea(code, {
		value: value,
		lineNumbers: true,
		theme: "monokai",
		mode: "javascript",
		keyMap: "sublime",
		autoCloseBrackets: true,
		matchBrackets: true,
		showCursorWhenSelecting: true,
		theme: "monokai",
		tabSize: 2
	});

	// Code Folding Demo
	code = document.getElementById("codemirror-js");
	var code_html = document.getElementById("codemirror-html");
	var code_markdown = document.getElementById("codemirror-markdown");
	window.editor = CodeMirror.fromTextArea(code, {
		mode: "javascript",
		lineNumbers: true,
		lineWrapping: true,
		extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
		foldGutter: true,
		gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
	});
	editor.foldCode(CodeMirror.Pos(13, 0));

	window.editor_html = CodeMirror.fromTextArea(code_html, {
		mode: "text/html",
		lineNumbers: true,
		lineWrapping: true,
		extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
		foldGutter: true,
		gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
	});
	editor_html.foldCode(CodeMirror.Pos(0, 0));
	editor_html.foldCode(CodeMirror.Pos(21, 0));

	window.editor_markdown = CodeMirror.fromTextArea(code_markdown, {
		mode: "markdown",
		lineNumbers: true,
		lineWrapping: true,
		extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
		foldGutter: true,
		gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
	});

	// Marker
	code = document.getElementById("codemirror-marker");
	var editor = new CodeMirror.fromTextArea(code, {
		lineNumbers: true,
		styleSelectedText: true,
		highlightSelectionMatches: {showToken: /\w/, annotateScrollbar: true}
	});
	editor.markText({line: 6, ch: 26}, {line: 6, ch: 42}, {className: "styled-background"});

	// Initialize CodeMirror editor with a nice html5 canvas demo.
	var delay;
	var editor = new CodeMirror.fromTextArea(document.getElementById('codemirror-preview'), {
		mode: 'text/html'
	});
	editor.on("change", function() {
		clearTimeout(delay);
		delay = setTimeout(updatePreview, 300);
	});

	function updatePreview() {
		var previewFrame = document.getElementById('preview');
		var preview =	previewFrame.contentDocument ||	previewFrame.contentWindow.document;
		preview.open();
		preview.write(editor.getValue());
		preview.close();
	}
	setTimeout(updatePreview, 300);

	// Ruler
	var nums = "0123456789", space = "          ";
	var colors = ["#967ADC", "#37BC9B", "#F6BB42", "#3BAFDA", "#DA4453", "#3f51b5","#2196F3","#ff9800","#e91e63"];
	var rulers = [];
	value = "";
	for (var i = 1; i <= 9; i++) {
		rulers.push({color: colors[i], column: i * 10, lineStyle: "dashed"});
		for (var j = 1; j < i; j++) value += space;
		value += nums + "\n";
	}
	code = document.getElementById('codemirror-ruler');
	editor = new CodeMirror(code, {
		rulers: rulers,
		value: value + value + value,
		lineNumbers: true
	});

	// Visible Tabs
	code = document.getElementById('codemirror-tabs');
	editor = CodeMirror.fromTextArea(code, {
		lineNumbers: true,
		tabSize: 4,
		indentUnit: 4,
		indentWithTabs: true,
		mode: "text/html"
	});
})(window, document, jQuery);