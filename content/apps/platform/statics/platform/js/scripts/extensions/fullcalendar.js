/*=========================================================================================
    File Name: fullcalendar.js
    Description: Fullcalendar
    --------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


$(document).ready(function(){

	/************************************
	*				Default				*
	************************************/
	$('#fc-default').fullCalendar({
		defaultDate: '2016-06-12',
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: [
			{
				title: 'All Day Event',
				start: '2016-06-01'
			},
			{
				title: 'Long Event',
				start: '2016-06-07',
				end: '2016-06-10'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-09T16:00:00'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-16T16:00:00'
			},
			{
				title: 'Conference',
				start: '2016-06-11',
				end: '2016-06-13'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T10:30:00',
				end: '2016-06-12T12:30:00'
			},
			{
				title: 'Lunch',
				start: '2016-06-12T12:00:00'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T14:30:00'
			},
			{
				title: 'Happy Hour',
				start: '2016-06-12T17:30:00'
			},
			{
				title: 'Dinner',
				start: '2016-06-12T20:00:00'
			},
			{
				title: 'Birthday Party',
				start: '2016-06-13T07:00:00'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2016-06-28'
			}
		]
	});

	/****************************************
	*				Basic Views				*
	****************************************/
	$('#fc-basic-views').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		defaultDate: '2016-06-12',
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: [
			{
				title: 'All Day Event',
				start: '2016-06-01'
			},
			{
				title: 'Long Event',
				start: '2016-06-07',
				end: '2016-06-10'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-09T16:00:00'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-16T16:00:00'
			},
			{
				title: 'Conference',
				start: '2016-06-11',
				end: '2016-06-13'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T10:30:00',
				end: '2016-06-12T12:30:00'
			},
			{
				title: 'Lunch',
				start: '2016-06-12T12:00:00'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T14:30:00'
			},
			{
				title: 'Happy Hour',
				start: '2016-06-12T17:30:00'
			},
			{
				title: 'Dinner',
				start: '2016-06-12T20:00:00'
			},
			{
				title: 'Birthday Party',
				start: '2016-06-13T07:00:00'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2016-06-28'
			}
		]
	});

	/********************************************
	*				Agenda Views				*
	********************************************/
	$('#fc-agenda-views').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: '2016-06-12',
		defaultView: 'agendaWeek',
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: [
			{
				title: 'All Day Event',
				start: '2016-06-01'
			},
			{
				title: 'Long Event',
				start: '2016-06-07',
				end: '2016-06-10'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-09T16:00:00'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-16T16:00:00'
			},
			{
				title: 'Conference',
				start: '2016-06-11',
				end: '2016-06-13'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T10:30:00',
				end: '2016-06-12T12:30:00'
			},
			{
				title: 'Lunch',
				start: '2016-06-12T12:00:00'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T14:30:00'
			},
			{
				title: 'Happy Hour',
				start: '2016-06-12T17:30:00'
			},
			{
				title: 'Dinner',
				start: '2016-06-12T20:00:00'
			},
			{
				title: 'Birthday Party',
				start: '2016-06-13T07:00:00'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2016-06-28'
			}
		]
	});

	/************************************************
	*				Background Events				*
	************************************************/
	$('#fc-bg-events').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: '2016-06-12',
		businessHours: true, // display business hours
		editable: true,
		events: [
			{
				title: 'Business Lunch',
				start: '2016-06-03T13:00:00',
				constraint: 'businessHours'
			},
			{
				title: 'Meeting',
				start: '2016-06-13T11:00:00',
				constraint: 'availableForMeeting', // defined below
				color: '#257e4a'
			},
			{
				title: 'Conference',
				start: '2016-06-18',
				end: '2016-06-20'
			},
			{
				title: 'Party',
				start: '2016-06-29T20:00:00'
			},

			// areas where "Meeting" must be dropped
			{
				id: 'availableForMeeting',
				start: '2016-06-11T10:00:00',
				end: '2016-06-11T16:00:00',
				rendering: 'background'
			},
			{
				id: 'availableForMeeting',
				start: '2016-06-13T10:00:00',
				end: '2016-06-13T16:00:00',
				rendering: 'background'
			},

			// red areas where no events can be dropped
			{
				start: '2016-06-24',
				end: '2016-06-28',
				overlap: false,
				rendering: 'background',
				color: '#DA4453'
			},
			{
				start: '2016-06-06',
				end: '2016-06-08',
				overlap: false,
				rendering: 'background',
				color: '#DA4453'
			}
		]
	});

	/********************************************
	*				Events Colors				*
	********************************************/
	$('#fc-event-colors').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: '2016-06-12',
		businessHours: true, // display business hours
		editable: true,
		events: [
			{
				title: 'All Day Event',
				start: '2016-06-01',
				color: '#967ADC'
			},
			{
				title: 'Long Event',
				start: '2016-06-07',
				end: '2016-06-10',
				color: '#37BC9B'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-09T16:00:00',
				color: '#37BC9B'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-16T16:00:00',
				color: '#F6BB42'
			},
			{
				title: 'Conference',
				start: '2016-06-11',
				end: '2016-06-13',
				color: '#DA4453'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T10:30:00',
				end: '2016-06-12T12:30:00',
				color: '#DA4453'
			},
			{
				title: 'Lunch',
				start: '2016-06-12T12:00:00',
				color: '#DA4453'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T14:30:00',
				color: '#DA4453'
			},
			{
				title: 'Happy Hour',
				start: '2016-06-12T17:30:00',
				color: '#DA4453'
			},
			{
				title: 'Dinner',
				start: '2016-06-12T20:00:00',
				color: '#DA4453'
			},
			{
				title: 'Birthday Party',
				start: '2016-06-13T07:00:00',
				color: '#DA4453'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2016-06-28',
				color: '#3BAFDA'
			}
		]
	});

	/************************************************
	*				External Dragging				*
	************************************************/

	/* initialize the calendar
	-----------------------------------------------------------------*/

	$('#fc-external-drag').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		editable: true,
		droppable: true, // this allows things to be dropped onto the calendar
		defaultDate: '2016-06-12',
		events: [
			{
				title: 'All Day Event',
				start: '2016-06-01',
				color: '#967ADC'
			},
			{
				title: 'Long Event',
				start: '2016-06-07',
				end: '2016-06-10',
				color: '#37BC9B'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-09T16:00:00',
				color: '#37BC9B'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-16T16:00:00',
				color: '#F6BB42'
			},
			{
				title: 'Conference',
				start: '2016-06-11',
				end: '2016-06-13',
				color: '#DA4453'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T10:30:00',
				end: '2016-06-12T12:30:00',
				color: '#DA4453'
			},
			{
				title: 'Lunch',
				start: '2016-06-12T12:00:00',
				color: '#DA4453'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T14:30:00',
				color: '#DA4453'
			},
			{
				title: 'Happy Hour',
				start: '2016-06-12T17:30:00',
				color: '#DA4453'
			},
			{
				title: 'Dinner',
				start: '2016-06-12T20:00:00',
				color: '#DA4453'
			},
			{
				title: 'Birthday Party',
				start: '2016-06-13T07:00:00',
				color: '#DA4453'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2016-06-28',
				color: '#3BAFDA'
			}
		],
		drop: function() {
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}
		}
	});

	/* initialize the external events
	-----------------------------------------------------------------*/

	$('#external-events .fc-event').each(function() {

		// Different colors for events
        $(this).css({'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color')});

		// store data so the calendar knows to render an event upon drop
		$(this).data('event', {
			title: $.trim($(this).text()), // use the element's text as the event title
			color: $(this).data('color'),
			stick: true // maintain when user navigates (see docs on the renderEvent method)
		});

		// make the event draggable using jQuery UI
		$(this).draggable({
			zIndex: 999,
			revert: true,      // will cause the event to go back to its
			revertDuration: 0  //  original position after the drag
		});

	});


	/****************************************
	*				Selectable				*
	****************************************/
	$('#fc-selectable').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: '2016-06-12',
		selectable: true,
		selectHelper: true,
		select: function(start, end) {
			var title = prompt('Event Title:');
			var eventData;
			if (title) {
				eventData = {
					title: title,
					start: start,
					end: end
				};
				$('#fc-selectable').fullCalendar('renderEvent', eventData, true); // stick? = true
			}
			$('#fc-selectable').fullCalendar('unselect');
		},
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: [
			{
				title: 'All Day Event',
				start: '2016-06-01'
			},
			{
				title: 'Long Event',
				start: '2016-06-07',
				end: '2016-06-10'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-09T16:00:00'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-16T16:00:00'
			},
			{
				title: 'Conference',
				start: '2016-06-11',
				end: '2016-06-13'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T10:30:00',
				end: '2016-06-12T12:30:00'
			},
			{
				title: 'Lunch',
				start: '2016-06-12T12:00:00'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T14:30:00'
			},
			{
				title: 'Happy Hour',
				start: '2016-06-12T17:30:00'
			},
			{
				title: 'Dinner',
				start: '2016-06-12T20:00:00'
			},
			{
				title: 'Birthday Party',
				start: '2016-06-13T07:00:00'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2016-06-28'
			}
		]
	});


	/************************************
	*				gcal				*
	************************************/
	$('#fc-gcal').fullCalendar({

		// THIS KEY WON'T WORK IN PRODUCTION!!!
		// To make your own Google API key, follow the directions here:
		// http://fullcalendar.io/docs/google_calendar/
		googleCalendarApiKey: 'AIzaSyAAZnaZBXLqNBRXjd-82km_NO7GUItyKek',

		// US Holidays
		events: 'en.indian#holiday@group.v.calendar.google.com',


		eventClick: function(event) {
			// opens events in a popup window
			window.open(event.url, 'gcalevent', 'width=700,height=600');
			return false;
		},

		loading: function(bool) {
			$('#loading').toggle(bool);
		}

	});


	/************************************
	*				json				*
	************************************/
	$('#fc-json').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: '2016-06-12',
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: {
			url: '../../../app-assets/data/fullcalendar/php/get-events.php',
			error: function() {
				$('#script-warning').show();
			}
		},
		loading: function(bool) {
			$('#loading').toggle(bool);
		}
	});


	/****************************************
	*				Languages				*
	****************************************/
	var initialLangCode = 'en';

	$('#fc-languages').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: '2016-06-12',
		lang: initialLangCode,
		buttonIcons: false, // show the prev/next text
		weekNumbers: true,
		editable: true,
		defaultView: 'agendaWeek',
		eventLimit: true, // allow "more" link when too many events
		events: [
			{
				title: 'All Day Event',
				start: '2016-06-01'
			},
			{
				title: 'Long Event',
				start: '2016-06-07',
				end: '2016-06-10'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-09T16:00:00'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-06-16T16:00:00'
			},
			{
				title: 'Conference',
				start: '2016-06-11',
				end: '2016-06-13'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T10:30:00',
				end: '2016-06-12T12:30:00'
			},
			{
				title: 'Lunch',
				start: '2016-06-12T12:00:00'
			},
			{
				title: 'Meeting',
				start: '2016-06-12T14:30:00'
			},
			{
				title: 'Happy Hour',
				start: '2016-06-12T17:30:00'
			},
			{
				title: 'Dinner',
				start: '2016-06-12T20:00:00'
			},
			{
				title: 'Birthday Party',
				start: '2016-06-13T07:00:00'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2016-06-28'
			}
		]
	});

	// build the language selector's options
	// build the locale selector's options
    $.each($.fullCalendar.locales, function(localeCode) {
      $('#lang-selector').append(
        $('<option/>')
          .attr('value', localeCode)
          .prop('selected', localeCode == initialLocaleCode)
          .text(localeCode)
      );
    });

    // when the selected option changes, dynamically change the calendar option
    $('#lang-selector').on('change', function() {
      if (this.value) {
        $('#fc-languages').fullCalendar('option', 'locale', this.value);
      }
    });


	/****************************************
	*				Time Zones				*
	****************************************/
	$('#fc-timezones').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: '2016-06-12',
		editable: true,
		selectable: true,
		eventLimit: true, // allow "more" link when too many events
		events: {
			url: '../../../app-assets/data/fullcalendar/php/get-events.php',
			error: function() {
				$('#script-warning').show();
			}
		},
		loading: function(bool) {
			$('#loading').toggle(bool);
		},
		eventRender: function(event, el) {
			// render the timezone offset below the event title
			if (event.start.hasZone()) {
				el.find('.fc-title').after(
					$('<div class="tzo"/>').text(event.start.format('Z'))
				);
			}
		},
		dayClick: function(date) {
			console.log('dayClick', date.format());
		},
		select: function(startDate, endDate) {
			console.log('select', startDate.format(), endDate.format());
		}
	});

	// load the list of available timezones, build the <select> options
	$.getJSON('../../../app-assets/data/fullcalendar/php/get-timezones.php', function(timezones) {
		$.each(timezones, function(i, timezone) {
			if (timezone != 'UTC') { // UTC is already in the list
				$('#timezone-selector').append(
					$("<option/>").text(timezone).attr('value', timezone)
				);
			}
		});
	});

	// when the timezone selector changes, dynamically change the calendar option
	$('#timezone-selector').on('change', function() {
		$('#fc-timezones').fullCalendar('option', 'timezone', this.value || false);
	});
});