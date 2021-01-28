<?php
namespace Ecjia\Component\Screen\ScreenRenders;

use Ecjia\Component\Screen\Screens\NavHereScreen;
use RC_Uri;

class NavHereScreenRender
{
    /**
     * @var NavHereScreen
     */
    protected $nav_here_screen;

    public function __construct(NavHereScreen $nav_here_screen)
    {
        $this->nav_here_screen = $nav_here_screen;
    }


    public function render()
    {
        echo '<div class="breadCrumbWrap">' . PHP_EOL;
        echo '  <ul>' . PHP_EOL;
        echo '      <li><a href="' . RC_Uri::url('@index/init') . '"><i class="icon-home"></i></a></li>' . PHP_EOL;
        foreach ($this->nav_here_screen->get_nav_heres() as $nav_here) {
            if ($this->nav_here_screen->get_last_nav_here() === $nav_here) {
                $last_css = ' class="last"';
            }
            if ($nav_here->get_link()) {
                echo '<li'. $last_css .'><a href="' . $nav_here->get_link() . '">' . $nav_here->get_label() . '</a>' . PHP_EOL;
            } else {
                echo '<li'. $last_css .'>' . $nav_here->get_label() . '</li>' . PHP_EOL;
            }
        }
        echo '  </ul>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
    }


}