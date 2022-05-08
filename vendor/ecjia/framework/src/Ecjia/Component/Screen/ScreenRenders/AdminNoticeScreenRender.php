<?php
namespace Ecjia\Component\Screen\ScreenRenders;

use Ecjia\Component\Screen\Screens\AdminNoticeScreen;

class AdminNoticeScreenRender
{
    /**
     * @var AdminNoticeScreen
     */
    protected $admin_notice_screen;

    public function __construct(AdminNoticeScreen $admin_notice_screen)
    {
        $this->admin_notice_screen = $admin_notice_screen;
    }


    public function render()
    {
        $admin_notices = $this->admin_notice_screen->get_admin_notice();
        if (!empty($admin_notices)) {
            foreach ($admin_notices as $admin_notice) {
                if ($admin_notice->get_type()) {
                    $get_type =  ' ' . $admin_notice->get_type();
                } else {
                    $get_type = '';
                }

                echo '<div class="alert' . $get_type . '">' . PHP_EOL;

                if ($admin_notice->get_allow_close()) {
                    echo '<a data-dismiss="alert" class="close">×</a>' . PHP_EOL;
                }

                echo $admin_notice->get_content() . PHP_EOL;

                echo '</div>' . PHP_EOL;
            }
        }
    }


}