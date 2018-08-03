/**
 * Created by Zura on 4/5/2016.
 */
$(function () {
    Lobibox.notify.DEFAULTS = $.extend({}, Lobibox.notify.DEFAULTS, {
        size: 'mini',
        // delay: false,
        position: 'right top'
    });

    //Basic example
    $('#todo-lists-basic-demo').lobiList({
        lists: [
            {
                title: 'Backlog',
                defaultStyle: 'lobilist-primary',
                items: [
                    {
                        title: 'Complete the page header',
                        description: 'Phasellus vel elit volutpat, egestas urna a, pharetra nibh.',
                        dueDate: '2016-12-31'
                    },
                    {
                        title: 'Menu open issue on top',
                        description: 'Proin varius libero at magna dignissim lacinia.',
                        dueDate: '2016-12-22',
                        done: true
                    },
                    {
                        title: 'Integrate ChartJS Page',
                        description: 'Curabitur tempor, quam vel pulvinar finibus.',
                        dueDate: '2016-12-29',
                    },
                    {
                        title: 'UI/UX Design for the new Mobile APP',
                        description: 'Rowed cloven frolic thereby, vivamus pining gown intruding strangers prank treacherously darkling.',
                        dueDate: '2016-12-28'
                    }
                ]
            },
            {
                title: 'To do',
                defaultStyle: 'lobilist-danger',
                items: [
                    {
                        title: 'PSD Creation for the ABC APP',
                        description: 'Hoary rattle exulting suspendisse elit paradises craft wistful. Bayonets allures prefer traits wrongs flushed. Tent wily matched bold polite slab coinage celerities gales beams.',
                        dueDate: '2016-12-28'
                    },
                    {
                        title: 'Fix bootstrap progress bar issue'
                    },
                    {
                        title: 'Support Alib on form wizard',
                        description: 'Came champlain live leopards twilight whenever warm read wish squirrel rock.',
                        dueDate: '2016-02-04',
                        done: true
                    },
                    {
                        title: 'Support Charls Users',
                        description: 'Leopards twilight whenever warm read wish squirrel rock.',
                        dueDate: '2016-02-04',
                        done: true
                    }
                ]
            },
            {
                title: 'In Progress',
                defaultStyle: 'lobilist-warning',
                items: [
                    {
                        title: 'Fix bootstrap progress bar issue',
                        description: 'Hoary rattle exulting suspendisse elit paradises craft wistful. Bayonets allures prefer traits wrongs flushed. Tent wily matched bold polite slab coinage celerities gales beams.',
                        dueDate: '2016-12-04',
                    },
                    {
                        title: 'Integrate D3 JS Page',
                        description: 'Aliquam finibus tellus magna, eget viverra augue gravida eget.',
                        dueDate: '2016-12-05',
                    },
                    {
                        title: 'Contact Charls for Vertical Menu issue',
                        description: 'Came champlain live leopards twilight whenever warm read wish squirrel rock.',
                        dueDate: '2016-12-12',
                        done: true
                    }
                ]
            },
            {
                title: 'Done',
                defaultStyle: 'lobilist-info',
                items: [
                    {
                        title: 'Admin PSD Creation for the ABC APP',
                        description: 'Hoary rattle exulting suspendisse elit paradises craft wistful. Bayonets allures prefer traits wrongs flushed. Tent wily matched bold polite slab coinage celerities gales beams.',
                        done: true
                    },
                    {
                        title: 'Complete dashboard page design',
                        done: true
                    },
                    {
                        title: 'Horizontal Menu Test on Mobile',
                        description: 'Came champlain live leopards twilight whenever warm read wish squirrel rock.',
                        dueDate: '2016-12-24',
                        done: true
                    }
                ]
            },
            {
                title: 'Verify',
                defaultStyle: 'lobilist-success',
                items: [
                    {
                        title: 'Menu PSD Creation for the ABC APP',
                        description: 'Hoary rattle exulting suspendisse elit paradises craft wistful. Bayonets allures prefer traits wrongs flushed. Tent wily matched bold polite slab coinage celerities gales beams.',
                        done: true
                    },
                    {
                        title: 'Vertical Menu Test on Mobile',
                        description: 'Came champlain live leopards twilight whenever warm read wish squirrel rock.',
                        dueDate: '2016-12-24',
                        done: true
                    }
                ]
            }
        ]
    });

    // Event handling
    (function () {
        var list;

        $('#todo-lists-initialize-btn').on('click', function () {
            list = $('#todo-lists-demo-events')
                .lobiList({
                    init: function () {
                        Lobibox.notify('default', {
                            msg: 'init'
                        });
                    },
                    beforeDestroy: function () {
                        Lobibox.notify('default', {
                            msg: 'beforeDestroy'
                        });
                    },
                    afterDestroy: function () {
                        Lobibox.notify('default', {
                            msg: 'afterDestroy'
                        });
                    },
                    beforeListAdd: function () {
                        Lobibox.notify('default', {
                            msg: 'beforeListAdd'
                        });
                    },
                    afterListAdd: function () {
                        Lobibox.notify('default', {
                            msg: 'afterListAdd'
                        });
                    },
                    beforeListRemove: function () {
                        Lobibox.notify('default', {
                            msg: 'beforeListRemove'
                        });
                    },
                    afterListRemove: function () {
                        Lobibox.notify('default', {
                            msg: 'afterListRemove'
                        });
                    },
                    beforeItemAdd: function () {
                        Lobibox.notify('default', {
                            msg: 'beforeItemAdd'
                        });
                    },
                    afterItemAdd: function () {
                        console.log(arguments);
                        Lobibox.notify('default', {
                            msg: 'afterItemAdd'
                        });
                    },
                    beforeItemUpdate: function () {
                        Lobibox.notify('default', {
                            msg: 'beforeItemUpdate'
                        });
                    },
                    afterItemUpdate: function () {
                        console.log(arguments);
                        Lobibox.notify('default', {
                            msg: 'afterItemUpdate'
                        });
                    },
                    beforeItemDelete: function () {
                        Lobibox.notify('default', {
                            msg: 'beforeItemDelete'
                        });
                    },
                    afterItemDelete: function () {
                        Lobibox.notify('default', {
                            msg: 'afterItemDelete'
                        });
                    },
                    beforeListDrop: function () {
                        Lobibox.notify('default', {
                            msg: 'beforeListDrop'
                        });
                    },
                    afterListReorder: function () {
                        Lobibox.notify('default', {
                            msg: 'afterListReorder'
                        });
                    },
                    beforeItemDrop: function () {
                        Lobibox.notify('default', {
                            msg: 'beforeItemDrop'
                        });
                    },
                    afterItemReorder: function () {
                        Lobibox.notify('default', {
                            msg: 'afterItemReorder'
                        });
                    },
                    afterMarkAsDone: function () {
                        Lobibox.notify('default', {
                            msg: 'afterMarkAsDone'
                        });
                    },
                    afterMarkAsUndone: function () {
                        Lobibox.notify('default', {
                            msg: 'afterMarkAsUndone'
                        });
                    },
                    styleChange: function(list, oldStyle, newStyle){
                        console.log(arguments);
                        Lobibox.notify('default', {
                            msg: 'styleChange: Old style - "'+oldStyle+'". New style - "'+ newStyle +'"'
                        });
                    },
                    titleChange: function(list, oldTitle, newTitle){
                        console.log(arguments);
                        Lobibox.notify('default', {
                            msg: 'titleChange: Old title - "'+oldTitle+'". New title - "'+ newTitle + '"'
                        });
                    },
                    lists: [
                        {
                            title: 'TODO',
                            defaultStyle: 'lobilist-info',
                            items: [
                                {
                                    title: 'Floor cool cinders',
                                    description: 'Thunder fulfilled travellers folly, wading, lake.',
                                    dueDate: '2015-01-31'
                                },
                                {
                                    title: 'Periods pride',
                                    description: 'Accepted was mollis',
                                    done: true
                                },
                                {
                                    title: 'Flags better burns pigeon',
                                    description: 'Rowed cloven frolic thereby, vivamus pining gown intruding strangers prank ' +
                                    'treacherously darkling.'
                                },
                                {
                                    title: 'Accepted was mollis',
                                    description: 'Rowed cloven frolic thereby, vivamus pining gown intruding strangers prank ' +
                                    'treacherously darkling.',
                                    dueDate: '2015-02-02'
                                }
                            ]
                        }
                    ]
                })
                .data('lobiList');
        });

        $('#todo-lists-destroy-btn').on('click', function () {
            list.destroy();
        });
    })();
    // Custom controls
    $('#todo-lists-demo-controls').lobiList({
        lists: [
            {
                title: 'TODO',
                defaultStyle: 'lobilist-info',
                controls: ['edit', 'styleChange'],
                items: [
                    {
                        title: 'Floor cool cinders',
                        description: 'Thunder fulfilled travellers folly, wading, lake.',
                        dueDate: '2015-01-31'
                    }
                ]
            },
            {
                title: 'Custom checkboxes',
                defaultStyle: 'lobilist-danger',
                controls: ['edit', 'add', 'remove'],
                useLobicheck: false,
                items: [
                    {
                        title: 'Periods pride',
                        description: 'Accepted was mollis',
                        done: true
                    }
                ]
            },
            {
                title: 'Controls disabled',
                defaultStyle: 'lobilist-primary',
                controls: false,
                items: [
                    {
                        title: 'Composed trays',
                        description: 'Hoary rattle exulting suspendisse elit paradises craft wistful. ' +
                        'Bayonets allures prefer traits wrongs flushed. Tent wily matched bold polite slab coinage ' +
                        'celerities gales beams.'
                    }
                ]
            },
            {
                title: 'Disabled todo edit/remove',
                defaultStyle: 'lobilist-warning',
                enableTodoRemove: false,
                enableTodoEdit: false,
                items: [
                    {
                        title: 'Composed trays',
                        description: 'Hoary rattle exulting suspendisse elit paradises craft wistful. ' +
                        'Bayonets allures prefer traits wrongs flushed. Tent wily matched bold polite slab coinage ' +
                        'celerities gales beams.'
                    }
                ]
            }
        ]
    });
    // Disabled drag & drop
    $('#todo-lists-demo-sorting').lobiList({
        sortable: false,
        lists: [
            {
                title: 'TODO',
                defaultStyle: 'lobilist-info',
                controls: ['edit', 'styleChange'],
                items: [
                    {
                        title: 'Floor cool cinders',
                        description: 'Thunder fulfilled travellers folly, wading, lake.',
                        dueDate: '2015-01-31'
                    }
                ]
            },
            {
                title: 'Controls disabled',
                defaultStyle: 'lobilist-success',
                controls: false,
                items: [
                    {
                        title: 'Composed trays',
                        description: 'Hoary rattle exulting suspendisse elit paradises craft wistful. Bayonets allures prefer traits wrongs flushed. Tent wily matched bold polite slab coinage celerities gales beams.'
                    }
                ]
            }
        ]
    });

    $('#actions-by-ajax').lobiList({
        actions: {
            load: '../data/lobilist/load.json',
            insert: '../data/lobilist/insert.php',
            delete: '../data/lobilist/delete.php',
            update: '../data/lobilist/update.php'
        },
        afterItemAdd: function(){
            console.log(arguments);
        }
    });
});

$(document).ready(function() {
    $( ".datepicker-default" ).datepicker();

    $.each($('.lobilists-wrapper'), function(index, val) {
        $(this).perfectScrollbar({
            suppressScrollY : true,
            theme: "dark",
            wheelPropagation: true
        });
    });

    $('.lobilist-wrapper').perfectScrollbar({
        theme: "dark",
        wheelPropagation: true
    });
});