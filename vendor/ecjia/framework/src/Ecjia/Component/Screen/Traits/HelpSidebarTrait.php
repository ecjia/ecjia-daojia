<?php


namespace Ecjia\Component\Screen\Traits;

use Ecjia\Component\Screen\Screens\HelpSidebarScreen;

/**
 * Trait HelpSidebarTrait
 * @package Ecjia\Component\Screen\Traits
 *
 * @property HelpSidebarScreen $help_sidebar_screen
 */
trait HelpSidebarTrait
{

    /**
     * Gets the content from a contextual help sidebar.
     *
     * @return string Contents of the help sidebar.
     * @since 1.0.0
     *
     */
    public function get_help_sidebar()
    {
        return $this->help_sidebar_screen->get_help_sidebar();
    }

    /**
     * Add a sidebar to the contextual help for the screen.
     * Call this in template files after admin.php is loaded and before admin-header.php is loaded to add a sidebar to the contextual help.
     *
     * @param string $content Sidebar content in plain text or HTML.
     * @since 1.0.0
     *
     */
    public function set_help_sidebar($content)
    {
        return $this->help_sidebar_screen->set_help_sidebar($content);
    }

}