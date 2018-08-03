function share_spread() {
    var info = {
        'url': location.href.split('#')[0]
    };

    var spread_url = $('input[name="spread_url"]').val();
    if (spread_url != undefined) {
        return false;
    }
    var wxconfig_url = $('input[name="wxconfig_url"]').val();
    if (wxconfig_url == undefined) {
        return false;
    }

    var title = $('input[name="share_title"]').val() == undefined ? document.title : $('input[name="share_title"]').val();
    var image = $('input[name="share_image"]').val() == undefined ? $.cookie('wap_logo') : $('input[name="share_image"]').val();
    var desc = $('input[name="share_desc"]').val() == undefined || $('input[name="share_desc"]').val() == '' ? document.title : $('input[name="share_desc"]').val();
    var link = location.href.split('#')[0];

    $.post(wxconfig_url, info, function (response) {
        if (response == '' || response.data == undefined) {
            return false;
        }
        var data = response.data;
        if (data != undefined && data.appId != '') {
            wx.config({
                debug: false,
                appId: data.appId,
                timestamp: data.timestamp,
                nonceStr: data.nonceStr,
                signature: data.signature,
                jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ']
            });
            wx.checkJsApi({
                jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ'],
                success: function (res) {
                    console.log(res);
                }
            });
            wx.ready(function () {
                //分享到朋友圈
                wx.onMenuShareTimeline({
                    title: title, // 分享标题【必填】
                    link: link, // 分享链接【必填】
                    imgUrl: image // 分享图标【必填】
                });

                //分享给朋友
                wx.onMenuShareAppMessage({
                    title: title, // 分享标题【必填】
                    desc: desc, // 分享描述【必填】
                    link: link, // 分享链接【必填】
                    imgUrl: image, // 分享图标【必填】
                    type: 'link', // 分享类型,music、video或link，不填默认为link【必填】
                    dataUrl: ''
                });

                //分享到QQ
                wx.onMenuShareQQ({
                    title: title, // 分享标题
                    desc: desc, // 分享描述
                    link: link, // 分享链接
                    imgUrl: image // 分享图标
                });
            });
            wx.error(function (res) {
                console.log(res);
            });
        }
    });
}

//页面载入方法和pjax刷新执行方法
$(function () {
    share_spread();
}).on('pjax:end', function () {
    share_spread();
});