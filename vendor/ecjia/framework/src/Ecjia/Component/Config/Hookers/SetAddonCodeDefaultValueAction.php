<?php


namespace Ecjia\System\Hookers;


use RC_Config;
use Royalcms\Component\Database\QueryException;

class SetAddonCodeDefaultValueAction
{

    /**
     * 自定义项目访问URL
     * @param string $url
     * @param string $path
     * @return string
     */
    public function handle($code)
    {
        try {
            $value = serialize(array());
            $this->getRepository()->add('addon', $code, $value, ['type' => 'hidden']);
        } catch (QueryException $exception) {
            ecjia_log_error($exception);
        }
    }

}