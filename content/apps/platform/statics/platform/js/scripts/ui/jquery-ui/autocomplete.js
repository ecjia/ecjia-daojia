/*=========================================================================================
    File Name: autocomplete.js
    Description: jQuery UI autocomplete
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function(){

	/************************************
	*			Auto Complete			*
	************************************/

	var peopleTags = [
        "Aaron",
        "Abel",
        "Bacon",
        "Barry",
        "Clancy",
        "Cornstalk",
        "Daniel",
        "David",
        "Edison",
        "Frank",
        "George",
        "Hamilton",
        "Irvine",
        "Jackson",
        "Kelly",
        "Lumb",
        "Magee",
        "Newton",
        "Olson",
        "Paul",
        "Quine",
        "Roy",
        "Smith",
        "Tony",
        "Young",
        "Zampa"
    ];
    $( ".ac-default" ).autocomplete({
        source: peopleTags
    });

    // Accent Folding
    var names = ["Jörn Zaefferer", "Scott González", "John Resig"];

    var accentMap = {
        "á": "a",
        "ö": "o"
    };
    var normalize = function(term) {
        var ret = "";
        for (var i = 0; i < term.length; i++) {
            ret += accentMap[term.charAt(i)] || term.charAt(i);
        }
        return ret;
    };

    $(".ac-accent-folding").autocomplete({
        source: function(request, response) {
            var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(names, function(value) {
                value = value.label || value.value || value;
                return matcher.test(value) || matcher.test(normalize(value));
            }));
        }
    });

    // Categories
    $.widget("custom.catcomplete", $.ui.autocomplete, {
        _create: function() {
            this._super();
            this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
        },
        _renderMenu: function(ul, items) {
            var that = this,
                currentCategory = "";
            $.each(items, function(index, item) {
                var li;
                if (item.category != currentCategory) {
                    ul.append("<li class='ui-autocomplete-category'>" + item.category + "</li>");
                    currentCategory = item.category;
                }
                li = that._renderItemData(ul, item);
                if (item.category) {
                    li.attr("aria-label", item.category + " : " + item.label);
                }
            });
        }
    });
    var data = [{
        label: "anders",
        category: ""
    }, {
        label: "andreas",
        category: ""
    }, {
        label: "antal",
        category: ""
    }, {
        label: "annhhx10",
        category: "Products"
    }, {
        label: "annk K12",
        category: "Products"
    }, {
        label: "annttop C13",
        category: "Products"
    }, {
        label: "anders andersson",
        category: "People"
    }, {
        label: "andreas andersson",
        category: "People"
    }, {
        label: "andreas johnson",
        category: "People"
    }];

    $(".ac-category").catcomplete({
        delay: 0,
        source: data
    });


    // Combobox
    $.widget("custom.combobox", {
        _create: function() {
            this.wrapper = $("<div>")
                .addClass("custom-combobox input-group")
                .insertAfter(this.element);

            // Add Search Icon and Toggel Button
            $('<div class="input-group-prepend"><span class="input-group-text"><i class="ft-search"></i></span></div>')
            .appendTo(this.wrapper);

            this.element.hide();
            this._createAutocomplete();
            this._createShowAllButton();
        },

        _createAutocomplete: function() {
            var selected = this.element.children(":selected"),
                value = selected.val() ? selected.text() : "";

            this.input = $("<input>")
                .appendTo(this.wrapper)
                .val(value)
                .attr("title", "")
                .addClass("custom-combobox-input form-control ui-widget ui-widget-content ui-state-default ui-corner-left")
                .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: $.proxy(this, "_source")
                })
                .tooltip({
                    classes: {
                        "ui-tooltip": "ui-state-highlight"
                    }
                });

            this._on(this.input, {
                autocompleteselect: function(event, ui) {
                    ui.item.option.selected = true;
                    this._trigger("select", event, {
                        item: ui.item.option
                    });
                },

                autocompletechange: "_removeIfInvalid"
            });
        },

        _createShowAllButton: function() {
            var input = this.input,
                wasOpen = false;

            $('<div class="input-group-prepend"><span class="input-group-text ac-toggle"><i class="ft-chevron-down"></i></span></div>')
                .attr("tabIndex", -1)
                .appendTo(this.wrapper)
                .removeClass("ui-corner-all")
                .addClass("custom-combobox-toggle ui-corner-right")
                .on("mousedown", function() {
                    wasOpen = input.autocomplete("widget").is(":visible");
                })
                .on("click", function() {
                    input.trigger("focus");

                    // Close if already visible
                    if (wasOpen) {
                        return;
                    }

                    // Pass empty string as value to search for, displaying all results
                    input.autocomplete("search", "");
                });
        },

        _source: function(request, response) {
            var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
            response(this.element.children("option").map(function() {
                var text = $(this).text();
                if (this.value && (!request.term || matcher.test(text)))
                    return {
                        label: text,
                        value: text,
                        option: this
                    };
            }));
        },

        _removeIfInvalid: function(event, ui) {

            // Selected an item, nothing to do
            if (ui.item) {
                return;
            }

            // Search for a match (case-insensitive)
            var value = this.input.val(),
                valueLowerCase = value.toLowerCase(),
                valid = false;
            this.element.children("option").each(function() {
                if ($(this).text().toLowerCase() === valueLowerCase) {
                    this.selected = valid = true;
                    return false;
                }
            });

            // Found a match, nothing to do
            if (valid) {
                return;
            }

            // Remove invalid value
            this.input
                .val("")
                .attr("title", value + " didn't match any item")
                .tooltip("open");
            this.element.val("");
            this._delay(function() {
                this.input.tooltip("close").attr("title", "");
            }, 2500);
            this.input.autocomplete("instance").term = "";
        },

        _destroy: function() {
            this.wrapper.remove();
            this.element.show();
        }
    });

    $(".ac-combobox").combobox();


    // Custom Data & Display
    var projects = [{
        value: "jquery",
        label: "jQuery",
        desc: "the write less, do more, JavaScript library",
        icon: "jquery_32x32.png"
    }, {
        value: "jquery-ui",
        label: "jQuery UI",
        desc: "the official user interface library for jQuery",
        icon: "jqueryui_32x32.png"
    }, {
        value: "sizzlejs",
        label: "Sizzle JS",
        desc: "a pure-JavaScript CSS selector engine",
        icon: "sizzlejs_32x32.png"
    }];

    $(".ac-project").autocomplete({
        minLength: 0,
        source: projects,
        focus: function(event, ui) {
            $(".ac-project").val(ui.item.label);
            return false;
        },
        select: function(event, ui) {
            $(".ac-project").val(ui.item.label);
            $(".ac-project-id").val(ui.item.value);
            $(".ac-project-description").html(ui.item.desc);

            return false;
        }
    })
    .autocomplete("instance")._renderItem = function(ul, item) {
        return $("<li>")
            .append("<div>" + item.label + "<br>" + item.desc + "</div>")
            .appendTo(ul);
    };

    // Multiple Values
    function split(val) {
        return val.split(/,\s*/);
    }

    function extractLast(term) {
        return split(term).pop();
    }

    $(".ac-multiple-values")
    // don't navigate away from the field on tab when selecting an item
    .on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
    .autocomplete({
        minLength: 0,
        source: function(request, response) {
            // delegate back to autocomplete, but extract the last term
            response($.ui.autocomplete.filter(
                peopleTags, extractLast(request.term)));
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function(event, ui) {
            var terms = split(this.value);
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join(", ");
            return false;
        }
    });

    // Remote Datasource
    $(".ac-remote-datasource").autocomplete({
        source: "../../../app-assets/data/jquery-ui/search.php",
        minLength: 2
    });

    // Remote with caching
    var cache = {};
    $(".ac-remote-caching").autocomplete({
        minLength: 2,
        source: function(request, response) {
            var term = request.term;
            if (term in cache) {
                response(cache[term]);
                return;
            }

            $.getJSON("../../../app-assets/data/jquery-ui/search.php", request, function(data, status, xhr) {
                cache[term] = data;
                response(data);
            });
        }
    });

    // Multiple Remote
    function split_r(val) {
        return val.split(/,\s*/);
    }

    function extractLast_r(term) {
        return split_r(term).pop();
    }

    $(".ac-multiple-remote")
    // don't navigate away from the field on tab when selecting an item
    .on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
    .autocomplete({
        source: function(request, response) {
            $.getJSON("../../../app-assets/data/jquery-ui/search.php", {
                term: extractLast_r(request.term)
            }, response);
        },
        search: function() {
            // custom minLength
            var term = extractLast_r(this.value);
            if (term.length < 2) {
                return false;
            }
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function(event, ui) {
            var terms = split_r(this.value);
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join(", ");
            return false;
        }
    });

    // XML Data Pasing
    $.ajax({
        url: "../../../app-assets/data/jquery-ui/london.xml",
        dataType: "xml",
        success: function(xmlResponse) {
            var data = $("geoname", xmlResponse).map(function() {
                return {
                    value: $("name", this).text() + ", " +
                        ($.trim($("countryName", this).text()) || "(unknown country)"),
                    id: $("geonameId", this).text()
                };
            }).get();
            $(".ac-xml-data-parse").autocomplete({
                source: data,
                minLength: 0,
            });
        }
    });
});