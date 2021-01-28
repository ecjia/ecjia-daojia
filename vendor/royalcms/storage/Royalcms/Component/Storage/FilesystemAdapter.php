<?php

namespace Royalcms\Component\Storage;

use Royalcms\Component\Support\Traits\Macroable;
use Royalcms\Component\Filesystem\FilesystemAdapter as BaseFilesystemAdapter;

class FilesystemAdapter extends BaseFilesystemAdapter
{

    use Macroable {
        __call as private __macroableCall;
    }

    /**
     * Determine if a file exists.
     *
     * @param  string  $path
     * @return bool
     */
    public function exists($path)
    {
        return $this->driver->exists($path);
    }


    /**
     * Pass dynamic methods call onto Flysystem.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
	public function __call($method, array $parameters)
    {
        if (!static::hasMacro($method)) {

            if (method_exists($this->driver, $method))
            {
                return call_user_func_array([$this->driver, $method], $parameters);
            }
            else {
                return parent::__call($method, $parameters);
            }

        }

	    return $this->__macroableCall($method, $parameters);
	}

}
