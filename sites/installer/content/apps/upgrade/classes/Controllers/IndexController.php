<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
namespace Ecjia\App\Upgrade\Controllers;

use Ecjia\App\Upgrade\BrowserEvent\InstallStartEvent;
use Ecjia\App\Upgrade\BrowserEvent\ViewVersionFileChangeEvent;
use Ecjia\App\Upgrade\UpgradeUtility;
use Ecjia\Component\BrowserEvent\PageEventManager;
use Ecjia\Component\Version\VersionUtility;
use RC_Uri;
use RC_App;
use Ecjia_VersionManager;
use ecjia;

class IndexController extends BaseControllerAbstract
{

    public function __construct()
    {
        parent::__construct();

        //安装脚本不限制超时时间
        set_time_limit(60);

    }

    public function init()
    {
        if (UpgradeUtility::checkUpgradeLock()) {
            return $this->redirect(RC_Uri::url('upgrade/index/upgraded'));
        }

        $page = (new PageEventManager('init'))->addPageHandler(ViewVersionFileChangeEvent::class)
            ->addPageHandler(InstallStartEvent::class);
        $this->loadPageScript($page);

        // 获取当前版本
        $version_current = VersionUtility::getCurrentVersion();
        // 获取最新版本
        $version_last = VersionUtility::getLatestVersion();

        // 清除缓存
        UpgradeUtility::clearCache();

        // 获取两个版本之前的可用升级版本
        $version_list = VersionUtility::getUpgradeVersionList($version_current, $version_last);
        $version_list = $version_list->keys()->toArray();

        if (in_array('v' . $version_last, $version_list)) {
            $v      = Ecjia_VersionManager::version('v' . $version_last);
            $readme = $v->getReadme();
        } else {
            $readme = __('没有找到可用的升级程序。', 'upgrade');
            $this->assign('disable', 1);
        }

        $this->assign('readme', $readme);
        $this->assign('version_list', $version_list);
        $this->assign('version_count', count($version_list));
        $this->assign('version_current', $version_current);
        $this->assign('version_last', $version_last);
        $this->assign('action_url', RC_Uri::url("upgrade/index/finish"));
        $this->assign('init_url', RC_Uri::url("upgrade/index/init"));
        $this->assign('ajax_change_files', RC_Uri::url('upgrade/index/ajax_change_files'));
        $this->assign('ajax_upgrade_url', RC_Uri::url('upgrade/index/ajax_upgrade'));
        $this->assign('correct_img', RC_App::apps_url('statics/front/images/correct.png', $this->__FILE__));
        $this->assign('error_img', RC_App::apps_url('statics/front/images/error.png', $this->__FILE__));

        $this->assign('step', 1);

        return $this->displayAppTemplate('upgrade', 'front/intro.dwt');
    }

    public function ajax_change_files()
    {
        try {
            $version = trim($_POST['v']);
            if (empty($version) || $version == 'undefined') {
                return $this->showmessage('error', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('data' => ''));
            }
            // 拿到当前升级版本对象
            $v = Ecjia_VersionManager::version($version);

            // 获取变动文件
            $readme = $v->getReadme();
            $readme = empty($readme) ? __('无', 'upgrade') : $readme;

            return $this->showmessage('ok', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('readme' => $readme));
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::DATATYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\Error $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::DATATYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    public function ajax_upgrade()
    {
        try {
            $version = $_POST['v'];
            if (empty($version)) {
                return $this->showmessage(__('版本号错误', 'upgrade'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            // 升级执行
            $rs = Ecjia_VersionManager::version($version)->upgrade();
            if (is_ecjia_error($rs)) {
                return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                return $this->showmessage(__('升级成功', 'upgrade'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            }
        } catch (\Exception $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\Error $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::DATATYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }


    public function finish()
    {
//        if (UpgradeUtility::checkUpgradeLock()) {
//            return $this->redirect(RC_Uri::url('upgrade/index/upgraded'));
//        }

        // 获取当前版本
        $version_current = VersionUtility::getCurrentVersion();
        // 获取最新版本
        $version_last = VersionUtility::getLatestVersion();

        if ($version_current != $version_last) {
            return $this->redirect(RC_Uri::url('upgrade/index/init'));
        }

        //写入升级锁定
        UpgradeUtility::saveUpgradeLock();

        $finish_message = __('恭喜您，升级成功！', 'upgrade');
        $this->assign('finish_message', $finish_message . __('当前版本已是最新版本。', 'upgrade'));

        $this->assign('go_urls', UpgradeUtility::goUrls());

        $this->assign('step', 3);

        return $this->displayAppTemplate('upgrade', 'front/finish.dwt');
    }

    /**
     * 已经升级过的提示页
     */
    public function upgraded()
    {
//        if (!UpgradeUtility::checkUpgradeLock()) {
//            return $this->redirect(RC_Uri::url('upgrade/index/init'));
//        }

        $this->assign('finish_message', sprintf(__('请先删除升级锁定文件 %s，方可继续升级。', 'upgrade'), '/content/storages/data/upgrade.lock'));

        $this->assign('go_urls', UpgradeUtility::goUrls());

        $this->assign('step', 3);

        return $this->displayAppTemplate('upgrade', 'front/finish.dwt');
    }

}