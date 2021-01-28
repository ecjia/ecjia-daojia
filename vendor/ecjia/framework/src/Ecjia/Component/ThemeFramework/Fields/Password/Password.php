<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/26
 * Time: 18:20
 */

namespace Ecjia\Component\ThemeFramework\Fields\Password;

use Ecjia\Component\ThemeFramework\Foundation\Options;
use Ecjia\Component\ThemeFramework\Support\Helpers;

/**
 *
 * Field: Password
 *
 * @since 1.0
 * @version 1.0
 *
 */
class Password extends Options
{
    protected $type = 'password';

    public function output(){

        echo $this->element_before();
        echo '<input type="password" name="'. $this->element_name() .'" value="'. $this->element_value() .'"'. $this->element_class() . $this->element_attributes() .'/>';
        echo $this->element_after();

    }
}