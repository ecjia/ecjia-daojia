/*=========================================================================================
    File Name: tree-view.js
    Description: Bootstrap Tree View
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(document).ready(function(){

    var defaultData = [{
        text: 'Parent 1',
        href: '#parent1',
        tags: ['4'],
        nodes: [{
            text: 'Child 1',
            href: '#child1',
            tags: ['2'],
            nodes: [{
                text: 'Grandchild 1',
                href: '#grandchild1',
                tags: ['0']
            }, {
                text: 'Grandchild 2',
                href: '#grandchild2',
                tags: ['0']
            }]
        }, {
            text: 'Child 2',
            href: '#child2',
            tags: ['0']
        }]
    }, {
        text: 'Parent 2',
        href: '#parent2',
        tags: ['0']
    }, {
        text: 'Parent 3',
        href: '#parent3',
        tags: ['0']
    }, {
        text: 'Parent 4',
        href: '#parent4',
        tags: ['0']
    }, {
        text: 'Parent 5',
        href: '#parent5',
        tags: ['0']
    }];

    var alternateData = [{
        text: 'Parent 1',
        tags: ['2'],
        nodes: [{
            text: 'Child 1',
            tags: ['3'],
            nodes: [{
                text: 'Grandchild 1',
                tags: ['6']
            }, {
                text: 'Grandchild 2',
                tags: ['3']
            }]
        }, {
            text: 'Child 2',
            tags: ['3']
        }]
    }, {
        text: 'Parent 2',
        tags: ['7']
    }, {
        text: 'Parent 3',
        icon: 'ft-map-pin',
        href: '#demo',
        tags: ['11']
    }, {
        text: 'Parent 4',
        icon: 'ft-download-cloud',
        href: '/index.html',
        tags: ['19'],
        selected: true
    }, {
        text: 'Parent 5',
        icon: 'ft-message-square',
        color: '#FFF',
        backColor: '#e8273a',
        href: 'http://www.pixinvent.com',
        tags: ['available', '0']
    }];

    var json = '[' +
        '{' +
        '"text": "Parent 1",' +
        '"nodes": [' +
        '{' +
        '"text": "Child 1",' +
        '"nodes": [' +
        '{' +
        '"text": "Grandchild 1"' +
        '},' +
        '{' +
        '"text": "Grandchild 2"' +
        '}' +
        ']' +
        '},' +
        '{' +
        '"text": "Child 2"' +
        '}' +
        ']' +
        '},' +
        '{' +
        '"text": "Parent 2"' +
        '},' +
        '{' +
        '"text": "Parent 3"' +
        '},' +
        '{' +
        '"text": "Parent 4"' +
        '},' +
        '{' +
        '"text": "Parent 5"' +
        '}' +
        ']';


    // Default Treeview
    $('#default-treeview').treeview({
        data: defaultData
    });

    // Collapsed Treeview
    $('#collapsed-treeview').treeview({
        levels: 1,
        data: defaultData
    });

    // Epanded Treeview
    $('#expanded-treeview').treeview({
        levels: 99,
        data: defaultData
    });

    // Primary Color
    $('#primary-color-treeview').treeview({
        color: "#967ADC",
        data: defaultData
    });

    // Custom Icons
    $('#custom-icon-treeview').treeview({
        color: "#967ADC",
        expandIcon: 'ft-chevron-right',
        collapseIcon: 'ft-chevron-down',
        nodeIcon: 'ft-bookmark',
        data: defaultData
    });

    // Tags as Badges
    $('#tags-badge-treeview').treeview({
        color: "#967ADC",
        expandIcon: "ft-stop-circle",
        collapseIcon: "ft-check-square",
        nodeIcon: "ft-user",
        showTags: true,
        data: defaultData
    });

    // No Border
    $('#no-border-treeview').treeview({
        color: "#967ADC",
        showBorder: false,
        data: defaultData
    });


    // Colourful
    $('#colourful-treeview').treeview({
        expandIcon: "ft-stop-circle",
        collapseIcon: "ft-check-square",
        nodeIcon: "ft-user",
        color: "#FFF",
        backColor: "#3BAFDA",
        onhoverColor: "#1cade0",
        borderColor: "#1cade0",
        showBorder: false,
        showTags: true,
        highlightSelected: true,
        selectedColor: "#FFF",
        selectedBackColor: "#1cade0",
        data: defaultData
    });

    // Node Overrides
    $('#node-override-treeview').treeview({
        expandIcon: "ft-stop-circle",
        collapseIcon: "ft-check-square",
        nodeIcon: "ft-user",
        color: "#FFF",
        backColor: "#3BAFDA",
        onhoverColor: "#1cade0",
        borderColor: "#1cade0",
        showBorder: false,
        showTags: true,
        highlightSelected: true,
        selectedColor: "#FFF",
        selectedBackColor: "#1cade0",
        data: alternateData
    });

    // Link Enabled
    $('#link-enabled-treeview').treeview({
        color: "#967ADC",
        enableLinks: true,
        data: defaultData
    });


    // Disabled Tree
    var $disabledTree = $('#disabled-treeview').treeview({
        data: defaultData,
        onNodeDisabled: function(event, node) {
            $('#disabled-output').prepend('<p>' + node.text + ' was disabled</p>');
        },
        onNodeEnabled: function(event, node) {
            $('#disabled-output').prepend('<p>' + node.text + ' was enabled</p>');
        },
        onNodeCollapsed: function(event, node) {
            $('#disabled-output').prepend('<p>' + node.text + ' was collapsed</p>');
        },
        onNodeUnchecked: function(event, node) {
            $('#disabled-output').prepend('<p>' + node.text + ' was unchecked</p>');
        },
        onNodeUnselected: function(event, node) {
            $('#disabled-output').prepend('<p>' + node.text + ' was unselected</p>');
        }
    });

    var findDisabledNodes = function() {
        return $disabledTree.treeview('search', [$('#input-disable-node').val(), {
            ignoreCase: false,
            exactMatch: false
        }]);
    };
    var disabledNodes = findDisabledNodes();

    // Expand/collapse all
    $('#btn-disable-all').on('click', function(e) {
        $disabledTree.treeview('disableAll', {
            silent: $('#chk-disable-silent').is(':checked')
        });
    });

    $('#btn-enable-all').on('click', function(e) {
        $disabledTree.treeview('enableAll', {
            silent: $('#chk-disable-silent').is(':checked')
        });
    });


    // json data treeview
    var $tree = $('#data-treeview').treeview({
        data: json
    });


    // Searchable Tree
    var $searchableTree = $('#searchable-tree').treeview({
        color: "#967ADC",
        showBorder: false,
        data: defaultData,
    });

    var search = function(e) {
        var pattern = $('#input-search').val();
        var options = {
            ignoreCase: $('#chk-ignore-case').is(':checked'),
            exactMatch: $('#chk-exact-match').is(':checked'),
            revealResults: $('#chk-reveal-results').is(':checked')
        };
        var results = $searchableTree.treeview('search', [pattern, options]);

        var output = '<p>' + results.length + ' matches found</p>';
        $.each(results, function(index, result) {
            output += '<p>- ' + result.text + '</p>';
        });
        $('#search-output').html(output);
    }

    $('#btn-search').on('click', search);
    $('#input-search').on('keyup', search);

    $('#btn-clear-search').on('click', function(e) {
        $searchableTree.treeview('clearSearch');
        $('#input-search').val('');
        $('#search-output').html('');
    });



    // Selectable Tree
    var initSelectableTree = function() {
        return $('#selectable-tree').treeview({
            data: defaultData,
            color: "#967ADC",
            showBorder: false,
            multiSelect: $('#chk-select-multi').is(':checked'),
        });
    };
    var $selectableTree = initSelectableTree();

    var findSelectableNodes = function() {
        return $selectableTree.treeview('search', [$('#input-select-node').val(), {
            ignoreCase: false,
            exactMatch: false
        }]);
    };
    var selectableNodes = findSelectableNodes();

    $('#chk-select-multi:checkbox').on('change', function() {
        console.log('multi-select change');
        $selectableTree = initSelectableTree();
        selectableNodes = findSelectableNodes();
    });

    // Select/unselect/toggle nodes
    $('#input-select-node').on('keyup', function(e) {
        selectableNodes = findSelectableNodes();
        $('.select-node').prop('disabled', !(selectableNodes.length >= 1));
    });

    $('#btn-select-node.select-node').on('click', function(e) {
        $selectableTree.treeview('selectNode', [selectableNodes]);
    });

    $('#btn-unselect-node.select-node').on('click', function(e) {
        $selectableTree.treeview('unselectNode', [selectableNodes]);
    });

    $('#btn-toggle-selected.select-node').on('click', function(e) {
        $selectableTree.treeview('toggleNodeSelected', [selectableNodes]);
    });



    // Expand / Collapse All
    var $expandibleTree = $('#expandible-tree').treeview({
        data: defaultData,
    });

    // Expand/collapse all
    $('#btn-expand-all').on('click', function(e) {
        var levels = $('#select-expand-all-levels').val();
        $expandibleTree.treeview('expandAll', {
            levels: 2
        });
    });

    $('#btn-collapse-all').on('click', function(e) {
        $expandibleTree.treeview('collapseAll');
    });



    // Check / Uncheck All
    var $checkableTree = $('#checkable-tree').treeview({
        data: defaultData,
        showIcon: false,
        showCheckbox: true,
    });

    // Check/uncheck all
    $('#btn-check-all').on('click', function(e) {
        $checkableTree.treeview('checkAll', {
            silent: $('#chk-check-silent').is(':checked')
        });
    });

    $('#btn-uncheck-all').on('click', function(e) {
        $checkableTree.treeview('uncheckAll', {
            silent: $('#chk-check-silent').is(':checked')
        });
    });
});