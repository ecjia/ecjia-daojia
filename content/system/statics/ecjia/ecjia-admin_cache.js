;(function(admin, $) {
    admin.admin_cache = {
        init : function(){
            admin.admin_cache.stepy();
            admin.admin_cache.tooltip();
            $('.check_all').trigger('click');
        },
        stepy : function() {
            $('#validate_wizard').stepy({
                nextLabel:      admin_cache_lang.start+'<i class="icon-chevron-right icon-white"></i>',
                backLabel:      '<i class="icon-chevron-left"></i> '+admin_cache_lang.retreat,
                block        : true,
                titleClick    : false,
                validate    : false,
                finishButton: true,
                next : function(){
                    $('.cacheshow').html('');
                    if($("input[name='cachekey']:checked").length >0){
                        var url = $('#validate_wizard').attr('action');
                        $("input[name='cachekey']:checked").each(function(i){
                            var cachekey = $(this).attr('value'),
                            objstr = "<dt>"+admin_cache_lang.clear+ $(this).closest('div').parent().text() + "</dt><dd><i class=' fontello-icon-spin4 clear" + i + "'></i></dd>";
                            $('.cacheshow').append(objstr);
                            $.post(url, 'cachekey='+cachekey, function(){
                                $('.clear' + i).attr('class', 'fontello-icon-ok');
                            });
                        });
                    }else{
                        smoke.alert(admin_cache_lang.pls_type_check);
                        return false;
                    }
                },
                back : function(){
                    $("input[name='cachekey']:checked").removeAttr('checked');
                    $("input[name='cachekey']").parent().removeClass('uni-checked');
                    $('.checkbox').trigger('click');
                }
            });

            $('.stepy-titles').each(function(){
                $(this).children('li').each(function(index){
                    var myIndex = index + 1
                    $(this).append('<span class="stepNb">'+myIndex+'</span>');
                })
            })
        },
        tooltip : function(){
            $('.choose label [data-toggle="tooltip"]').tooltip({
                trigger : 'hover',
                delay : 0,
                placement : 'top'
            });
        }

    }
})(ecjia.admin, $);
