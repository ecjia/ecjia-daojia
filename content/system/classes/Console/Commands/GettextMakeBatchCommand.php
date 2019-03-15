<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 15:34
 */

namespace Ecjia\System\Console\Commands;

use Royalcms\Component\Console\Command;

// run the CLI only if the file
// wasn't included
class GettextMakeBatchCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ecjia:gettext-makeall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generate All POT file from the files in all directories";


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {

        $commands = [
            'ecjia:gettext-makepot ecjia-system content/system/',

            'ecjia:gettext-makepot ecjia-app content/apps/adsense/',
            'ecjia:gettext-makepot ecjia-app content/apps/affiliate/',
            'ecjia:gettext-makepot ecjia-app content/apps/agent/',
            'ecjia:gettext-makepot ecjia-app content/apps/api/',
            'ecjia:gettext-makepot ecjia-app content/apps/article/',
            'ecjia:gettext-makepot ecjia-app content/apps/attach/',
            'ecjia:gettext-makepot ecjia-app content/apps/bonus/',
            'ecjia:gettext-makepot ecjia-app content/apps/captcha/',
            'ecjia:gettext-makepot ecjia-app content/apps/cart/',
            'ecjia:gettext-makepot ecjia-app content/apps/cashier/',
            'ecjia:gettext-makepot ecjia-app content/apps/comment/',
            'ecjia:gettext-makepot ecjia-app content/apps/commission/',
            'ecjia:gettext-makepot ecjia-app content/apps/connect/',
            'ecjia:gettext-makepot ecjia-app content/apps/cron/',
            'ecjia:gettext-makepot ecjia-app content/apps/customer/',
            'ecjia:gettext-makepot ecjia-app content/apps/express/',
            'ecjia:gettext-makepot ecjia-app content/apps/favourable/',
            'ecjia:gettext-makepot ecjia-app content/apps/finance/',
            'ecjia:gettext-makepot ecjia-app content/apps/franchisee/',
            'ecjia:gettext-makepot ecjia-app content/apps/friendlink/',
            'ecjia:gettext-makepot ecjia-app content/apps/goods/',
            'ecjia:gettext-makepot ecjia-app content/apps/goodslib/',
            'ecjia:gettext-makepot ecjia-app content/apps/groupbuy/',
            'ecjia:gettext-makepot ecjia-app content/apps/installer/',
            'ecjia:gettext-makepot ecjia-app content/apps/integrate/',
            'ecjia:gettext-makepot ecjia-app content/apps/intro/',
            'ecjia:gettext-makepot ecjia-app content/apps/logviewer/',
            'ecjia:gettext-makepot ecjia-app content/apps/mail/',
            'ecjia:gettext-makepot ecjia-app content/apps/main/',
            'ecjia:gettext-makepot ecjia-app content/apps/maintain/',
            'ecjia:gettext-makepot ecjia-app content/apps/market/',
            'ecjia:gettext-makepot ecjia-app content/apps/memadmin/',
            'ecjia:gettext-makepot ecjia-app content/apps/merchant/',
            'ecjia:gettext-makepot ecjia-app content/apps/mobile/',
            'ecjia:gettext-makepot ecjia-app content/apps/notification/',
            'ecjia:gettext-makepot ecjia-app content/apps/orders/',
            'ecjia:gettext-makepot ecjia-app content/apps/payment/',
            'ecjia:gettext-makepot ecjia-app content/apps/platform/',
            'ecjia:gettext-makepot ecjia-app content/apps/printer/',
            'ecjia:gettext-makepot ecjia-app content/apps/promotion/',
            'ecjia:gettext-makepot ecjia-app content/apps/push/',
            'ecjia:gettext-makepot ecjia-app content/apps/quickpay/',
            'ecjia:gettext-makepot ecjia-app content/apps/refund/',
            'ecjia:gettext-makepot ecjia-app content/apps/setting/',
            'ecjia:gettext-makepot ecjia-app content/apps/shipping/',
            'ecjia:gettext-makepot ecjia-app content/apps/shopguide/',
            'ecjia:gettext-makepot ecjia-app content/apps/sms/',
            'ecjia:gettext-makepot ecjia-app content/apps/staff/',
            'ecjia:gettext-makepot ecjia-app content/apps/stats/',
            'ecjia:gettext-makepot ecjia-app content/apps/store/',
            'ecjia:gettext-makepot ecjia-app content/apps/theme/',
            'ecjia:gettext-makepot ecjia-app content/apps/topic/',
            'ecjia:gettext-makepot ecjia-app content/apps/touch/',
            'ecjia:gettext-makepot ecjia-app content/apps/toutiao/',
            'ecjia:gettext-makepot ecjia-app content/apps/track/',
            'ecjia:gettext-makepot ecjia-app content/apps/ucclient/',
            'ecjia:gettext-makepot ecjia-app content/apps/ucserver/',
            'ecjia:gettext-makepot ecjia-app content/apps/upgrade/',
            'ecjia:gettext-makepot ecjia-app content/apps/user/',
            'ecjia:gettext-makepot ecjia-app content/apps/weapp/',
            'ecjia:gettext-makepot ecjia-app content/apps/wechat/',
            'ecjia:gettext-makepot ecjia-app content/apps/withdraw/',

            'ecjia:gettext-makepot ecjia-theme content/themes/dscmall/',
            'ecjia:gettext-makepot ecjia-theme content/themes/ecjia-intro/',
            'ecjia:gettext-makepot ecjia-theme content/themes/ecjia-pc/',
            'ecjia:gettext-makepot ecjia-theme sites/m/content/themes/h5/',
            'ecjia:gettext-makepot ecjia-theme sites/m/content/themes/mendian/',
            'ecjia:gettext-makepot ecjia-theme sites/member/content/themes/default/',
            'ecjia:gettext-makepot ecjia-theme sites/help/content/themes/default/',
            'ecjia:gettext-makepot ecjia-theme sites/cityadmin/content/themes/default/',
            'ecjia:gettext-makepot ecjia-theme sites/app/content/themes/ecjia-app/',
            'ecjia:gettext-makepot ecjia-theme sites/app/content/themes/ecjia-daojiaapp/',
        ];

        collect($commands)->each(function($item) {
            list($cmd, $project, $directory) = explode(' ', $item);
            $this->call($cmd, ['project' => $project, 'directory' => base_path($directory)]);
        });

    }


}