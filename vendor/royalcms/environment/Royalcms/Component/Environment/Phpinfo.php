<?php

namespace Royalcms\Component\Environment;

/**
 * 本地环境检测工具类
 *
 * @author royalwang
 *
 */
class Phpinfo
{
    protected $phpinfo;
    
    public function __construct()
    {
        $this->phpinfo = $this->parse_phpinfo();
    }
    
    public function phpinfo() 
    {
        return $this->phpinfo;
    }
    
    protected function parse_phpinfo()
    {
        $phpinfo = array(
            'phpinfo' => array()
        );
        if (function_exists('phpinfo')) {
            ob_start();
            phpinfo(INFO_ALL);
            $arr_keys = array_keys($phpinfo);
    
            $filter_module = array(
                'apache2handler',
                'Apache Environment',
                'HTTP Headers Information',
                'Additional Modules',
                'Environment',
                'PHP Variables',
                'PHP License'
            );
    
            if (preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', ob_get_clean(), $matches, PREG_SET_ORDER))
                foreach ($matches as $match) {
                    if (count($match) === 3) {
                        continue;
                    }
                    if (strlen($match[1])) {
                        if (in_array($match[1], $filter_module)) {
                            continue;
                        }
                        $phpinfo['modules'][] = $match[1];
                    } elseif (isset($match[3])) {
                        $phpinfo[end($arr_keys)][$match[2]] = isset($match[4]) ? array(
                            $match[3],
                            $match[4]
                        ) : $match[3];
                    } else {
                        $phpinfo[end($arr_keys)][] = $match[2];
                    }
                }
        }
    
        return $phpinfo;
    }
}