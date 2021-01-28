<?php

namespace Royalcms\Component\Storage\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @see \Royalcms\Component\Storage\Filesystem
 *
 * @method $this|\Royalcms\Component\Contracts\Filesystem\Filesystem disk($driver = null)
 * @method move($source, $destination, $overwrite = false, $mode = false)
 * @method chmod($file, $mode = false, $recursive = false)
 * @method chown($file, $owner, $recursive = false)
 * @method owner($path)
 * @method group($path)
 * @method exists($path)
 * @method is_file($path)
 * @method is_dir($path)
 * @method is_readable($path)
 * @method is_writable($path)
 * @method atime($path)
 * @method mtime($path)
 * @method size($path)
 * @method touch($path, $time = 0, $atime = 0)
 * @method mkdir($path, $chmod = false, $chown = false, $chgrp = false)
 * @method rmdir($path, $recursive = false)
 * @method dirlist($path, $include_hidden = true, $recursive = false)
 * @method filelist($path, $allowFiles, $start, $size)
 */
class Storage extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'storage';
	}

}
