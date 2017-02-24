//Commas for decimal place 
jQuery.fn.dataTableExt.oSort['numeric-comma-asc']  = function(a,b) {
	var x = (a == "-") ? 0 : a.replace( /,/, "." );
	var y = (b == "-") ? 0 : b.replace( /,/, "." );
	x = parseFloat( x );
	y = parseFloat( y );
	return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};

jQuery.fn.dataTableExt.oSort['numeric-comma-desc'] = function(a,b) {
	var x = (a == "-") ? 0 : a.replace( /,/, "." );
	var y = (b == "-") ? 0 : b.replace( /,/, "." );
	x = parseFloat( x );
	y = parseFloat( y );
	return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};

//Formatted numbers
jQuery.fn.dataTableExt.oSort['formatted-num-asc'] = function(x,y){
	x = x.replace(/[^\d\-\.\/]/g,'');
	y = y.replace(/[^\d\-\.\/]/g,'');
	if(x.indexOf('/')>=0)x = eval(x);
	if(y.indexOf('/')>=0)y = eval(y);
	return x/1 - y/1;
}
jQuery.fn.dataTableExt.oSort['formatted-num-desc'] = function(x,y){
	x = x.replace(/[^\d\-\.\/]/g,'');
	y = y.replace(/[^\d\-\.\/]/g,'');
	if(x.indexOf('/')>=0)x = eval(x);
	if(y.indexOf('/')>=0)y = eval(y);
	return y/1 - x/1;
}

// Date (dd . mm[ . YYYY]) 
function calculate_date(date) {
	var date = date.replace(" ", "");
	
	if (date.indexOf('.') > 0) {
		/*date a, format dd.mn.(yyyy) ; (year is optional)*/
		var eu_date = date.split('.');
	} else {
		/*date a, format dd/mn/(yyyy) ; (year is optional)*/
		var eu_date = date.split('/');
	}
	
	/*year (optional)*/
	if (eu_date[2]) {
		var year = eu_date[2];
	} else {
		var year = 0;
	}
	
	/*month*/
	var month = eu_date[1];
	if (month.length == 1) {
		month = 0+month;
	}
	
	/*day*/
	var day = eu_date[0];
	if (day.length == 1) {
		day = 0+day;
	}
	
	return (year + month + day) * 1;
}

jQuery.fn.dataTableExt.oSort['eu_date-asc'] = function(a, b) {
	x = calculate_date(a);
	y = calculate_date(b);
	
	return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};

jQuery.fn.dataTableExt.oSort['eu_date-desc'] = function(a, b) {
	x = calculate_date(a);
	y = calculate_date(b);
	
	return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
};

//Automatic HTML type detection
jQuery.fn.dataTableExt.aTypes.push(
	function ( sData ) {
		return 'html';
	}
);

//Priority 
function fnPriority( a ) {
	if ( a == "High" )        { return 1; }
	else if ( a == "Medium" ) { return 2; }
	else if ( a == "Low" )    { return 3; }
	return 4;
}

jQuery.fn.dataTableExt.oSort['priority-asc']  = function(a,b) {
	var x = fnPriority( a );
	var y = fnPriority( b );
	
	return ((x < y) ? -1 : ((x > y) ? 1 : 0));
};

jQuery.fn.dataTableExt.oSort['priority-desc'] = function(a,b) {
	var x = fnPriority( a );
	var y = fnPriority( b );
	
	return ((x < y) ? 1 : ((x > y) ? -1 : 0));
};

/*
 * Natural Sort algorithm for Javascript - Version 0.6 - Released under MIT license
 * Author: Jim Palmer (based on chunking idea from Dave Koelle)
 * Contributors: Mike Grier (mgrier.com), Clint Priest, Kyle Adams, guillermo
 */
function naturalSort (a, b) {
	var re = /(^-?[0-9]+(\.?[0-9]*)[df]?e?[0-9]?$|^0x[0-9a-f]+$|[0-9]+)/gi,
		sre = /(^[ ]*|[ ]*$)/g,
		dre = /(^([\w ]+,?[\w ]+)?[\w ]+,?[\w ]+\d+:\d+(:\d+)?[\w ]?|^\d{1,4}[\/\-]\d{1,4}[\/\-]\d{1,4}|^\w+, \w+ \d+, \d{4})/,
		hre = /^0x[0-9a-f]+$/i,
		ore = /^0/,
		// convert all to strings and trim()
		x = a.toString().replace(sre, '') || '',
		y = b.toString().replace(sre, '') || '',
		// chunk/tokenize
		xN = x.replace(re, '\0$1\0').replace(/\0$/,'').replace(/^\0/,'').split('\0'),
		yN = y.replace(re, '\0$1\0').replace(/\0$/,'').replace(/^\0/,'').split('\0'),
		// numeric, hex or date detection
		xD = parseInt(x.match(hre)) || (xN.length != 1 && x.match(dre) && Date.parse(x)),
		yD = parseInt(y.match(hre)) || xD && y.match(dre) && Date.parse(y) || null;
	// first try and sort Hex codes or Dates
	if (yD)
		if ( xD < yD ) return -1;
		else if ( xD > yD )	return 1;
	// natural sorting through split numeric strings and default strings
	for(var cLoc=0, numS=Math.max(xN.length, yN.length); cLoc < numS; cLoc++) {
		// find floats not starting with '0', string or 0 if not defined (Clint Priest)
		oFxNcL = !(xN[cLoc] || '').match(ore) && parseFloat(xN[cLoc]) || xN[cLoc] || 0;
		oFyNcL = !(yN[cLoc] || '').match(ore) && parseFloat(yN[cLoc]) || yN[cLoc] || 0;
		// handle numeric vs string comparison - number < string - (Kyle Adams)
		if (isNaN(oFxNcL) !== isNaN(oFyNcL)) return (isNaN(oFxNcL)) ? 1 : -1; 
		// rely on string comparison if different types - i.e. '02' < 2 != '02' < '2'
		else if (typeof oFxNcL !== typeof oFyNcL) {
			oFxNcL += ''; 
			oFyNcL += ''; 
		}
		if (oFxNcL < oFyNcL) return -1;
		if (oFxNcL > oFyNcL) return 1;
	}
	return 0;
}

jQuery.fn.dataTableExt.oSort['natural-asc']  = function(a,b) {
	return naturalSort(a,b);
};

jQuery.fn.dataTableExt.oSort['natural-desc'] = function(a,b) {
	return naturalSort(a,b) * -1;
};