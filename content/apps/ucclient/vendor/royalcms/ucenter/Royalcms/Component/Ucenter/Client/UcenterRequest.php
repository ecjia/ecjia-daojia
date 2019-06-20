<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/17
 * Time: 1:23 PM
 */

namespace Royalcms\Component\Ucenter\Client;

use Royalcms\Component\Ucenter\Client\Ucenter;
use RC_Http;
use RC_Error;

class UcenterRequest
{
    /**
     * @var UcenterConfig
     */
    protected $config;

    protected $module;

    protected $action;

    protected $args;

    private $user_agent;

    public function __construct(UcenterConfig $config)
    {
        $this->config = $config;
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return mixed
     */
    public function getUcApi()
    {
        return $this->config->UC_API();
    }

    /**
     * @return mixed
     */
    public function getUcKey()
    {
        return $this->config->UC_KEY();
    }

    /**
     * @return mixed
     */
    public function getUcAppid()
    {
        return $this->config->UC_APPID();
    }

    /**
     * @param $module
     * @param $action
     * @param array $arg
     * @return array|string|\RC_Error
     */
    public function send($module, $action, $arg = array(), $extra = null)
    {
        $this->module = $module;
        $this->action = $action;
        $this->args = $arg;

        $this->parameterBuild();

        $body = $this->apiRequestData($extra);

        $postdata = [
            'user-agent' => $this->user_agent,
            'body' => $body
        ];

        $response = RC_Http::remote_post($this->apiUrl($extra), $postdata);

        if (RC_Error::is_error($response)) {
            return $response;
        }
 
        $data = RC_Http::remote_retrieve_body($response);

        return $data;
    }

    /**
     * 参数处理
     */
    protected function parameterBuild()
    {
        $s = $sep = '';
        foreach($this->args as $k => $v) {
            $k = urlencode($k);
            if(is_array($v)) {
                $s2 = $sep2 = '';
                foreach($v as $k2 => $v2) {
                    $k2 = urlencode($k2);
                    $s2 .= "$sep2{$k}[$k2]=" . urlencode(Ucenter::stripslashes($v2));
                    $sep2 = '&';
                }
                $s .= $sep.$s2;
            } else {
                $s .= "$sep$k=" . urlencode(Ucenter::stripslashes($v));
            }
            $sep = '&';
        }

        $this->args = $s;
        return $s;
    }

    /**
     * 组装API请求地址
     *
     * @param null $extra
     * @return string
     */
    protected function apiUrl($extra = null)
    {
        $url = $this->getUcApi() . '/index.php?' . $this->apiRequestData($extra);
        return $url;
    }

    /**
     * API请求参数
     *
     * @param $data
     * @return string
     */
    protected function apiInput($data)
    {
        $newdata = [];
        if (is_array($data)) {
            $newdata = $data;
        } else {
            parse_str($data, $newdata);
        }

        $append_data = [
            'agent' => md5($this->user_agent),
            'time' => SYS_TIME,
        ];

        $data = array_merge($newdata, $append_data);
        $build_data = http_build_query($data);

        $s = Ucenter::authcode($build_data, 'ENCODE', $this->getUcKey());
        return $s;
    }

    /**
     * API请求信息封装
     *
     * @param null $extra
     * @return string
     */
    protected function apiRequestData($extra = null)
    {
        $input = $this->apiInput($this->args);

        $data = [
            'm'         => $this->module,
            'a'         => $this->action,
            'inajax'    => 2,
            'release'   => ClientConst::UC_CLIENT_RELEASE,
            'input'     => $input,
            'appid'     => $this->getUcAppid(),
        ];

        if (is_array($extra)) {
            $data = array_merge($data, $extra);
            $extra = null;
        }

        $build_data = http_build_query($data);
        $build_data = $build_data . $extra;

        return $build_data;
    }

}