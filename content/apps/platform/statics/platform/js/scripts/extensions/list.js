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

	/********************************************
	*				Basic List					*
	********************************************/
	var basic_list_options = {
		valueNames: [ 'name', 'born' ]
	};

	var basicList = new List('basic-list', basic_list_options);



	/************************************************
	*				Add List Item					*
	************************************************/
	var add_options = {
		valueNames: ['name', 'born']
	};

	var add_values = [{
		name: "Martina Elm",
		born: 1986
	}];

	var addList = new List('add-item-list', add_options, add_values);

	addList.add({
		name: "Gustaf Lindqvist",
		born: 1983
	});



	/********************************************
	*				New List					*
	********************************************/
	var new_list_options = {
		valueNames: ['name', 'born'],
		item: '<li class="list-group-item"><h3 class="name"></h3><p class="born"></p></li>'
	};

	var new_values = [{
		name: 'Jonny Strömberg',
		born: 1986
	}, {
		name: 'Jonas Arnklint',
		born: 1985
	}, {
		name: 'Martina Elm',
		born: 1986
	}];

	var newList = new List('new-list', new_list_options, new_values);

	newList.add({
		name: "Gustaf Lindqvist",
		born: 1983
	});


	/********************************************
	*				Table List					*
	********************************************/
	var table_options = {
		valueNames: ['name', 'born']
	};

	var tableList = new List('table-list', table_options);


	/************************************************************
	*				Data Attributes + Custom					*
	************************************************************/
	var data_attr_options = {
		valueNames: [
			'id',
			'name',
			'born',
			{ data: ['id'] },
			{ attr: 'src', name: 'image' },
			{ attr: 'href', name: 'link' },
			{ attr: 'data-timestamp', name: 'timestamp' }
		]
	};
	var dataAttrList = new List('data-attributes-list', data_attr_options);
	dataAttrList.add({
		name: 'Leia',
		born: '1954',
		image: '../../../app-assets/images/portrait/small/avatar-s-8.png',
		link: "https://pixinvent.com",
		id: 5,
		timestamp: '67893'
	});



	/************************************************
	*				Add Get Remove					*
	************************************************/
	var options = {
		valueNames: ['id', 'name', 'age', 'city']
	};

	// Init list
	var contactList = new List('editable-list', options);

	var idField = $('#id-field'),
		nameField = $('#name-field'),
		ageField = $('#age-field'),
		cityField = $('#city-field'),
		addBtn = $('#add-btn'),
		editBtn = $('#edit-btn').hide(),
		removeBtns = $('.remove-item-btn'),
		editBtns = $('.edit-item-btn');

	// Sets callbacks to the buttons in the list
	refreshCallbacks();

	addBtn.on('click', function() {
		contactList.add({
			id: Math.floor(Math.random() * 110000),
			name: nameField.val(),
			age: ageField.val(),
			city: cityField.val()
		});
		clearFields();
		refreshCallbacks();
	});

	editBtn.on('click', function() {
		var item = contactList.get('id', idField.val())[0];
		item.values({
			id: idField.val(),
			name: nameField.val(),
			age: ageField.val(),
			city: cityField.val()
		});
		clearFields();
		editBtn.hide();
		addBtn.show();
	});

	function refreshCallbacks() {
		// Needed to add new buttons to jQuery-extended object
		removeBtns = $(removeBtns.selector);
		editBtns = $(editBtns.selector);

		removeBtns.on('click', function() {
			var itemId = $(this).closest('tr').find('.id').text();
			contactList.remove('id', itemId);
		});

		editBtns.on('click', function() {
			var itemId = $(this).closest('tr').find('.id').text();
			var itemValues = contactList.get('id', itemId)[0].values();
			idField.val(itemValues.id);
			nameField.val(itemValues.name);
			ageField.val(itemValues.age);
			cityField.val(itemValues.city);

			editBtn.show();
			addBtn.hide();
		});
	}

	function clearFields() {
		nameField.val('');
		ageField.val('');
		cityField.val('');
	}


	/************************************************
	*				Fuzzy Search					*
	************************************************/
	var fuzzySearchList = new List('fuzzy-search-list', {
		valueNames: ['name'],
		plugins: [ListFuzzySearch()]
	});



	/********************************************
	*				Pagination					*
	********************************************/
	var paginationList = new List('pagination-list', {
		valueNames: ['name'],
		page: 3,
		plugins: [ListPagination({})]
	});

});