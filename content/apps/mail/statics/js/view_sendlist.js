// JavaScript Document
;(function (app, $) {
    /**************遮罩效果js --start 后期完善该js并移到system里面************************/
    var CommonPerson = {};
    CommonPerson.Base = {};
    CommonPerson.Base.LoadingPic = {
        operation: {
            timeTest: null, //延时器
            loadingCount: 0, //计数器 当同时被多次调用的时候 记录次数
            loadingImgUrl: "loading.gif", //默认load图地址
            loadingImgHeight: 24, //Loading图的高
            loadingImgWidth: 24 //Loading图的宽
        },
 
        //显示全屏Loading图
        FullScreenShow: function (msg) {
            if (msg === undefined) {
                msg = js_lang.data_loading;
            }
 
            if ($("#div_loadingImg").length == 0) {
                $("body").append("<div id='div_loadingImg'></div>");
            }
            if (this.operation.loadingCount < 1) {
                this.operation.timeTest = setTimeout(function () {
                    $("#div_loadingImg").append("<div id='loadingPage_bg' class='loadingPage_bg1'></div><div id='loadingPage'>" + msg + "</div>");
                    $("#loadingPage_bg").height($(top.window.document).height()).width($(top.window.document).width());
                }, 100);
            }
            this.operation.loadingCount += 1;
        },
 
        //隐藏全屏Loading图
        FullScreenHide: function () {
            this.operation.loadingCount -= 1;
            if (this.operation.loadingCount <= 0) {
                clearTimeout(this.operation.timeTest);
                $("#div_loadingImg").empty();
                $("#div_loadingImg").remove();
                this.operation.loadingCount = 0;
            }
        },
 
        //显示局部Loading图
        PartShow: function ($parentContainer, url, msg) {
            var $partObj = $parentContainer;
            var $partBag = $(".loadingPage_bg1");
            var $partImage = $(".loadingPageimage");
            $partBag.remove(); //遮罩
            $partImage.remove();
            $partObj.removeClass('loadingPage_partDiv');
            if (msg === undefined) {
                msg = js_lang.sending_email;
            }
 
            var htmlText = ' <div class="loadingPage_bg1"></div><div class="loadingPageimage" >' + msg + '</div>';
            $partObj.addClass('loadingPage_partDiv');
            $partObj.append(htmlText);
            $partBag.height($partObj.height()).width($partObj.width());
        },
 
        //局部隐藏loading图
        PartHide: function ($parentContainer) {
            var $partObj = $parentContainer;
            var $partBag = $(".loadingPage_bg1");
            var $partImage = $(".loadingPageimage");
            $partBag.remove(); //遮罩
            $partImage.remove();
            $partObj.removeClass('loadingPage_partDiv');
        },
 
        //显示局部Loading图(遮罩层只有图片)
        PartOnlyImgShow: function (parentContainerID, url) {
            $("#" + parentContainerID.replace("#", "").replace(".", "") + "_zhezhao").remove();
            //计算图片中心点到容器
            var parentContainer = $("#" + parentContainerID);
            var imgTop = parentContainer.height() / 2 - this.operation.loadingImgHeight / 2;
            var imgLeft = parentContainer.width() / 2 - this.operation.loadingImgWidth / 2;
 
            var imgUrl = ''; //图片路径
            if (url) { //如果url值存在就启用赋值的图片路径
                imgUrl = url;
            } else { //否则就启用默认图片路径
                imgUrl = this.operation.loadingImgUrl;
            }
 
            var htmlText = '<div id="' + parentContainerID.replace("#", "").replace(".", "") +
                '_zhezhao" class="loadingPage_bg" style="margin:10px;display:block;position: absolute; width:' +
                parentContainer.width() + 'px; border: 1px solid #D6E9F1; z-index:1002;"><img style="position: absolute; top:' + imgTop +
                'px; left:' + imgLeft + 'px; border: 1px solid #D6E9F1;" src="' + imgUrl + '"/> </div>'
            $("body").append(htmlText);
 
            var zhezhao = $("#" + parentContainerID.replace("#", "").replace(".", "") + "_zhezhao");
            zhezhao.css("top", parentContainer.offset().top + "px");
            zhezhao.css("left", parentContainer.offset().left + "px");
            zhezhao.css("width", parentContainer.width() + "px");
        },
 
        //局部隐藏loading图(遮罩层只有图片)
        PartOnlyImgHide: function (parentContainerID) {
            $("#" + parentContainerID.replace("#", "").replace(".", "") + "_zhezhao").remove();
        }
 
    }
    /****************遮罩效果js --start **********************/
    var isSendAll;
    app.view_sendlist = {
        init: function () {
            /* 判断按纽是否可点 */
            var inputbool = false;
            $(".smpl_tbl input[type='checkbox']").click(function () {
                if ($(this).attr("data-toggle") == "selectall") {
                    inputbool = $(this).attr("checked") == "checked" ? false : true;
                } else {
                    //获取复选框选中的值
                    inputbool = $("input[name='checkboxes[]']:checked").length > 0 ? false : true;
                }
                $(".btnSubmit").attr("disabled", inputbool);
            });
 
            //筛选功能
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                var pri_param1 = '';
                var pri_param2 = '';
                if ($("#select-pri option:selected").val() !== '') {
                    pri_param1 = '&pri_id=' + $("#select-pri option:selected").val();
                }
                if ($("#select-typemail option:selected").val() !== 0) {
                    pri_param2 = '&typemail_id=' + $("#select-typemail option:selected").val();
                }
 
                var url = $("form[name='searchForm']").attr('action') + pri_param1 + pri_param2;
                ecjia.pjax(url);
            })
 
            /*【邮件群发模块】全部发送功能 pjax*/
            $form = $('form[name="listForm"]');
            $("form[name='listForm']").validate({
                submitHandler: function () {
                    $("form[name='listForm']").ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            //遮罩效果
                            var $div = $('#part_loading');
                            CommonPerson.Base.LoadingPic.PartHide($div);
                            if (data.state == "success") {
                                if (data.refresh_url != null) {
                                    ecjia.pjax(data.refresh_url, function () {
                                        isSendAll = false;
                                        ecjia.admin.showmessage(data);
                                    });
                                } else {
                                    ecjia.admin.showmessage(js_lang.no_match_records);
                                }
                            } else {
                                ecjia.admin.showmessage(js_lang.no_match_records);
                            }
                        }
                    });
                }
            });
            isSendAll = false;
            $('#send-all').on('click', function (e) {
                smoke.confirm(js_lang.send_confirm, function (e) {
                    if (e) {
                        $form.submit();
                        //遮罩效果
                        var $div = $('#part_loading');
                        CommonPerson.Base.LoadingPic.PartShow($div);
                    } else {
                        return false;
                    }
                }, {
                    ok: js_lang.ok,
                    cancel: js_lang.cancel
                });
            });
            
            $('.batchsend').on('click', function (e) {
                var checkboxes = [];
                $(".checkbox:checked").each(function () {
                    checkboxes.push($(this).val());
                });
                if (checkboxes == '') {
                    smoke.alert(js_lang.select_send_email);
                    return false;
                } else {
                    smoke.confirm(js_lang.batch_send_confirm, function (e) {
                        if (e) {
                            $form.attr('action', $('.batchsend').attr('data-url'));
                            $form.submit();
                            //遮罩效果
                            var $div = $('#part_loading');
                            CommonPerson.Base.LoadingPic.PartShow($div);
                        } else {
                            return false;
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                }
            });
        }
    }
    
})(ecjia.admin, jQuery);
 
// end