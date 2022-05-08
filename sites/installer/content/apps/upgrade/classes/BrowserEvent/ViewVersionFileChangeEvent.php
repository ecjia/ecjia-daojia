<?php


namespace Ecjia\App\Upgrade\BrowserEvent;


use Ecjia\Component\BrowserEvent\BrowserEventInterface;
use RC_Script;

class ViewVersionFileChangeEvent implements BrowserEventInterface
{

    public function __construct()
    {
        RC_Script::enqueue('ecjia-middleware');
        RC_Script::enqueue('js-sprintf');
    }

    public function __invoke()
    {
        return <<<JS
(function () {
    //版本文件变动
    $('.old_version_item').click(function() {
        //展开
        let that = $(this);
        if (ecjia.front.readme_view.isClose(that)) {
            ecjia.front.readme_view.open(that);

            if (ecjia.front.readme_view.getReadmeContent(that) === undefined) {
                let params = "v=" + that.attr('data-ver');
                let url = $(".old_version").attr('data-url');
                $.ajax({
                    type: 'post',
                    url: url,
                    data: params,
                    async: false,
                    success: function(result) {
                        if (result.state === 'error') {
                            smoke.alert(result.message, {
                                ok: js_lang.ok
                            });
                        } else if (result.state === 'success') {
                            ecjia.front.readme_view.addReadmeContent(that, result.readme);
                        }
                    },
                    error:function(rs) {
                        console.log(rs.responseText);
                    }
                });
            }
            else {
                that.parent().css({'margin-bottom': 0, 'border-radius': '4px 4px 0 0'}).next().show();
            }
        }
        else {
            ecjia.front.readme_view.close(that);
            that.parent().css({'margin-bottom': '10px', 'border-radius': '4px'}).next('ul').hide();
        }
    });
})();
JS;
    }

}