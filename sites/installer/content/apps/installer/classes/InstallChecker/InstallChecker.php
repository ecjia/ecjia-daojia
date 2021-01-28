<?php


namespace Ecjia\App\Installer\InstallChecker;


use ecjia_error;

class InstallChecker
{

    protected $ok     = '<i class="fontello-icon-ok"></i>';
    protected $cancel = '<i class="fontello-icon-cancel"></i>';
    protected $info   = '<i class="fontello-icon-info-circled"></i>';

    protected $ecjia_error;

    /**
     * xxxx => [
     *      value =>
     *      checked_label =>
     *      checked_status =>
     * ]
     *
     * @var array
     */
    protected $checked;

    protected $handles = [];


    public function __construct()
    {
        $this->ecjia_error = new ecjia_error();
    }

    public function getChecked()
    {
        return $this->checked;
    }

    public function getCheckResult()
    {
        $failed = collect($this->checked)->filter(function ($item) {
            if (isset($item[0])) {
                $item = collect($item)->filter(function ($sub) {
                    return ! $sub['checked_status'];
                })->all();

                if (empty($item)) {
                    return false;
                }

                return $item;
            }
            else {
                return ! $item['checked_status'];
            }
        })->all();

        return $failed;
    }


    public function checkItem($name, $callback)
    {
        $this->handles[$name] = $callback;
    }

    public function checking()
    {
        $checked = collect($this->handles)->map(function ($handle) {

            if (is_callable($handle)) {
                return $handle($this);
            }
            elseif (is_string($handle) && class_exists($handle)) {
                return (new $handle)->handle($this);
            }
            elseif (is_array($handle)) {
                return $handle;
            }

        })->all();

        $this->checked = $checked;
    }

    /**
     * @return string
     */
    public function getOk(): string
    {
        return $this->ok;
    }

    /**
     * @return string
     */
    public function getCancel(): string
    {
        return $this->cancel;
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return $this->info;
    }

    /**
     * @return ecjia_error
     */
    public function getEcjiaError(): ecjia_error
    {
        return $this->ecjia_error;
    }



}