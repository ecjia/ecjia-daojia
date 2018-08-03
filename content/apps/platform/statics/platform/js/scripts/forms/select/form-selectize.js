/*=========================================================================================
    File Name: form-selectize.js
    Description: Selectize js for select field
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
(function(window, document, $) {
	'use strict';

	// Basic Input Selectize
	$('.input-selectize').selectize({
		persist: false,
		createOnBlur: true,
		create: true
	});

	// Basic Selectize with Select
	$('.selectize-select').selectize({
		create: true,
		sortField: {
			field: 'text',
			direction: 'asc'
		},
		dropdownParent: 'body'
	});

	// Multiple Selectize
	$('.selectize-multiple').selectize();

	// Confirm on delete
	$('.confirm-selectize').selectize({
		delimiter: ',',
		persist: false,
		onDelete: function(values) {
			return confirm(values.length > 1 ? 'Are you sure you want to remove these ' + values.length + ' items?' : 'Are you sure you want to remove "' + values[0] + '"?');
		}
	});

	// Email Address for contact Starts
	var REGEX_EMAIL = '([a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@' + 
		'(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)';

	var formatName = function(item) {
		return $.trim((item.first_name || '') + ' ' + (item.last_name || ''));
	};

	$('.select-contact').selectize({
		persist: false,
		maxItems: null,
		valueField: 'email',
		labelField: 'name',
		searchField: ['first_name', 'last_name', 'email'],
		sortField: [
			{field: 'first_name', direction: 'asc'},
			{field: 'last_name', direction: 'asc'}
		],
		options: [
			{email: 'lio@kesta.com', first_name: 'Lio', last_name: 'Kesta'},
			{email: 'brian@carter.com', first_name: 'Brian', last_name: 'Carter'},
			{email: 'someone@gmail.com'}
		],
		render: {
			item: function(item, escape) {
				var name = formatName(item);
				return '<div>' +
					(name ? '<span class="name">' + escape(name) + '</span>' : '') +
					(item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
				'</div>';
			},
			option: function(item, escape) {
				var name = formatName(item);
				var label = name //|| item.email;
				var caption = item.email;//name ? item.email : null;
				return '<div>' +
					'<span class="label">' + escape(label) + '</span>' +
					(caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
				'</div>';
			}
		},
		createFilter: function(input) {
			var regexpA = new RegExp('^' + REGEX_EMAIL + '$', 'i');
			var regexpB = new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i');
			return regexpA.test(input) || regexpB.test(input);
		},
		create: function(input) {
			if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
				return {email: input};
			}
			var match = input.match(new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i'));
			if (match) {
				var name       = $.trim(match[1]);
				var pos_space  = name.indexOf(' ');
				var first_name = name.substring(0, pos_space);
				var last_name  = name.substring(pos_space + 1);

				return {
					email: match[2],
					first_name: first_name,
					last_name: last_name
				};
			}
			alert('Invalid email address.');
			return false;
		}
	});

	// Ends

	// Event
	var eventHandler = function(name) {
		return function() {
			$('#log').html('<small class="text-muted">Current Event : <code> ' + name + '</code></small>');
		};
	};
	var $select = $('.selectize-event').selectize({
		create          : true,
		onChange        : eventHandler('onChange'),
		onItemAdd       : eventHandler('onItemAdd'),
		onItemRemove    : eventHandler('onItemRemove'),
		onOptionAdd     : eventHandler('onOptionAdd'),
		onOptionRemove  : eventHandler('onOptionRemove'),
		onDropdownOpen  : eventHandler('onDropdownOpen'),
		onDropdownClose : eventHandler('onDropdownClose'),
		onFocus         : eventHandler('onFocus'),
		onBlur          : eventHandler('onBlur'),
		onInitialize    : eventHandler('onInitialize'),
	});

	// Integrate third-party data (GitHub)
	$('.repositories').selectize({
		valueField: 'url',
		labelField: 'name',
		searchField: 'name',
		options: [],
		create: false,
		render: {
			option: function(item, escape) {
				return '<div>' +
					'<span class="title">' +
						'<span class="name"><i class="icon ' + (item.fork ? 'fork' : 'source') + '"></i>' + escape(item.name) + '</span>' +
						'<span class="by">' + escape(item.username) + '</span>' +
					'</span>' +
					'<span class="description">' + escape(item.description) + '</span>' +
					'<ul class="meta">' +
						(item.language ? '<li class="language">' + escape(item.language) + '</li>' : '') +
						'<li class="icon-eye6"><span>' + escape(item.watchers) + '</span> watchers</li>' +
						'<li class="icon-code-fork"><span>' + escape(item.forks) + '</span> forks</li>' +
					'</ul>' +
				'</div>';
			}
		},
		score: function(search) {
			var score = this.getScoreFunction(search);
			return function(item) {
				return score(item) * (1 + Math.min(item.watchers / 100, 1));
			};
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: 'https://api.github.com/legacy/repos/search/' + encodeURIComponent(query),
				type: 'GET',
				error: function() {
					callback();
				},
				success: function(res) {
					callback(res.repositories.slice(0, 10));
				}
			});
		}
	});

	// Lock selectize
	$('.selectize-locked').selectize({create: true});
	$('.selectize-locked')[0].selectize.lock();

	// Sort select options
	$('.selectize-sort').selectize({
		sortField: 'text'
	});

	// Performance with mess options
	var letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUV';
	var options = [];
	for (var i = 0; i < 25000; i++) {
		var title = [];
		for (var j = 0; j < 8; j++) {
			title.push(letters.charAt(Math.round((letters.length - 1) * Math.random())));
		}
		options.push({
			id: i,
			title: title.join('')
		});
	}
	$('.selectize-junk').selectize({
		maxItems: null,
		maxOptions: 100,
		valueField: 'id',
		labelField: 'title',
		searchField: 'title',
		sortField: 'title',
		options: options,
		create: false
	});

	// Movie API
	$('.selectize-movie').selectize({
		valueField: 'title',
		labelField: 'title',
		searchField: 'title',
		options: [],
		create: false,
		render: {
			option: function(item, escape) {
				var actors = [];
				for (var i = 0, n = item.abridged_cast.length; i < n; i++) {
					actors.push('<span>' + escape(item.abridged_cast[i].name) + '</span>');
				}

				return '<div>' +
					'<img src="' + escape(item.posters.thumbnail) + '" alt="">' +
					'<span class="title"> ' +
						'<span class="name">' + escape(item.title) + '</span>' +
					'</span>' +
					'<span class="description">' + escape(item.synopsis || 'No synopsis available at this time.') + '</span>' +
					'<span class="actors">' + (actors.length ? 'Starring ' + actors.join(', ') : 'Actors unavailable') + '</span>' +
				'</div>';
			}
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: 'http://api.rottentomatoes.com/api/public/v1.0/movies.json',
				type: 'GET',
				dataType: 'jsonp',
				data: {
					q: query,
					page_limit: 10,
					apikey: '6czx2pst57j3g47cvq9erte5'
				},
				error: function() {
					callback();
				},
				success: function(res) {
					console.log(res.movies);
					callback(res.movies);
				}
			});
		}
	});
	// Movie API Ends

	// Customization Link
	$('.selectize-links').selectize({
		theme: 'links',
		maxItems: null,
		valueField: 'id',
		searchField: 'title',
		options: [
			{id: 1, title: 'DIY', url: 'https://diy.org'},
			{id: 2, title: 'Google', url: 'http://google.com'},
			{id: 3, title: 'Yahoo', url: 'http://yahoo.com'},
		],
		render: {
			option: function(data, escape) {
				return '<div class="option">' +
						'<span class="title">' + escape(data.title) + '</span>' +
						'<span class="url">' + escape(data.url) + '</span>' +
					'</div>';
			},
			item: function(data, escape) {
				return '<div class="item"><a href="' + escape(data.url) + '">' + escape(data.title) + '</a></div>';
			}
		},
		create: function(input) {
			return {
				id: 0,
				title: input,
				url: '#'
			};
		}
	});

	// Plugin with remove button
	$('.remove-tags').selectize({
		plugins: ['remove_button'],
		persist: false,
		create: true,
		render: {
			item: function(data, escape) {
				return '<div>"' + escape(data.text) + '"</div>';
			}
		},
		onDelete: function(values) {
			return confirm(values.length > 1 ? 'Are you sure you want to remove these ' + values.length + ' items?' : 'Are you sure you want to remove "' + values[0] + '"?');
		}
	});

	// With Backspase
	$('.backup-restore').selectize({
		plugins: ['restore_on_backspace'],
		persist: false,
		create: true
	});

	//Drag Drop options
	$('.selectise-drap-drop').selectize({
		plugins: ['drag_drop'],
		persist: false,
		create: true
	});

	// RTL Input
	$('.selectize-rtl-input').selectize({
		persist: false,
		create: true
	});
	$('.selectize-rtl-select').selectize();

})(window, document, jQuery);