<?php


namespace Ecjia\Component\Screen\Screens;

use RC_Format;

class HelpTabsScreen
{

    /**
     * The help tab data associated with the screen, if any.
     *
     * @since 1.0.0
     * @var array
     * @access private
     */
    protected $help_tabs = array();

    /**
     * Gets the help tabs registered for the screen.
     *
     * @return array Help tabs with arguments.
     * @since 1.0.0
     *
     */
    public function get_help_tabs()
    {
        return $this->help_tabs;
    }

    /**
     * Gets the arguments for a help tab.
     *
     * @param string $id Help Tab ID.
     * @return array Help tab arguments.
     * @since 1.0.0
     *
     */
    public function get_help_tab($id)
    {
        if (!isset($this->help_tabs[$id])) {
            return null;
        }
        return $this->help_tabs[$id];
    }

    /**
     * Add a help tab to the contextual help for the screen.
     * Call this on the load-$pagenow hook for the relevant screen.
     *
     * @param array $args
     * - string   - title    - Title for the tab.
     * - string   - id       - Tab ID. Must be HTML-safe.
     * - string   - content  - Help tab content in plain text or HTML. Optional.
     * - callback - callback - A callback to generate the tab content. Optional.
     *
     * @since 1.0.0
     *
     */
    public function add_help_tab($args)
    {
        $defaults = array(
            'title'    => false,
            'id'       => false,
            'content'  => '',
            'callback' => false,
        );
        $args     = rc_parse_args($args, $defaults);

        $args['id'] = RC_Format::sanitize_html_class($args['id']);

        // Ensure we have an ID and title.
        if (!$args['id'] || !$args['title']) {
            return;
        }

        // Allows for overriding an existing tab with that ID.
        $this->help_tabs[$args['id']] = $args;
        return $this;
    }

    /**
     * Removes a help tab from the contextual help for the screen.
     *
     * @param string $id The help tab ID.
     * @since 1.0.0
     *
     */
    public function remove_help_tab($id)
    {
        unset($this->help_tabs[$id]);
        return $this;
    }

    /**
     * Removes all help tabs from the contextual help for the screen.
     *
     * @since 1.0.0
     */
    public function remove_help_tabs()
    {
        $this->help_tabs = array();
        return $this;
    }


}