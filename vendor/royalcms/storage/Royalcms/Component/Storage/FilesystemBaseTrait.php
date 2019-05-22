<?php

namespace Royalcms\Component\Storage;

use Royalcms\Component\Support\Format;
use Royalcms\Component\Foundation\Theme;

/**
 * Base Royalcms Filesystem
 *
 * @package Royalcms
 * @subpackage Filesystem
 */

/**
 * Base Royalcms Filesystem class for which Filesystem implementations extend
 *
 * @since 2.5.0
 */
trait FilesystemBaseTrait
{

    /**
     * Whether to display debug data for the connection.
     *
     * @access public
     * @since 2.5.0
     * @var bool
     */
    public $verbose = false;

    /**
     * Cached list of local filepaths to mapped remote filepaths.
     *
     * @access private
     * @since 2.7.0
     * @var array
     */
    private $cache = array();

    /**
     * The Access method of the current connection, Set automatically.
     *
     * @access public
     * @since 2.5.0
     * @var string
     */
    protected $method = '';


    /**
     * Return the path on the remote filesystem of ABSPATH.
     *
     * @access public
     * @since 2.7.0
     *       
     * @return string The location of the remote path.
     */
    public function abspath()
    {
        $folder = $this->find_folder(ABSPATH);
        // Perhaps the FTP folder is rooted at the WordPress install, Check for wp-includes folder in root, Could have some false positives, but rare.
        if (! $folder && $this->is_dir('/wp-includes'))
            $folder = '/';
        return $folder;
    }

    /**
     * Return the path on the remote filesystem of RC_CONTENT_PATH.
     *
     * @access public
     * @since 2.7.0
     *       
     * @return string The location of the remote path.
     */
    public function rc_content_dir()
    {
        return $this->find_folder(RC_CONTENT_PATH);
    }

    /**
     * Return the path on the remote filesystem of RC_PLUGIN_PATH.
     *
     * @access public
     * @since 2.7.0
     *       
     * @return string The location of the remote path.
     */
    public function rc_plugins_dir()
    {
        return $this->find_folder(RC_PLUGIN_PATH);
    }

    /**
     * Return the path on the remote filesystem of the Themes Directory.
     *
     * @access public
     * @since 2.7.0
     *       
     * @param string $theme
     *            The Theme stylesheet or template for the directory.
     * @return string The location of the remote path.
     */
    public function rc_themes_dir($theme = false)
    {
        $theme_root = Theme::get_theme_root($theme);
        
        // Account for relative theme roots
        if ('/themes' == $theme_root || ! is_dir($theme_root))
            $theme_root = RC_CONTENT_PATH . $theme_root;
        
        return $this->find_folder($theme_root);
    }

    /**
     * Return the path on the remote filesystem of WP_LANG_DIR.
     *
     * @access public
     * @since 3.2.0
     *       
     * @return string The location of the remote path.
     */
    public function rc_lang_dir()
    {
        return $this->find_folder(RC_LANG_PATH);
    }

    /**
     * Locate a folder on the remote filesystem.
     *
     * @access public
     * @since 2.5.0
     * @deprecated 2.7.0 use RC_Filesystem::abspath() or RC_Filesystem::wp_*_dir() instead.
     * @see RC_Filesystem::abspath()
     * @see RC_Filesystem::wp_content_dir()
     * @see RC_Filesystem::wp_plugins_dir()
     * @see RC_Filesystem::wp_themes_dir()
     * @see RC_Filesystem::wp_lang_dir()
     *
     * @param string $base
     *            The folder to start searching from.
     * @param bool $echo
     *            True to display debug information.
     *            Default false.
     * @return string The location of the remote path.
     */
    public function find_base_dir($base = '.', $echo = false)
    {
        _deprecated_function(__FUNCTION__, '3.8', '\Royalcms\Component\Storage\FilesystemBase::abspath() or \Royalcms\Component\Storage\FilesystemBase::rc_*_dir()');
        $this->verbose = $echo;
        return $this->abspath();
    }

    /**
     * Locate a folder on the remote filesystem.
     *
     * @access public
     * @since 2.5.0
     * @deprecated 2.7.0 use \Royalcms\Component\Storage\FilesystemBase::abspath() or RC_Filesystem::rc_*_dir() methods instead.
     * @see \Royalcms\Component\Storage\FilesystemBase::abspath()
     * @see \Royalcms\Component\Storage\FilesystemBase::rc_content_dir()
     * @see \Royalcms\Component\Storage\FilesystemBase::rc_plugins_dir()
     * @see \Royalcms\Component\Storage\FilesystemBase::rc_themes_dir()
     * @see \Royalcms\Component\Storage\FilesystemBase::rc_lang_dir()
     *
     * @param string $base
     *            The folder to start searching from.
     * @param bool $echo
     *            True to display debug information.
     * @return string The location of the remote path.
     */
    public function get_base_dir($base = '.', $echo = false)
    {
        _deprecated_function(__FUNCTION__, '3.8', '\Royalcms\Component\Storage::abspath() or \Royalcms\Component\Storage\FilesystemBase::rc_*_dir()');
        $this->verbose = $echo;
        return $this->abspath();
    }

    /**
     * Locate a folder on the remote filesystem.
     *
     * Assumes that on Windows systems, Stripping off the Drive
     * letter is OK Sanitizes \\ to / in windows filepaths.
     *
     * @access public
     * @since 2.7.0
     *       
     * @param string $folder
     *            the folder to locate.
     * @return string The location of the remote path.
     */
    public function find_folder($folder)
    {
        if (isset($this->cache[$folder]))
            return $this->cache[$folder];
        
        if (stripos($this->method, 'ftp') !== false) {
            $constant_overrides = array(
                'FTP_BASE'          => SITE_ROOT,
                'FTP_CONTENT_DIR'   => RC_CONTENT_PATH,
                'FTP_PLUGIN_DIR'    => RC_PLUGIN_PATH,
                'FTP_LANG_DIR'      => RC_LANG_PTAH
            );
            
            // Direct matches ( folder = CONSTANT/ )
            foreach ($constant_overrides as $constant => $dir) {
                if (! defined($constant))
                    continue;
                if ($folder === $dir)
                    return Format::trailingslashit(constant($constant));
            }
            
            // Prefix Matches ( folder = CONSTANT/subdir )
            foreach ($constant_overrides as $constant => $dir) {
                if (! defined($constant))
                    continue;
                if (0 === stripos($folder, $dir)) { // $folder starts with $dir
                    $potential_folder = preg_replace('#^' . preg_quote($dir, '#') . '/#i', Format::trailingslashit(constant($constant)), $folder);
                    $potential_folder = Format::trailingslashit($potential_folder);
                    
                    if ($this->is_dir($potential_folder)) {
                        $this->cache[$folder] = $potential_folder;
                        return $potential_folder;
                    }
                }
            }
        } elseif ('direct' == $this->method) {
            $folder = str_replace('\\', '/', $folder); // Windows path sanitisation
            return Format::trailingslashit($folder);
        }
        
        $folder = preg_replace('|^([a-z]{1}):|i', '', $folder); // Strip out windows drive letter if it's there.
        $folder = str_replace('\\', '/', $folder); // Windows path sanitisation
        
        if (isset($this->cache[$folder]))
            return $this->cache[$folder];
        
        if ($this->exists($folder)) { // Folder exists at that absolute path.
            $folder = Format::trailingslashit($folder);
            $this->cache[$folder] = $folder;
            return $folder;
        }
        if (($return = $this->search_for_folder($folder)) !== false)
            $this->cache[$folder] = $return;
        return $return;
    }

    /**
     * Locate a folder on the remote filesystem.
     *
     * Expects Windows sanitized path.
     *
     * @access private
     * @since 2.7.0
     *       
     * @param string $folder
     *            The folder to locate.
     * @param string $base
     *            The folder to start searching from.
     * @param bool $loop
     *            If the function has recursed, Internal use only.
     * @return string The location of the remote path.
     */
    public function search_for_folder($folder, $base = '.', $loop = false)
    {
        if (empty($base) || '.' == $base)
            $base = Format::trailingslashit($this->cwd());
        
        $folder = Format::untrailingslashit($folder);
        
        if ($this->verbose)
            printf("\n" . __('Looking for %1$s in %2$s') . "<br/>\n", $folder, $base);
        
        $folder_parts = explode('/', $folder);
        $folder_part_keys = array_keys($folder_parts);
        $last_index = array_pop($folder_part_keys);
        $last_path = $folder_parts[$last_index];
        
        $files = $this->dirlist($base);
        
        foreach ($folder_parts as $index => $key) {
            if ($index == $last_index)
                continue; // We want this to be caught by the next code block.
                              
            // Working from /home/ to /user/ to /wordpress/ see if that file exists within the current folder,
                              // If it's found, change into it and follow through looking for it.
                              // If it cant find WordPress down that route, it'll continue onto the next folder level, and see if that matches, and so on.
                              // If it reaches the end, and still cant find it, it'll return false for the entire function.
            if (isset($files[$key])) {
                // Lets try that folder:
                $newdir = Format::trailingslashit(Format::path_join($base, $key));
                if ($this->verbose)
                    printf("\n" . __('Changing to %s') . "<br/>\n", $newdir);
                    // only search for the remaining path tokens in the directory, not the full path again
                $newfolder = implode('/', array_slice($folder_parts, $index + 1));
                if (($ret = $this->search_for_folder($newfolder, $newdir, $loop)) !== false)
                    return $ret;
            }
        }
        
        // Only check this as a last resort, to prevent locating the incorrect install. All above procedures will fail quickly if this is the right branch to take.
        if (isset($files[$last_path])) {
            if ($this->verbose)
                printf("\n" . __('Found %s') . "<br/>\n", $base . $last_path);
            return Format::trailingslashit($base . $last_path);
        }
        
        // Prevent this function from looping again.
        // No need to proceed if we've just searched in /
        if ($loop || '/' == $base)
            return false;
            
            // As an extra last resort, Change back to / if the folder wasn't found.
            // This comes into effect when the CWD is /home/user/ but WP is at /var/www/....
        return $this->search_for_folder($folder, '/', true);
    }

    /**
     * Return the *nix-style file permissions for a file.
     *
     * From the PHP documentation page for fileperms().
     *
     * @link http://docs.php.net/fileperms
     *      
     * @access public
     * @since 2.5.0
     *       
     * @param string $file
     *            String filename.
     * @return string The *nix-style representation of permissions.
     */
    public function gethchmod($file)
    {
        $perms = $this->getchmod($file);
        if (($perms & 0xC000) == 0xC000) // Socket
            $info = 's';
        elseif (($perms & 0xA000) == 0xA000) // Symbolic Link
            $info = 'l';
        elseif (($perms & 0x8000) == 0x8000) // Regular
            $info = '-';
        elseif (($perms & 0x6000) == 0x6000) // Block special
            $info = 'b';
        elseif (($perms & 0x4000) == 0x4000) // Directory
            $info = 'd';
        elseif (($perms & 0x2000) == 0x2000) // Character special
            $info = 'c';
        elseif (($perms & 0x1000) == 0x1000) // FIFO pipe
            $info = 'p';
        else // Unknown
            $info = 'u';
            
            // Owner
        $info .= (($perms & 0x0100) ? 'r' : '-');
        $info .= (($perms & 0x0080) ? 'w' : '-');
        $info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));
        
        // Group
        $info .= (($perms & 0x0020) ? 'r' : '-');
        $info .= (($perms & 0x0010) ? 'w' : '-');
        $info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));
        
        // World
        $info .= (($perms & 0x0004) ? 'r' : '-');
        $info .= (($perms & 0x0002) ? 'w' : '-');
        $info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));
        return $info;
    }

    /**
     * Convert *nix-style file permissions to a octal number.
     *
     * Converts '-rw-r--r--' to 0644
     * From "info at rvgate dot nl"'s comment on the PHP documentation for chmod()
     *
     * @link http://docs.php.net/manual/en/function.chmod.php#49614
     *      
     * @access public
     * @since 2.5.0
     *       
     * @param string $mode
     *            string The *nix-style file permission.
     * @return int octal representation
     */
    public function getnumchmodfromh($mode)
    {
        $realmode = '';
        $legal = array(
            '',
            'w',
            'r',
            'x',
            '-'
        );
        $attarray = preg_split('//', $mode);
        
        for ($i = 0; $i < count($attarray); $i ++)
            if (($key = array_search($attarray[$i], $legal)) !== false)
                $realmode .= $legal[$key];
        
        $mode = str_pad($realmode, 10, '-', STR_PAD_LEFT);
        $trans = array(
            '-' => '0',
            'r' => '4',
            'w' => '2',
            'x' => '1'
        );
        $mode = strtr($mode, $trans);
        
        $newmode = $mode[0];
        $newmode .= $mode[1] + $mode[2] + $mode[3];
        $newmode .= $mode[4] + $mode[5] + $mode[6];
        $newmode .= $mode[7] + $mode[8] + $mode[9];
        return $newmode;
    }

    /**
     * Determine if the string provided contains binary characters.
     *
     * @access private
     * @since 2.7.0
     *       
     * @param string $text
     *            String to test against.
     * @return bool true if string is binary, false otherwise.
     */
    private function is_binary($text)
    {
        return (bool) preg_match('|[^\x20-\x7E]|', $text); // chr(32)..chr(127)
    }


} 
