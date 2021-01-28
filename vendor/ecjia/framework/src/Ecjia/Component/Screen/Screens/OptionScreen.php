<?php


namespace Ecjia\Component\Screen\Screens;


class OptionScreen
{

    /**
     * The screen options associated with screen, if any.
     *
     * @since 1.0.0
     * @var array
     * @access private
     */
    protected $options = array();

    /**
     * Adds an option for the screen.
     * Call this in template files after admin.php is loaded and before admin-header.php is loaded to add screen options.
     *
     * @param string $option Option ID
     * @param mixed $args Option-dependent arguments.
     * @since 1.0.0
     *
     */
    public function add_option($option, $args = array())
    {
        $this->options[$option] = $args;
        return $this;
    }

    /**
     * Remove an option from the screen.
     *
     * @param string $option Option ID.
     * @since 1.0.0
     *
     */
    public function remove_option($option)
    {
        unset($this->options[$option]);
        return $this;
    }

    /**
     * Remove all options from the screen.
     *
     * @since 1.0.0
     */
    public function remove_options()
    {
        $this->options = array();
        return $this;
    }

    /**
     * Get the options registered for the screen.
     *
     * @return array Options with arguments.
     * @since 1.0.0
     *
     */
    public function get_options()
    {
        return $this->options;
    }

    /**
     * Gets the arguments for an option for the screen.
     *
     * @param string $option Option ID.
     * @param mixed $key Optional. Specific array key for when the option is an array.
     * @since 1.0.0
     *
     */
    public function get_option($option, $key = false)
    {
        if (!isset($this->options[$option])) {
            return null;
        }

        if ($key) {
            if (isset($this->options[$option][$key])) {
                return $this->options[$option][$key];
            }
            return null;
        }

        return $this->options[$option];
    }

}