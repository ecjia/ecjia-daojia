/*=========================================================================================
    File Name: form-duallistbox.js
    Description: Dual list box js
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function(window, document, $) {
	'use strict';

	// Basic Dual Listbox
	$('.duallistbox').bootstrapDualListbox();

	// Without Filter
	$('.duallistbox-no-filter').bootstrapDualListbox({
		showFilterInputs: false
	});

	// Multi selection Dual Listbox
	$('.duallistbox-multi-selection').bootstrapDualListbox({
    nonSelectedListLabel: 'Non-selected Dual',
    selectedListLabel: 'Selected',
    preserveSelectionOnMove: 'moved',
    moveOnSelect: false
  });

	//With Filter Options
  $('.duallistbox-with-filter').bootstrapDualListbox({
    nonSelectedListLabel: 'Non-selected Dual',
    selectedListLabel: 'Selected',
    preserveSelectionOnMove: 'moved',
    moveOnSelect: false,
    nonSelectedFilter: 'Berlin|Frankfurt'
  });

  // Custom Text Support
  $('.duallistbox-custom-text').bootstrapDualListbox({
    moveOnSelect: false,
    filterTextClear : "Show All Options",
    filterPlaceHolder: "Filter Options",
    infoText: 'Showing {0} Option(s)',
    infoTextFiltered: '<span class="badge badge-info">Filtered List</span> {0} from {1}',
    infoTextEmpty: 'No Options Listed',
  });

  //Custom Height
  $('.duallistbox-custom-height').bootstrapDualListbox({
    moveOnSelect: false,
    selectorMinimalHeight: 250
  });

  // Add dynamic Option
  var duallistboxDynamic = $('.duallistbox-dynamic').bootstrapDualListbox({
    moveOnSelect: false
  });
  var numb = 25;
  $(".duallistbox-add").on('click', function() {
    var opt1 = numb + 1;
    var opt2 = numb + 2;
    duallistboxDynamic.append('<option value="'+ opt1 +'">London</option><option value="'+ opt2 +'" selected>Rome</option>');
    duallistboxDynamic.bootstrapDualListbox('refresh');
  });

  $(".duallistbox-add-clear").on('click', function() {
    var opt1 = numb + 1;
    var opt2 = numb + 2;
    duallistboxDynamic.append('<option value="'+ opt1 +'">London</option><option value="'+ opt2 +'" selected>Rome</option>');
    duallistboxDynamic.bootstrapDualListbox('refresh', true);
  });
})(window, document, jQuery);