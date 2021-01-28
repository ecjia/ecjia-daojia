<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-05
 * Time: 14:53
 */

namespace Royalcms\Component\Storage\Contracts;


interface StorageInterface
{

    /**
     * Change the ownership of a file / folder.
     *
     * Default behavior is to do nothing, override this in your subclass, if desired.
     *
     * @since 2.5.0
     *
     * @param string $file Path to the file.
     * @param mixed $owner A user name or number.
     * @param bool $recursive Optional. If set True changes file owner recursivly. Defaults to False.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function chown($file, $owner, $recursive = false);

    /**
     * Connect filesystem.
     *
     * @since 2.5.0
     *
     * @return bool True on success or false on failure (always true for WP_Filesystem_Direct).
     */
    public function connect();

    /**
     * Moves an uploaded file to a new location
     *
     * @since 3.8.0
     *
     * @param $filename string <p>
     * The filename of the uploaded file.
     * </p>
     * @param $destination string <p>
     * The destination of the moved file.
     * </p>
     * @return bool true on success.
     * </p>
     * <p>
     * If filename is not a valid upload file,
     * then no action will occur, and
     * move_uploaded_file will return
     * false.
     * </p>
     * <p>
     * If filename is a valid upload file, but
     * cannot be moved for some reason, no action will occur, and
     * move_uploaded_file will return
     * false. Additionally, a warning will be issued.
     */
    public function move_uploaded_file($filename, $destination);


    /**
     * Read entire file into a string.
     *
     * @since 2.5.0
     *
     * @param string $file Name of the file to read.
     *
     * @return string bool the read data or false on failure.
     */
    public function get_contents($file);


    /**
     * Read entire file into an array.
     *
     * @since 2.5.0
     *
     * @param string $file
     *            Path to the file.
     * @return array bool file contents in an array or false on failure.
     */
    public function get_contents_array($file);


    /**
     * Write a string to a file.
     *
     * @since 2.5.0
     *
     * @param string $file Remote path to the file where to write the data.
     * @param string $contents he data to write.
     * @param int $mode Optional. The file permissions as octal number, usually 0644.
     *
     * @return bool False on failure.
     */
    public function put_contents($file, $contents, $mode = 0644);


    /**
     * Get the current working directory.
     *
     * @since 2.5.0
     *
     * @return string bool current working directory on success, or false on failure.
     */
    public function cwd();


    /**
     * Change current directory.
     *
     * @since 2.5.0
     *
     * @param string $dir The new current directory.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function chdir($dir);


    /**
     * Change the file group.
     *
     * @since 2.5.0
     *
     * @param string $file Path to the file.
     * @param mixed $group A group name or number.
     * @param bool $recursive Optional. If set True changes file group recursively. Defaults to False.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function chgrp($file, $group, $recursive = false);


    /**
     * Change filesystem permissions.
     *
     * @since 2.5.0
     *
     * @param string $file Path to the file.
     * @param int $mode Optional. The permissions as octal number, usually 0644 for files, 0755 for dirs.
     * @param bool $recursive Optional. If set True changes file group recursively. Defaults to False.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function chmod($file, $mode = 0644, $recursive = false);


    /**
     * Get the file owner.
     *
     * @since 2.5.0
     *
     * @param string $file Path to the file.
     *
     * @return string bool of the user or false on error.
     */
    public function owner($file);


    /**
     * Get the file's group.
     *
     * @since 2.5.0
     *
     * @param string $file Path to the file.
     *
     * @return string bool group or false on error.
     */
    public function group($file);


    /**
     * Copy a file.
     *
     * @since 2.5.0
     *
     * @param string $source Path to the source file.
     * @param string $destination Path to the destination file.
     * @param bool $overwrite Optional. Whether to overwrite the destination file if it exists.
     *            Default false.
     * @param int $mode Optional. The permissions as octal number, usually 0644 for files, 0755 for dirs.
     *            Default false.
     *
     * @return bool True if file copied successfully, False otherwise.
     */
    public function copy_file($source, $destination, $overwrite = false, $mode = 0644);


    /**
     * Move a file.
     *
     * @since 2.5.0
     *
     * @param string $source Path to the source file.
     * @param string $destination Path to the destination file.
     * @param bool $overwrite Optional. Whether to overwrite the destination file if it exists.
     *            Default false.
     * @param int $mode Optional. The permissions as octal number, usually 0644 for files, 0755 for dirs.
     *            Default false.
     *
     * @return bool True if file copied successfully, False otherwise.
     */
    public function move_file($source, $destination, $overwrite = false, $mode = 0644);


    /**
     * Delete a file or directory.
     *
     * @since 2.5.0
     *
     * @param string $file Path to the file.
     * @param bool $recursive Optional. If set True changes file group recursively. Defaults to False.
     *            Default false.
     * @param bool $type Type of resource. 'f' for file, 'd' for directory.
     *            Default false.
     *
     * @return bool True if the file or directory was deleted, false on failure.
     */
    public function delete_all($file, $recursive = false, $type = false);


    /**
     * Check if a file or directory exists.
     *
     * @since 2.5.0
     *
     * @param string $file Path to file/directory.
     *
     * @return bool Whether $file exists or not.
     */
    public function exists($file);


    /**
     * Check if resource is a file.
     *
     * @since 2.5.0
     *
     * @param string $file File path.
     *
     * @return bool Whether $file is a file.
     */
    public function is_file($file);


    /**
     * Check if resource is a directory.
     *
     * @since 2.5.0
     *
     * @param string $path Directory path.
     *
     * @return bool Whether $path is a directory.
     */
    public function is_dir($path);


    /**
     * Check if a file is readable.
     *
     * @since 2.5.0
     *
     * @param string $file Path to file.
     *
     * @return bool Whether $file is readable.
     */
    public function is_readable($file);


    /**
     * Check if a file or directory is writable.
     *
     * @since 2.5.0
     *
     * @param string $file Path to file/directory.
     *
     * @return bool Whether $file is writable.
     */
    public function is_writable($file);


    /**
     * Gets the file's last access time.
     *
     * @since 2.5.0
     *
     * @param string $file Path to file.
     *
     * @return int Unix timestamp representing last access time.
     */
    public function atime($file);


    /**
     * Gets the file modification time.
     *
     * @since 2.5.0
     *
     * @param string $file Path to file.
     *
     * @return int Unix timestamp representing modification time.
     */
    public function mtime($file);


    /**
     * Gets the file size (in bytes).
     *
     * @since 2.5.0
     *
     * @param string $file Path to file.
     *
     * @return int Size of the file in bytes.
     */
    public function size($file);


    /**
     * Set the access and modification times of a file.
     *
     * Note: If $file doesn't exist, it will be created.
     *
     * @since 2.5.0
     *
     * @param string $file Path to file.
     * @param int $time Optional. Modified time to set for file.
     *            Default 0.
     * @param int $atime Optional. Access time to set for file.
     *            Default 0.
     *
     * @return bool Whether operation was successful or not.
     */
    public function touch($file, $time = 0, $atime = 0);


    /**
     * Create a directory.
     *
     * @since 2.5.0
     *
     * @param string $path Path for new directory.
     * @param mixed $chmod Optional. The permissions as octal number, (or False to skip chmod)
     *            Default false.
     * @param mixed $chown Optional. A user name or number (or False to skip chown)
     *            Default false.
     * @param mixed $chgrp Optional. A group name or number (or False to skip chgrp).
     *            Default false.
     *
     * @return bool False if directory cannot be created, true otherwise.
     */
    public function mkdir($path, $chmod = false, $chown = false, $chgrp = false);


    /**
     * Delete a directory.
     *
     * @since 2.5.0
     *
     * @param string $path Path to directory.
     * @param bool $recursive Optional. Whether to recursively remove files/directories.
     *            Default false.
     *
     * @return bool Whether directory is deleted successfully or not.
     */
    public function rmdir($path, $recursive = false);

    /**
     * Get details for files in a directory or a specific file.
     *
     * @since 2.5.0
     *
     * @param string $path Path to directory or file.
     * @param bool $include_hidden Optional. Whether to include details of hidden ("." prefixed) files.
     *            Default true.
     * @param bool $recursive Optional. Whether to recursively include file details in nested directories.
     *            Default false.
     * @return array bool Array of files. False if unable to list directory contents.
     *
     *         @type string 'name' Name of the file/directory.
     *         @type string 'perms' *nix representation of permissions.
     *         @type int 'permsn' Octal representation of permissions.
     *         @type string 'owner' Owner name or ID.
     *         @type int 'size' Size of file in bytes.
     *         @type int 'lastmodunix' Last modified unix timestamp.
     *         @type mixed 'lastmod' Last modified month (3 letter) and day (without leading 0).
     *         @type int 'time' Last modified time.
     *         @type string 'type' Type of resource. 'f' for file, 'd' for directory.
     *         @type mixed 'files' If a directory and $recursive is true, contains another array of files.
     *         }
     */
    public function dirlist($path, $include_hidden = true, $recursive = false);

    /**
     * 获取目录下的指定类型的文件列表
     * @param $path
     * @param array $allowFiles
     * @param int $start
     * @param int $size
     * @return array
     */
    public function filelist($path, $allowFiles, $start, $size);

}