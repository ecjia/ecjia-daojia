<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/15
 * Time: 1:36 PM
 */

namespace Royalcms\Component\Filesystem;

use finfo;
use RC_Hook;
use RC_Format;
use RC_Config;
use Royalcms\Component\Support\Str;

/**
 * @todo royalcms
 * Trait FileHelperTrait
 * @package Royalcms\Component\Filesystem
 *
 * @method static string extension($path) Extract the file extension from a file path.
 *
 */
trait FileHelperTrait
{

    /**
     * MIME mapping.
     *
     * @var array
     */
    protected static $extensionMap = [
        'audio/wav' => '.wav',
        'audio/x-ms-wma' => '.wma',
        'video/x-ms-wmv' => '.wmv',
        'video/mp4' => '.mp4',
        'audio/mpeg' => '.mp3',
        'audio/amr' => '.amr',
        'application/vnd.rn-realmedia' => '.rm',
        'audio/mid' => '.mid',
        'image/bmp' => '.bmp',
        'image/gif' => '.gif',
        'image/png' => '.png',
        'image/tiff' => '.tiff',
        'image/jpeg' => '.jpg',

        // 列举更多的文件 mime, 企业号是支持的, 公众平台这边之后万一也更新了呢
        'application/msword' => '.doc',

        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template' => '.dotx',
        'application/vnd.ms-word.document.macroEnabled.12' => '.docm',
        'application/vnd.ms-word.template.macroEnabled.12' => '.dotm',

        'application/vnd.ms-excel' => '.xls',

        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '.xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template' => '.xltx',
        'application/vnd.ms-excel.sheet.macroEnabled.12' => '.xlsm',
        'application/vnd.ms-excel.template.macroEnabled.12' => '.xltm',
        'application/vnd.ms-excel.addin.macroEnabled.12' => '.xlam',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12' => '.xlsb',

        'application/vnd.ms-powerpoint' => '.ppt',

        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => '.pptx',
        'application/vnd.openxmlformats-officedocument.presentationml.template' => '.potx',
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow' => '.ppsx',
        'application/vnd.ms-powerpoint.addin.macroEnabled.12' => '.ppam',
    ];

    /**
     * File header signatures.
     *
     * @var array
     */
    protected static $signatures = [
        'ffd8ff' => '.jpg',
        '424d' => '.bmp',
        '47494638' => '.gif',
        '89504e47' => '.png',
        '494433' => '.mp3',
        'fffb' => '.mp3',
        'fff3' => '.mp3',
        '3026b2758e66cf11' => '.wma',
        '52494646' => '.wav',
        '57415645' => '.wav',
        '41564920' => '.avi',
        '000001ba' => '.mpg',
        '000001b3' => '.mpg',
        '2321414d52' => '.amr',
    ];

    /**
     * Return steam extension.
     *
     * @param string $stream
     *
     * @return string
     */
    public static function getStreamExt($stream)
    {
        if (is_dir(pathinfo($stream, PATHINFO_DIRNAME)) && is_readable($stream)) {
            $stream = file_get_contents($stream);
        }

        $finfo = new finfo(FILEINFO_MIME);

        $mime = strstr($finfo->buffer($stream), ';', true);

        return isset(self::$extensionMap[$mime]) ? self::$extensionMap[$mime] : self::getExtBySignature($stream);
    }

    /**
     * Get file extension by file header signature.
     *
     * @param string $stream
     *
     * @return string
     */
    public static function getExtBySignature($stream)
    {
        $prefix = strval(bin2hex(mb_strcut($stream, 0, 10)));

        foreach (self::$signatures as $signature => $extension) {
            if (0 === strpos($prefix, strval($signature))) {
                return $extension;
            }
        }

        return '';
    }

    /**
     * 取得文件扩展名
     *
     * @param string $filename 文件名
     * @return string 扩展名
     */
    public static function getFileNameExtension($filename)
    {
        return self::extension($filename);
    }

    /**
     * 取得文件扩展名
     *
     * @param string $filename 文件名
     * @return string 扩展名
     */
    public static function file_ext($filename)
    {
        return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
    }


    /**
     * 文件下载
     *
     * @param $filepath 文件路径
     * @param $filename 文件名称
     */
    public static function download($filepath, $filename = '')
    {
        if (! $filename) {
            $filename = basename($filepath);
        }

        if (is_ie()) {
            $filename = rawurlencode($filename);
        }

        $filetype = self::file_ext($filename);
        $filesize = sprintf("%u", filesize($filepath));
        if (ob_get_length() !== false) {
            ob_end_clean();
        }

        header('Pragma: public');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: pre-check=0, post-check=0, max-age=0');
        header('Content-Transfer-Encoding: binary');
        header('Content-Encoding: none');
        header('Content-type: ' . $filetype);
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-length: ' . $filesize);
        readfile($filepath);
        exit();
    }


    /**
     * 获取文件后缀名,并判断是否合法
     *
     * @param string $file_name
     * @param array $allow_type
     * @return bool
     */
    public static function file_suffix($file_name, $allow_type = array())
    {
        $file_name_arr = explode('.', $file_name);
        $file_suffix = strtolower(array_pop($file_name_arr));
        if (empty($allow_type)) {
            return $file_suffix;
        } else {
            if (in_array($file_suffix, $allow_type)) {
                return true;
            } else {
                return false;
            }
        }
    }


    /**
     * 多个PHP文件合并
     *
     * @param array $files 文件列表
     * @param bool $space 是否去除空白
     * @param bool $tag 是否加<?php标签头尾
     * @return string 合并后的字符串
     */
    public static function file_merge($files, $space = false, $tag = false)
    {
        /* 格式化后的内容 */
        $str = '';
        foreach ($files as $file) {
            $content = trim(file_get_contents($file));
            if ($space)
                $con = self::file_compress($content);
            $str .= substr($content, - 2) == '?>' ? trim(substr($con, 5, - 2)) : trim($content, 5);
        }
        return $tag ? "defined('IN_ROYALCMS') or exit('No permission resources.');" . $str . "\t?>" : $str;
    }


    /**
     * 去空格，去除注释包括单行及多行注释
     *
     * @param string $content 数据
     * @return string
     */
    public static function file_compress($content)
    {
        /* 合并后的字符串 */
        $str = "";
        $data = token_get_all($content);
        /* 没结束如$v = "royalcms"中的等号 */
        $end = false;
        for ($i = 0, $count = count($data); $i < $count; $i ++) {
            if (is_string($data[$i])) {
                $end = false;
                $str .= $data[$i];
            } else {
                /* 检测类型 */
                switch ($data[$i][0]) {
                    /* 忽略单行多行注释 */
                    case T_COMMENT:
                    case T_DOC_COMMENT:
                        break;
                    /* 去除格 */
                    case T_WHITESPACE:
                        if (! $end) {
                            $end = true;
                            $str .= " ";
                        }
                        break;
                    /* 定界符开始 */
                    case T_START_HEREDOC:
                        $str .= "<<<ROYALCMS\n";
                        break;
                    /* 定界符结束 */
                    case T_END_HEREDOC:
                        $str .= "ROYALCMS;\n";
                        /* 类似str;分号前换行情况 */
                        for ($m = $i + 1; $m < $count; $m ++) {
                            if (is_string($data[$m]) && $data[$m] == ';') {
                                $i = $m;
                                break;
                            }
                            if ($data[$m] == T_CLOSE_TAG) {
                                break;
                            }
                        }
                        break;

                    default:
                        $end = false;
                        $str .= $data[$i][1];
                }
            }
        }
        return $str;
    }


    /**
     * Retrieve metadata from a file.
     *
     * Searches for metadata in the first 8kiB of a file, such as a plugin or theme.
     * Each piece of metadata must be on its own line. Fields can not span multiple
     * lines, the value will get cut at the end of the first line.
     *
     * If the file data is not within that first 8kiB, then the author should correct
     * their plugin file and move the data headers to the top.
     *
     * @since 3.0.0
     * @param string $file Path to the file
     * @param array $default_headers List of headers, in the format array('HeaderKey' => 'Header Name')
     * @param string $context If specified adds filter hook "extra_{$context}_headers"
     */
    public static function get_file_data($file, $default_headers, $context = '')
    {
        // We don't need to write to the file, so just open for reading.
        $fp = fopen($file, 'r');

        // Pull only the first 8kiB of the file in.
        $file_data = fread($fp, 8192);

        // PHP will close file handle, but we are good citizens.
        fclose($fp);

        // Make sure we catch CR-only line endings.
        $file_data = str_replace("\r", "\n", $file_data);

        /**
         * Filter extra file headers by context.
         *
         * The dynamic portion of the hook name, $context, refers to the context
         * where extra headers might be loaded.
         *
         * @since 3.0.0
         *
         * @param array $extra_context_headers
         *            Empty array by default.
         */
        if ($context && $extra_headers = RC_Hook::apply_filters("extra_{$context}_headers", array())) {
            $extra_headers = array_combine($extra_headers, $extra_headers); // keys equal values
            $all_headers = array_merge($extra_headers, (array) $default_headers);
        } else {
            $all_headers = $default_headers;
        }

        foreach ($all_headers as $field => $regex) {
            if (preg_match('/^[ \t\/*#@]*' . preg_quote($regex, '/') . ':(.*)$/mi', $file_data, $match) && $match[1])
                $all_headers[$field] = RC_Format::_cleanup_header_comment($match[1]);
            else
                $all_headers[$field] = '';
        }

        return $all_headers;
    }


    /**
     * 检测模板文件是否存在
     *
     * @param $template
     */
    public static function template_exists($template)
    {
        if (! $template) {
            return false;
        }

        $template = SITE_THEME_PATH . RC_Config::get('system.tpl_style') . DIRECTORY_SEPARATOR . $template . '.php';
        if (file_exists($template)) {
            return true;
        }
        return false;
    }


    /**
     * 检查文件MD5值
     *
     * @param string $currentdir 待检查目录
     * @param string $ext 待检查的文件类型, eg: \.dwt|\.lbi|\.css
     * @param int $sub 是否检查子目录
     * @param string $skip 不检查的目录或文件
     */
    public static function get_md5_files($currentdir, $ext = '', $sub = 1, $skip = '')
    {
        $currentdir = SITE_ROOT . str_replace(SITE_ROOT, '', $currentdir);
        $dir = opendir($currentdir);
        $exts = '/(' . $ext . ')$/i';
        $skips = explode(',', $skip);

        static $md5data = array();
        while (($entry = readdir($dir)) == true) {
            $file = $currentdir . $entry;
            if ($entry != '.' && $entry != '..' && $entry != '.svn' && $entry != '.git' && $entry != '.DS_Store' && (preg_match($exts, $entry) || ($sub && is_dir($file))) && ! in_array($entry, $skips)) {
                if ($sub && is_dir($file)) {
                    $md5data = self::get_md5_files($file . '/', $ext, $sub, $skip);
                } else {
                    $md5data[str_replace(SITE_ROOT, '', $file)] = md5_file($file);
                }
            }
        }
        return $md5data;
    }


    /**
     * 文件或目录权限检查函数
     *
     * @access public
     * @param string $file_path 文件路径
     * @param bool $rename_prv 是否在检查修改权限时检查执行rename()函数的权限
     *
     * @return int 返回值的取值范围为{0 <= x <= 15}，每个值表示的含义可由四位二进制数组合推出。
     *         返回值在二进制计数法中，四位由高到低分别代表
     *         可执行rename()函数权限、可对文件追加内容权限、可写入文件权限、可读取文件权限。
     */
    public static function file_mode_info($file_path)
    {
        /* 如果不存在，则不可读、不可写、不可改 */
        if (! file_exists($file_path)) {
            return false;
        }

        $mark = 0;

        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            /* 测试文件 */
            $test_file = $file_path . '/cf_test.txt';

            /* 如果是目录 */
            if (is_dir($file_path)) {
                /* 检查目录是否可读 */
                $dir = opendir($file_path);
                if ($dir === false) {
                    return $mark; // 如果目录打开失败，直接返回目录不可修改、不可写、不可读
                }
                if (readdir($dir) !== false) {
                    $mark ^= 1; // 目录可读 001，目录不可读 000
                }
                closedir($dir);

                /* 检查目录是否可写 */
                $fp = fopen($test_file, 'wb');
                if ($fp === false) {
                    return $mark; // 如果目录中的文件创建失败，返回不可写。
                }
                if (fwrite($fp, 'directory access testing.') !== false) {
                    $mark ^= 2; // 目录可写可读011，目录可写不可读 010
                }
                fclose($fp);

                unlink($test_file);

                /* 检查目录是否可修改 */
                $fp = fopen($test_file, 'ab+');
                if ($fp === false) {
                    return $mark;
                }
                if (fwrite($fp, "modify test.\r\n") !== false) {
                    $mark ^= 4;
                }
                fclose($fp);

                /* 检查目录下是否有执行rename()函数的权限 */
                if (rename($test_file, $test_file) !== false) {
                    $mark ^= 8;
                }
                unlink($test_file);

                /* 如果是文件 */
            } elseif (is_file($file_path)) {
                /* 以读方式打开 */
                $fp = fopen($file_path, 'rb');
                if ($fp) {
                    $mark ^= 1; // 可读 001
                }
                fclose($fp);

                /* 试着修改文件 */
                $fp = fopen($file_path, 'ab+');
                if ($fp && fwrite($fp, '') !== false) {
                    $mark ^= 6; // 可修改可写可读 111，不可修改可写可读011...
                }
                fclose($fp);

                /* 检查目录下是否有执行rename()函数的权限 */
                if (rename($test_file, $test_file) !== false) {
                    $mark ^= 8;
                }
            }
        } else {
            if (is_readable($file_path)) {
                $mark ^= 1;
            }

            if (is_writable($file_path)) {
                $mark ^= 14;
            }
        }

        return $mark;
    }


    /**
     * 检查数组中目录权限
     *
     * @access public
     * @param array $arr 要检查的文件列表数组
     * @param array $err_msg 错误信息回馈数组
     *
     * @return int $mark 文件权限掩码
     */
    public static function check_file_purview($arr, &$err_msg)
    {
        $read = true;
        $writen = true;
        $modify = true;
        foreach ($arr as $val) {
            $mark = self::file_mode_info(SITE_ROOT . $val);
            if (($mark & 1) < 1) {
                $read = false;
                $err_msg['r'][] = $val;
            }
            if (($mark & 2) < 1) {
                $writen = false;
                $err_msg['w'][] = $val;
            }
            if (($mark & 4) < 1) {
                $modify = false;
                $err_msg['m'][] = $val;
            }
        }

        $mark = 0;
        if ($read) {
            $mark ^= 1;
        }
        if ($writen) {
            $mark ^= 2;
        }
        if ($modify) {
            $mark ^= 4;
        }

        return $mark;
    }


    /**
     * 检查文件类型
     * @param       string      filename            文件名
     * @param       string      realname            真实文件名
     * @param       string      limit_ext_types     允许的文件类型
     * @return      string
     */
    function check_file_type($filename, $realname = '', $limit_ext_types = '')
    {
        if ($realname) {
            $extname = strtolower(substr($realname, strrpos($realname, '.') + 1));
        } else {
            $extname = strtolower(substr($filename, strrpos($filename, '.') + 1));
        }

        if ($limit_ext_types && stristr($limit_ext_types, '|' . $extname . '|') === false) {
            return '';
        }

        $str = $format = '';

        $file = fopen($filename, 'rb');
        if ($file) {
            $str = fread($file, 0x400); // 读取前 1024 个字节
            fclose($file);
        } else {
            if (stristr($filename, SITE_ROOT) === false) {
                if ($extname == 'jpg' || $extname == 'jpeg' || $extname == 'gif' || $extname == 'png' || $extname == 'doc' ||
                    $extname == 'xls' || $extname == 'txt'  || $extname == 'zip' || $extname == 'rar' || $extname == 'ppt' ||
                    $extname == 'pdf' || $extname == 'rm'   || $extname == 'mid' || $extname == 'wav' || $extname == 'bmp' ||
                    $extname == 'swf' || $extname == 'chm'  || $extname == 'sql' || $extname == 'cert'|| $extname == 'pptx' ||
                    $extname == 'xlsx' || $extname == 'docx')
                {
                    $format = $extname;
                }
            } else {
                return '';
            }
        }

        if ($format == '' && strlen($str) >= 2 ) {
            if (substr($str, 0, 4) == 'MThd' && $extname != 'txt') {
                $format = 'mid';
            }
            elseif (substr($str, 0, 4) == 'RIFF' && $extname == 'wav') {
                $format = 'wav';
            }
            elseif (substr($str ,0, 3) == "\xFF\xD8\xFF") {
                $format = 'jpg';
            }
            elseif (substr($str ,0, 4) == 'GIF8' && $extname != 'txt') {
                $format = 'gif';
            }
            elseif (substr($str ,0, 8) == "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A") {
                $format = 'png';
            }
            elseif (substr($str ,0, 2) == 'BM' && $extname != 'txt') {
                $format = 'bmp';
            }
            elseif ((substr($str ,0, 3) == 'CWS' || substr($str ,0, 3) == 'FWS') && $extname != 'txt') {
                $format = 'swf';
            }
            elseif (substr($str ,0, 4) == "\xD0\xCF\x11\xE0") {   // D0CF11E == DOCFILE == Microsoft Office Document
                if (substr($str,0x200,4) == "\xEC\xA5\xC1\x00" || $extname == 'doc') {
                    $format = 'doc';
                }
                elseif (substr($str,0x200,2) == "\x09\x08" || $extname == 'xls') {
                    $format = 'xls';
                } elseif (substr($str,0x200,4) == "\xFD\xFF\xFF\xFF" || $extname == 'ppt')
                {
                    $format = 'ppt';
                }
            }
            elseif (substr($str ,0, 4) == "PK\x03\x04") {
                if (substr($str,0x200,4) == "\xEC\xA5\xC1\x00" || $extname == 'docx') {
                    $format = 'docx';
                }
                elseif (substr($str,0x200,2) == "\x09\x08" || $extname == 'xlsx') {
                    $format = 'xlsx';
                }
                elseif (substr($str,0x200,4) == "\xFD\xFF\xFF\xFF" || $extname == 'pptx') {
                    $format = 'pptx';
                } else {
                    $format = 'zip';
                }
            }
            elseif (substr($str ,0, 4) == 'Rar!' && $extname != 'txt') {
                $format = 'rar';
            }
            elseif (substr($str ,0, 4) == "\x25PDF") {
                $format = 'pdf';
            }
            elseif (substr($str ,0, 3) == "\x30\x82\x0A") {
                $format = 'cert';
            }
            elseif (substr($str ,0, 4) == 'ITSF' && $extname != 'txt') {
                $format = 'chm';
            }
            elseif (substr($str ,0, 4) == "\x2ERMF") {
                $format = 'rm';
            }
            elseif ($extname == 'sql') {
                $format = 'sql';
            }
            elseif ($extname == 'txt') {
                $format = 'txt';
            }
        }

        if ($limit_ext_types && stristr($limit_ext_types, '|' . $format . '|') === false) {
            $format = '';
        }

        return $format;
    }


    /**
     * File validates against allowed set of defined rules.
     *
     * A return value of '1' means that the $file contains either '..' or './'. A
     * return value of '2' means that the $file contains ':' after the first
     * character. A return value of '3' means that the file is not in the allowed
     * files list.
     *
     * @since 3.0.0
     *
     * @param string $file File path.
     * @param array $allowed_files List of allowed files.
     * @return int 0 means nothing is wrong, greater than 0 means something was wrong.
     */
    public static function validate_file( $file, $allowed_files = '' )
    {
        if ( false !== strpos( $file, '..' ) ) {
            return 1;
        }

        if ( false !== strpos( $file, './' ) ) {
            return 1;
        }

        if ( ! empty( $allowed_files ) && ! in_array( $file, $allowed_files ) ) {
            return 3;
        }

        if (':' == substr( $file, 1, 1 ) ) {
            return 2;
        }

        return 0;
    }


    /**
     * 移动图片位置
     * @param string $source
     * @param string $dest
     * @return boolean
     */
    public static function move_file($source, $dest)
    {
        if (copy($source, $dest)) {
            unlink($source);
            return true;
        } else {
            return false;
        }
    }


    /**
     * 判断一个文件路径是否是绝对路径
     * @param string $path
     */
    public static function is_absolute_path($path)
    {
        if (strpos($path, '/') === 0 || strpos($path, ":\\") === 1) {
            return true;
        } else {
            return false;
        }
    }

}