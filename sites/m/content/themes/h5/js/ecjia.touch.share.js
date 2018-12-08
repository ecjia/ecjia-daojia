function share_spread() {
    var length = $.find('input[name="share_page"]').length;
    if (length == 0) {
        return false;
    }

    if (typeof(config) == 'undefined') {
        return false;
    }

    var title = $('input[name="share_title"]').val() == undefined || $('input[name="share_title"]').val() == '' ? document.title : $('input[name="share_title"]').val();
    var image = $('input[name="share_image"]').val() == undefined || $('input[name="share_image"]').val() == '' ? $.cookie('wap_logo') : $('input[name="share_image"]').val();
    var desc = $('input[name="share_desc"]').val() == undefined || $('input[name="share_desc"]').val() == '' ? document.title : $('input[name="share_desc"]').val();
    var link = $('input[name="share_link"]').val() == undefined || $('input[name="share_link"]').val() == '' ? location.href.split('#')[0] : $('input[name="share_link"]').val();

    var data = JSON.parse(config);
    wx.config({
        debug: false,
        appId: data.appId,
        timestamp: data.timestamp,
        nonceStr: data.nonceStr,
        signature: data.signature,
        jsApiList: [
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
        ]
    });
    wx.ready(function() {
        //分享到朋友圈
        wx.onMenuShareTimeline({
            title: title, // 分享标题【必填】
            link: link, // 分享链接【必填】
            imgUrl: image, // 分享图标【必填】
        });

        //分享给朋友
        wx.onMenuShareAppMessage({
            title: title, // 分享标题【必填】
            desc: desc, // 分享描述【必填】
            link: link, // 分享链接【必填】
            imgUrl: image, // 分享图标【必填】
            type: 'link', // 分享类型,music、video或link，不填默认为link【必填】
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        });

        //分享到QQ
        wx.onMenuShareQQ({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接
            imgUrl: image, // 分享图标
        });
    });
}

//页面载入方法和pjax刷新执行方法
$(function() {
    share_spread();
}).on('pjax:end', function() {
    var length = $.find('input[name="share_page"]').length;
    if (length != 0) {
        share_spread();
    }
});
