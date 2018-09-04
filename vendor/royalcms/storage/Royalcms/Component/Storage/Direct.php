<?php

namespace Royalcms\Component\Storage;

use Royalcms\Component\Support\Format;
use Royalcms\Component\Error\Error;

/**
 * Royalcms Direct Filesystem.
 *
 * @package Royalcms
 * @subpackage Filesystem
 */

/**
 * Royalcms Filesystem Class for direct PHP file and folder manipulation.
 *
 * @since 2.5.0
 * @package Royalcms
 * @subpackage Filesystem
 * @uses \Royalcms\Component\Storage\FilesystemBase Extends class
 */
class Direct extends FilesystemBase
{

    /**
     * constructor
     *
     * @param mixed $arg
     *            ignored argument
     */
    public function __construct($arg)
    {
        $this->method = 'direct';
        $this->errors = new Error();
    }
    
    /**
     * Connect filesystem.
     *
     * @since 2.5.0
     *
     * @return bool True on success or false on failure (always true for WP_Filesystem_Direct).
     */
    public function connect()
    {
        return true;
    }

    
    public function move_uploaded_file($filename, $destination) {
        return @move_uploaded_file($filename, $destination);
    }
    

    /**
     * Reads entire file into a string
     *
     * @param string $file
     *            Name of the file to read.
     * @return string bool function returns the read data or false on failure.
     */
    public function get_contents($file)
    {
        return @file_get_contents($file);
    }

    /**
     * Reads entire file into an array
     *
     * @param string $file
     *            Path to the file.
     * @return array bool file contents in an array or false on failure.
     */
    public function get_contents_array($file)
    {
        return @file($file);
    }

    /**
     * Write a string to a file
     *
     * @param string $file
     *            Remote path to the file where to write the data.
     * @param string $contents
     *            The data to write.
     * @param int $mode
     *            (optional) The file permissions as octal number, usually 0644.
     * @return bool False upon failure.
     */
    public function put_contents($file, $contents, $mode = false)
    {
        $fp = @fopen($file, 'wb');
        if (! $fp)
            return false;
        
        mbstring_binary_safe_encoding();
        
        $data_length = strlen($contents);
        
        $bytes_written = fwrite($fp, $contents);
        
        reset_mbstring_encoding();
        
        fclose($fp);
        
        if ($data_length !== $bytes_written)
            return false;
        
        $this->chmod($file, $mode);
        
        return true;
    }

    /**
     * Gets the current working directory
     *
     * @return string bool current working directory on success, or false on failure.
     */
    public function cwd()
    {
        return @getcwd();
    }

    /**
     * Change directory
     *
     * @param string $dir
     *            The new current directory.
     * @return bool Returns true on success or false on failure.
     */
    public function chdir($dir)
    {
        return @chdir($dir);
    }

    /**
     * Changes file group
     *
     * @param string $file
     *            Path to the file.
     * @param mixed $group
     *            A group name or number.
     * @param bool $recursive
     *            (optional) If set True changes file group recursively. Defaults to False.
     * @return bool Returns true on success or false on failure.
     */
    public function chgrp($file, $group, $recursive = false)
    {
        if (! $this->exists($file))
            return false;
        if (! $recursive)
            return @chgrp($file, $group);
        if (! $this->is_dir($file))
            return @chgrp($file, $group);
            // Is a directory, and we want recursive
        $file = Format::trailingslashit($file);
        $filelist = $this->dirlist($file);
        foreach ($filelist as $filename)
            $this->chgrp($file . $filename, $group, $recursive);
        
        return true;
    }

    /**
     * Changes filesystem permissions
     *
     * @param string $file
     *            Path to the file.
     * @param int $mode
     *            (optional) The permissions as octal number, usually 0644 for files, 0755 for dirs.
     * @param bool $recursive
     *            (optional) If set True changes file group recursively. Defaults to False.
     * @return bool Returns true on success or false on failure.
     */
    public function chmod($file, $mode = false, $recursive = false)
    {
        if (! $mode) {
            if ($this->is_file($file))
                $mode = FS_CHMOD_FILE;
            elseif ($this->is_dir($file))
                $mode = FS_CHMOD_DIR;
            else
                return false;
        }
        
        if (! $recursive || ! $this->is_dir($file))
            return @chmod($file, $mode);
            // Is a directory, and we want recursive
        $file = Format::trailingslashit($file);
        $filelist = $this->dirlist($file);
        foreach ((array) $filelist as $filename => $filemeta)
            $this->chmod($file . $filename, $mode, $recursive);
        
        return true;
    }

    /**
     * Changes file owner
     *
     * @param string $file
     *            Path to the file.
     * @param mixed $owner
     *            A user name or number.
     * @param bool $recursive
     *            (optional) If set True changes file owner recursively. Defaults to False.
     * @return bool Returns true on success or false on failure.
     */
    public function chown($file, $owner, $recursive = false)
    {
        if (! $this->exists($file))
            return false;
        if (! $recursive)
            return @chown($file, $owner);
        if (! $this->is_dir($file))
            return @chown($file, $owner);
            // Is a directory, and we want recursive
        $filelist = $this->dirlist($file);
        foreach ($filelist as $filename) {
            $this->chown($file . '/' . $filename, $owner, $recursive);
        }
        return true;
    }

    /**
     * Gets file owner
     *
     * @param string $file
     *            Path to the file.
     * @return string bool of the user or false on error.
     */
    public function owner($file)
    {
        $owneruid = @fileowner($file);
        if (! $owneruid)
            return false;
        if (! function_exists('posix_getpwuid'))
            return $owneruid;
        $ownerarray = posix_getpwuid($owneruid);
        return $ownerarray['name'];
    }

    /**
     * Gets file permissions
     *
     * FIXME does not handle errors in fileperms()
     *
     * @param string $file
     *            Path to the file.
     * @return string Mode of the file (last 3 digits).
     */
    protected function getchmod($file)
    {
        return substr(decoct(@fileperms($file)), - 3);
    }

    public function group($file)
    {
        $gid = @filegroup($file);
        if (! $gid)
            return false;
        if (! function_exists('posix_getgrgid'))
            return $gid;
        $grouparray = posix_getgrgid($gid);
        return $grouparray['name'];
    }

    public function copy($source, $destination, $overwrite = false, $mode = false)
    {
        if (! $overwrite && $this->exists($destination))
            return false;
        
        $rtval = copy($source, $destination);
        if ($mode)
            $this->chmod($destination, $mode);
        return $rtval;
    }

    public function move($source, $destination, $overwrite = false, $mode = false)
    {
        if (! $overwrite && $this->exists($destination))
            return false;
            
            // try using rename first. if that fails (for example, source is read only) try copy
        if (@rename($source, $destination)) {
            if ($mode) $this->chmod($destination, $mode);
            return true;
        }
        
        if ($this->copy($source, $destination, $overwrite, $mode) && $this->exists($destination)) {
            $this->delete($source);
            return true;
        } else {
            return false;
        }
    }

    public function delete($file, $recursive = false, $type = false)
    {
        if (empty($file)) // Some filesystems report this as /, which can cause non-expected recursive deletion of all files in the filesystem.
            return false;
        $file = str_replace('\\', '/', $file); // for win32, occasional problems deleting files otherwise
        
        if ('f' == $type || $this->is_file($file))
            return @unlink($file);
        if (! $recursive && $this->is_dir($file))
            return @rmdir($file);
            
            // At this point it's a folder, and we're in recursive mode
        $file = Format::trailingslashit($file);
        $filelist = $this->dirlist($file, true);
        
        $retval = true;
        if (is_array($filelist)) {
            foreach ($filelist as $filename => $fileinfo) {
                if (! $this->delete($file . $filename, $recursive, $fileinfo['type']))
                    $retval = false;
            }
        }
        
        if (file_exists($file) && ! @rmdir($file))
            $retval = false;
        
        return $retval;
    }

    public function exists($file)
    {
        return @file_exists($file);
    }

    public function is_file($file)
    {
        return @is_file($file);
    }

    public function is_dir($path)
    {
        return @is_dir($path);
    }

    public function is_readable($file)
    {
        return @is_readable($file);
    }

    public function is_writable($file)
    {
        return @is_writable($file);
    }

    public function atime($file)
    {
        return @fileatime($file);
    }

    public function mtime($file)
    {
        return @filemtime($file);
    }

    public function size($file)
    {
        return @filesize($file);
    }

    public function touch($file, $time = 0, $atime = 0)
    {
        if ($time == 0)
            $time = time();
        if ($atime == 0)
            $atime = time();
        return @touch($file, $time, $atime);
    }

    public function mkdir($path, $chmod = false, $chown = false, $chgrp = false)
    {
        // safe mode fails with a trailing slash under certain PHP versions.
        $path = Format::untrailingslashit($path);
        if (empty($path))
            return false;
        
        if (! $chmod)
            $chmod = FS_CHMOD_DIR;
        
        if (! @mkdir($path, $chmod, true))
            return false;
        $this->chmod($path, $chmod);
        if ($chown)
            $this->chown($path, $chown);
        if ($chgrp)
            $this->chgrp($path, $chgrp);
        return true;
    }

    public function rmdir($path, $recursive = false)
    {
        return $this->delete($path, $recursive);
    }

    public function dirlist($path, $include_hidden = true, $recursive = false)
    {
        if ($this->is_file($path)) {
            $limit_file = basename($path);
            $path = dirname($path);
        } else {
            $limit_file = false;
        }
        
        if (! $this->is_dir($path))
            return false;
        
        $dir = @dir($path);
        if (! $dir)
            return false;
        
        $ret = array();
        
        while (false !== ($entry = $dir->read())) {
            $struc = array();
            $struc['name'] = $entry;
            
            if ('.' == $struc['name'] || '..' == $struc['name'])
                continue;
            
            if (! $include_hidden && '.' == $struc['name'][0])
                continue;
            
            if ($limit_file && $struc['name'] != $limit_file)
                continue;
            
            $struc['perms'] = $this->gethchmod($path . '/' . $entry);
            $struc['permsn'] = $this->getnumchmodfromh($struc['perms']);
            $struc['number'] = false;
            $struc['owner'] = $this->owner($path . '/' . $entry);
            $struc['group'] = $this->group($path . '/' . $entry);
            $struc['size'] = $this->size($path . '/' . $entry);
            $struc['lastmodunix'] = $this->mtime($path . '/' . $entry);
            $struc['lastmod'] = date('M j', $struc['lastmodunix']);
            $struc['time'] = date('h:i:s', $struc['lastmodunix']);
            $struc['type'] = $this->is_dir($path . '/' . $entry) ? 'd' : 'f';
            
            if ('d' == $struc['type']) {
                if ($recursive)
                    $struc['files'] = $this->dirlist($path . '/' . $struc['name'], $include_hidden, $recursive);
                else
                    $struc['files'] = array();
            }
            
            $ret[$struc['name']] = $struc;
        }
        $dir->close();
        unset($dir);
        return $ret;
    }
    
    /**
     * 获取目录下的指定类型的文件列表
     * @param $path
     * @param array $files
     * @return array
     */
    public function filelist($path, $allowFiles, $start, $size)
    {
        $end = $start + $size;
        
        $files = $this->_getfiles($path, $allowFiles);
        if (!count($files)) {
            return array();
        }
        
        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--) {
            $list[] = $files[$i];
        }
        return $list;
    }
    
    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param array $files
     * @return array
     */
    protected function _getfiles($path, $allowFiles, &$files = array())
    {
        if (!is_dir($path)) return null;
    
        if (substr($path, strlen($path) - 1) != '/') $path .= '/';
    
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    $this->_getfiles($path2, $allowFiles, $files);
                } else {
                    if (preg_match('/\.('.$allowFiles.')$/i', $file)) {
                        $files[] = array(
                            'url'=> \RC_Upload::upload_url().'/'.substr($path2, strlen(\RC_Upload::upload_path())),
                            'mtime'=> filemtime($path2)
                        );
                    }
                }
            }
        }
        return $files;
    }
    
}
