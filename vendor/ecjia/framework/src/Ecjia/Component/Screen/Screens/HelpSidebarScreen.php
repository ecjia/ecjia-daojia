<?php


namespace Ecjia\Component\Screen\Screens;


class HelpSidebarScreen
{

    /**
     * The help sidebar data associated with screen, if any.
     *
     * @since 1.0.0
     * @var string
     * @access private
     */
    protected $help_sidebar = '';

    /**
     * Gets the content from a contextual help sidebar.
     *
     * @return string Contents of the help sidebar.
     * @since 1.0.0
     *
     */
    public function get_help_sidebar()
    {
        return $this->help_sidebar;
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
        $this->help_sidebar = $content;
    }


}