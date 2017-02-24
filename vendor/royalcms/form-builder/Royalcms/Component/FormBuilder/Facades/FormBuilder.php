<?php  namespace Royalcms\Component\FormBuilder\Facades;

use Royalcms\Component\Support\Facades\Facade;

class FormBuilder extends Facade {

    public static function getFacadeAccessor()
    {
        return 'form-builder';
    }
}
