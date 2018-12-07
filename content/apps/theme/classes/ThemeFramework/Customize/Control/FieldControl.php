<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/20
 * Time: 16:44
 */

namespace Ecjia\App\Theme\ThemeFramework\Customize\Control;

use Ecjia\App\Theme\Customize\Control;

/**
 *
 * Ecjia Theme Customize custom controls
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class FieldControl extends Control
{

    public $unique  = '';
    public $type    = 'cs_field';
    public $options = array();

    public function render_content()
    {

        $this->options['id'] = $this->id;
        $this->options['default'] = $this->setting->default;
        $this->options['attributes']['data-customize-setting-link'] = $this->settings['default']->id;
        echo cs_add_element( $this->options, $this->value(), $this->unique );

    }

}