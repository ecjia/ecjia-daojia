/*=========================================================================================
    File Name: editor-ckeditor.js
    Description: CKEditor js
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
(function(window, document, $) {
	'use strict';
	var editor = CKEDITOR.instances['ckeditor'];
	if (editor) { editor.destroy(true); }
	CKEDITOR.replace('ckeditor', {
		height: '350px',
		extraPlugins: 'forms'
	});

	// ReadOnly Editor
	var editor_readonly = CKEDITOR.replace('ckeditor-readonly',{
		height: '350px'
	});


	CKEDITOR.on( 'instanceReady', function ( ev ) {
		editor = ev.editor_readonly;

		// Show this "on" button.
		document.getElementById( 'readOnlyOn' ).style.display = '';

		// Event fired when the readOnly property changes.
		editor_readonly.on( 'readOnly', function () {
			document.getElementById( 'readOnlyOn' ).style.display = this.readOnly ? 'none' : '';
			document.getElementById( 'readOnlyOff' ).style.display = this.readOnly ? '' : 'none';
		} );
	} );

	function toggleReadOnly( isReadOnly ) {
		editor_readonly.setReadOnly( isReadOnly );
	}

	document.getElementById('readOnlyOn').onclick=function(){
		toggleReadOnly(); };
	document.getElementById('readOnlyOff').onclick=function(){
		toggleReadOnly(false); };

	// CKEditor Color Options
	editor = CKEDITOR.replace( 'ckeditor-color', {
		height: '350px',
		uiColor: '#CCEAEE'
	});


	// Enter key configuration [Options : CKEDITOR.ENTER_P, CKEDITOR.ENTER_BR, CKEDITOR.ENTER_DIV]
	editor = CKEDITOR.replace( 'ckeditor-config', {
		height: '350px',
		// Pressing Enter will create a new <div> element.
		enterMode: CKEDITOR.ENTER_P,
		// Pressing Shift+Enter will create a new <p> element.
		shiftEnterMode: CKEDITOR.ENTER_BR
	} );

	CKEDITOR.replace( 'ckeditor-language', {
		extraPlugins: 'language',
		// Customizing list of languages available in the Language drop-down.
		language_list: [ 'ar:Arabic:rtl', 'fr:French',  'he:Hebrew:rtl', 'es:Spanish' ],
		height: 350
	} );

	var introduction = document.getElementById( 'ckeditor-inline' );
	introduction.setAttribute( 'contenteditable', true );

	// CKEDITOR.disableAutoInline = true;
	editor = CKEDITOR.inline('ckeditor-inline',{
		// Allow some non-standard markup that we used in the introduction.
		extraAllowedContent: 'a(documentation);abbr[title];code',
		removePlugins: 'stylescombo',
		extraPlugins: 'sourcedialog',
		// Show toolbar on startup (optional).
		// startupFocus: true
	});
})(window, document, jQuery);