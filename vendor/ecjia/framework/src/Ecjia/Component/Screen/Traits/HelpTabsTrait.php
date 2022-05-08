<?php


namespace Ecjia\Component\Screen\Traits;

use Ecjia\Component\Screen\Screens\HelpTabsScreen;

/**
 * Trait HelpTabsTrait
 * @package Ecjia\Component\Screen\Traits
 *
 * @property HelpTabsScreen $help_tabs_screen
 */
trait HelpTabsTrait
{

    /**
     * Removes all help tabs from the contextual help for the screen.
     *
     * @since 1.0.0
     */
    public function remove_help_tabs()
    {
        return $this->help_tabs_screen->remove_help_tabs();
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
        return $this->help_tabs_screen->remove_help_tab($id);
    }


    /**
     * Gets the help tabs registered for the screen.
     *
     * @return array Help tabs with arguments.
     * @since 1.0.0
     *
     */
    public function get_help_tabs()
    {
        return $this->help_tabs_screen->get_help_tabs();
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
        return $this->help_tabs_screen->get_help_tab($io);
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
        return $this->help_tabs_screen->add_help_tab($args);
    }

}