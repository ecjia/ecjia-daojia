<?php


namespace Ecjia\Component\Plugin;

use ecjia_error;

trait PluginManagerError
{

    /**
     * @var \ecjia_error
     */
    protected $error;

    /**
     * @param string $code
     * @param string $message
     * @param string $data
     * @return ecjia_error|\ecjia_error
     */
    public function addError($code = '', $message = '', $data = '')
    {
        if (is_null($this->error)) {
            $this->error = new ecjia_error($code, $message, $data);
        } else {
            $this->error->add($code, $message, $data);
        }

        return $this->error;
    }

    /**
     * @return \ecjia_error
     */
    public function getError()
    {
        return $this->error;
    }


}