/*=========================================================================================
    File Name: drag-drop.js
    Description: drag & drop elements using dragula js
    --------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


$(document).ready(function(){

	// Draggable Cards
    dragula([document.getElementById('card-drag-area')]);

    // Sortable Lists
    dragula([document.getElementById('basic-list-group')]);
    dragula([document.getElementById('list-group-tags')]);
    dragula([document.getElementById('list-group-buttons')]);
    dragula([document.getElementById('list-group-classes')]);


    // Sortable Tabs
    dragula([document.getElementById('tabs-icon-drag')]);
    dragula([document.getElementById('tab-top-line-drag')]);
    dragula([document.getElementById('tab-bottom-line-drag')]);
    dragula([document.getElementById('tab-bottom-arrow-drag')]);
    dragula([document.getElementById('tab-icon-fall-drag')]);
    dragula([document.getElementById('tab-icon-top-line-drag')]);


    // Sortable Pills
    dragula([document.getElementById('basic-pills-drag')]);
    dragula([document.getElementById('bordered-pills-drag')]);
    dragula([document.getElementById('toolbar-pills-drag')]);
    dragula([document.getElementById('justified-pills-drag')]);
    dragula([document.getElementById('stacked-pills-drag')]);
    dragula([document.getElementById('left-icon-pills-drag')]);


    // Sortable Navs
    dragula([document.getElementById('base-nav-drag')]);
    dragula([document.getElementById('nav-divider-drag')]);
    dragula([document.getElementById('heading-icon-drag')]);
    dragula([document.getElementById('both-side-link-icons-drag')]);


    // Sortable Collapsibles
    dragula([document.getElementById('basic-accordion-drag')]);
    dragula([document.getElementById('accordion-icon-drag')]);
    dragula([document.getElementById('headingCollapse1')]);
    dragula([document.getElementById('headingCollapse51')]);


    // Initialize Switchery
	var info = document.querySelectorAll('.switchery-info');
	for (i = 0; i < info.length; i++) {
		new Switchery(info[i], { color: '#3BAFDA'});
	}
});