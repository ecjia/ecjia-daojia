/*=========================================================================================
	File Name: drag-drop.js
	Description: drag & drop elements using dragula js
	--------------------------------------------------------------------------------------
	Item Name: Robust - Responsive Admin Template
	Version: 2.0
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/


$(document).ready(function(){
	// Draggable Cards
	dragula([document.getElementById('card-drag-area')]);

	// Change Card color if moved
	dragula([document.getElementById('card-move')])
	.on('drag', function (el) {
		el.className = el.className.replace('card-moved', '');
	}).on('drop', function (el) {
		el.className += ' card-moved';
	}).on('over', function (el, container) {
		container.className += ' card-over';
	}).on('out', function (el, container) {
		container.className = container.className.replace('card-over', '');
	});

	// Copy Cards
	dragula([document.getElementById("copy-left"), document.getElementById("copy-right")], {
		copy: true
	});

	// Drag Handles
	dragula([document.getElementById("left-handles"), document.getElementById("right-handles")], {
		moves: function (el, container, handle) {
			return handle.classList.contains('handle');
		}
	});

	// Drag Title Handles
	dragula([document.getElementById("left-titleHandles"), document.getElementById("right-titleHandles")], {
		moves: function (el, container, handle) {
			return handle.classList.contains('titleArea');
		}
	});

 });