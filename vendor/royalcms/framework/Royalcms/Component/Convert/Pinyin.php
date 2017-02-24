<?php
namespace Royalcms\Component\Convert;
defined('IN_ROYALCMS') or exit('No permission resources.');

if (defined('CODE_TABLE_DIR'))
    define('CODE_TABLE_DIR', dirname(__FILE__) . DS . 'encoding' . DS);

/**
 * 编码转换类
 *
 * @author royalwang
 *        
 */
class Pinyin
{

    /**
     * ASCII转拼音
     *
     * @param unknown $asc            
     * @param unknown $pyarr            
     * @return string unknown
     */
    public static function asc_to_pinyin($asc, &$pyarr)
    {
        if ($asc < 128)
            return chr($asc);
        elseif (isset($pyarr[$asc]))
            return $pyarr[$asc];
        else {
            foreach ($pyarr as $id => $p) {
                if ($id >= $asc)
                    return $p;
            }
        }
    }

    /**
     * GBK转拼音
     *
     * @param unknown $txt            
     * @return multitype:Ambigous <string, unknown>
     */
    public static function gbk_to_pinyin($txt)
    {
        $l = strlen($txt);
        $i = 0;
        $pyarr = array();
        $py = array();
        $filename = CODE_TABLE_DIR . 'gb-pinyin.table';
        $fp = fopen($filename, 'r');
        while (! feof($fp)) {
            $p = explode("-", fgets($fp, 32));
            $pyarr[intval($p[1])] = trim($p[0]);
        }
        fclose($fp);
        ksort($pyarr);
        while ($i < $l) {
            $tmp = ord($txt[$i]);
            if ($tmp >= 128) {
                $asc = abs($tmp * 256 + ord($txt[$i + 1]) - 65536);
                $i = $i + 1;
            } else
                $asc = $tmp;
            $py[] = self::asc_to_pinyin($asc, $pyarr);
            $i ++;
        }
        return $py;
    }
}

// end