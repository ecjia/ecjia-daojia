$(document).ready(function(){

	// pre selected options multi select
	$('#pre-selected-options').multiSelect();

	// callbacks multi select
	$('#callbacks').multiSelect({
	  	afterSelect: function(values){
	    	alert("Select value: "+values);
	  	},
	  	afterDeselect: function(values){
	    	alert("Deselect value: "+values);
	  	}
	});

	// keep order multi select
	$('#keep-order').multiSelect({ keepOrder: true });

	// public methods multi select
	$('#public-methods').multiSelect();
	$('#select-all').click(function(){
	  	$('#public-methods').multiSelect('select_all');
	  	return false;
	});
	$('#deselect-all').click(function(){
	  	$('#public-methods').multiSelect('deselect_all');
	  	return false;
	});
	$('#select-100').click(function(){
	  	$('#public-methods').multiSelect('select', ['jawa_barat', 'jawa_tengah', 'yogyakarta']);
	  	return false;
	});
	$('#deselect-100').click(function(){
	  	$('#public-methods').multiSelect('deselect', ['jawa_barat', 'jawa_tengah', 'yogyakarta']);
	  	return false;
	});
	$('#refresh').on('click', function(){
	  	$('#public-methods').multiSelect('refresh');
	  	return false;
	});
	$('#add-option').on('click', function(){
	  	$('#public-methods').multiSelect('addOption', { value: 42, text: 'test 42', index: 0 });
	  	return false;
	});

	// Option Group
	$('#optgroup').multiSelect({ selectableOptgroup: true });

	// disabled options
	$('#disabled-attribute').multiSelect();

	// custom header and footers
	$('#custom-headers').multiSelect({
	  	selectableHeader: "<div class='custom-header'>Selectable items</div>",
	  	selectionHeader: "<div class='custom-header'>Selection items</div>",
	  	selectableFooter: "<div class='custom-header'>Selectable footer</div>",
	  	selectionFooter: "<div class='custom-header'>Selection footer</div>"
	});

	// search able
	$('.searchable').multiSelect({
	  	selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='try \"12\"'>",
	  	selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='try \"4\"'>",
	  	afterInit: function(ms){
	    	var that = this,
		        $selectableSearch = that.$selectableUl.prev(),
		        $selectionSearch = that.$selectionUl.prev(),
		        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
		        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

	    	that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
	    	.on('keydown', function(e){
	     	if (e.which === 40){
	        	that.$selectableUl.focus();
	        	return false;
	      		}
	    	});

	    	that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
	    	.on('keydown', function(e){
	      	if (e.which == 40){
	        	that.$selectionUl.focus();
	        	return false;
	      		}
	    	});
	  	},
	  	afterSelect: function(){
	    	this.qs1.cache();
	    	this.qs2.cache();
	  	},
	  	afterDeselect: function(){
	    	this.qs1.cache();
	    	this.qs2.cache();
	  	}
	});

	// date picker
		if (top.location != location) {
    top.location.href = document.location.href ;
  }
		$(function(){
			window.prettyPrint && prettyPrint();
			$('#dp1').datepicker({
				format: 'mm-dd-yyyy'
			});
			$('#dp2').datepicker();
			$('#dp3').datepicker();
			$('#dp3').datepicker();
			$('#dpYears').datepicker();
			$('#dpMonths').datepicker();
			
			
			var startDate = new Date(2012,1,20);
			var endDate = new Date(2012,1,25);
			$('#dp4').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('The start date can not be greater then the end date');
					} else {
						$('#alert').hide();
						startDate = new Date(ev.date);
						$('#startDate').text($('#dp4').data('date'));
					}
					$('#dp4').datepicker('hide');
				});
			$('#dp5').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() < startDate.valueOf()){
						$('#alert').show().find('strong').text('The end date can not be less then the start date');
					} else {
						$('#alert').hide();
						endDate = new Date(ev.date);
						$('#endDate').text($('#dp5').data('date'));
					}
					$('#dp5').datepicker('hide');
				});

        // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#dpd1').datepicker({
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
          checkin.hide();
          $('#dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('#dpd2').datepicker({
          onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
		});

	// time picker
	$('.timepicker-default').timepicker();

	$('.timepicker-24').timepicker({
	    autoclose: true,
	    minuteStep: 1,
	    showSeconds: true,
	    showMeridian: false
	});

	// color picker
	$('.colorpicker-default').colorpicker({
    format: 'hex'
	});

	// wysihtml5
	$('#wysihtml5').wysihtml5();

});