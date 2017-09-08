<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//

/**
 * @brief QC类，api外部对象，调用接口全部依赖于此对象
 **/
class QQConnect
{

    private $kesArr, $APIMap;

    protected $recorder;

    public $urlUtils;

    protected $error;

    /**
     * _construct
     *
     * 构造方法
     * 
     * @access public
     * @since 5
     * @param string $access_token
     *            access_token value
     * @param string $openid
     *            openid value
     * @return Object QC
     */
    public function __construct(Recorder $recorder, UrlUtils $urlUtils, $access_token = "", $openid = "")
    {
        // parent::__construct();
        $this->recorder = $recorder;
        $this->urlUtils = $urlUtils;
        
        // 如果access_token和openid为空，则从session里去取，适用于demo展示情形
        if ($access_token === "" || $openid === "") {
            $this->keysArr = array(
                "oauth_consumer_key" => (int) $this->recorder->readInc("appid"),
                "access_token" => $this->recorder->read("access_token"),
                "openid" => $this->recorder->read("openid")
            );
        } else {
            $this->keysArr = array(
                "oauth_consumer_key" => (int) $this->recorder->readInc("appid"),
                "access_token" => $access_token,
                "openid" => $openid
            );
        }
        
        // 初始化APIMap
        /*
         * 加#表示非必须，无则不传入url(url中不会出现该参数)， "key" => "val" 表示key如果没有定义则使用默认值val 规则 array( baseUrl, argListArr, method)
         */
        $this->APIMap = array(
        
            
            /*                       qzone                    */
            "add_blog" => array(
                "https://graph.qq.com/blog/add_one_blog",
                array(
                    "title",
                    "format" => "json",
                    "content" => null
                ),
                "POST"
            ),
            "add_topic" => array(
                "https://graph.qq.com/shuoshuo/add_topic",
                array(
                    "richtype",
                    "richval",
                    "con",
                    "#lbs_nm",
                    "#lbs_x",
                    "#lbs_y",
                    "format" => "json",
                    "#third_source"
                ),
                "POST"
            ),
            "get_user_info" => array(
                "https://graph.qq.com/user/get_user_info",
                array(
                    "format" => "json"
                ),
                "GET"
            ),
            "add_one_blog" => array(
                "https://graph.qq.com/blog/add_one_blog",
                array(
                    "title",
                    "content",
                    "format" => "json"
                ),
                "GET"
            ),
            "add_album" => array(
                "https://graph.qq.com/photo/add_album",
                array(
                    "albumname",
                    "#albumdesc",
                    "#priv",
                    "format" => "json"
                ),
                "POST"
            ),
            "upload_pic" => array(
                "https://graph.qq.com/photo/upload_pic",
                array(
                    "picture",
                    "#photodesc",
                    "#title",
                    "#albumid",
                    "#mobile",
                    "#x",
                    "#y",
                    "#needfeed",
                    "#successnum",
                    "#picnum",
                    "format" => "json"
                ),
                "POST"
            ),
            "list_album" => array(
                "https://graph.qq.com/photo/list_album",
                array(
                    "format" => "json"
                )
            ),
            "add_share" => array(
                "https://graph.qq.com/share/add_share",
                array(
                    "title",
                    "url",
                    "#comment",
                    "#summary",
                    "#images",
                    "format" => "json",
                    "#type",
                    "#playurl",
                    "#nswb",
                    "site",
                    "fromurl"
                ),
                "POST"
            ),
            "check_page_fans" => array(
                "https://graph.qq.com/user/check_page_fans",
                array(
                    "page_id" => "314416946",
                    "format" => "json"
                )
            ),
            /*                    wblog                             */

            "add_t" => array(
                "https://graph.qq.com/t/add_t",
                array(
                    "format" => "json",
                    "content",
                    "#clientip",
                    "#longitude",
                    "#compatibleflag"
                ),
                "POST"
            ),
            "add_pic_t" => array(
                "https://graph.qq.com/t/add_pic_t",
                array(
                    "content",
                    "pic",
                    "format" => "json",
                    "#clientip",
                    "#longitude",
                    "#latitude",
                    "#syncflag",
                    "#compatiblefalg"
                ),
                "POST"
            ),
            "del_t" => array(
                "https://graph.qq.com/t/del_t",
                array(
                    "id",
                    "format" => "json"
                ),
                "POST"
            ),
            "get_repost_list" => array(
                "https://graph.qq.com/t/get_repost_list",
                array(
                    "flag",
                    "rootid",
                    "pageflag",
                    "pagetime",
                    "reqnum",
                    "twitterid",
                    "format" => "json"
                )
            ),
            "get_info" => array(
                "https://graph.qq.com/user/get_info",
                array(
                    "format" => "json"
                )
            ),
            "get_other_info" => array(
                "https://graph.qq.com/user/get_other_info",
                array(
                    "format" => "json",
                    "#name",
                    "fopenid"
                )
            ),
            "get_fanslist" => array(
                "https://graph.qq.com/relation/get_fanslist",
                array(
                    "format" => "json",
                    "reqnum",
                    "startindex",
                    "#mode",
                    "#install",
                    "#sex"
                )
            ),
            "get_idollist" => array(
                "https://graph.qq.com/relation/get_idollist",
                array(
                    "format" => "json",
                    "reqnum",
                    "startindex",
                    "#mode",
                    "#install"
                )
            ),
            "add_idol" => array(
                "https://graph.qq.com/relation/add_idol",
                array(
                    "format" => "json",
                    "#name-1",
                    "#fopenids-1"
                ),
                "POST"
            ),
            "del_idol" => array(
                "https://graph.qq.com/relation/del_idol",
                array(
                    "format" => "json",
                    "#name-1",
                    "#fopenid-1"
                ),
                "POST"
            ),
            /*                           pay                          */

            "get_tenpay_addr" => array(
                "https://graph.qq.com/cft_info/get_tenpay_addr",
                array(
                    "ver" => 1,
                    "limit" => 5,
                    "offset" => 0,
                    "format" => "json"
                )
            )
        );
    }
    
    // 调用相应api
    private function _applyAPI($arr, $argsList, $baseUrl, $method)
    {
        $pre = "#";
        $keysArr = $this->keysArr;
        
        $optionArgList = array(); // 一些多项选填参数必选一的情形
        foreach ($argsList as $key => $val) {
            $tmpKey = $key;
            $tmpVal = $val;
            
            if (! is_string($key)) {
                $tmpKey = $val;
                
                if (strpos($val, $pre) === 0) {
                    $tmpVal = $pre;
                    $tmpKey = substr($tmpKey, 1);
                    if (preg_match('/-(\d$)/', $tmpKey, $res)) {
                        $tmpKey = str_replace($res[0], '', $tmpKey);
                        $optionArgList[$res[1]][] = $tmpKey;
                    }
                } else {
                    $tmpVal = null;
                }
            }
            
            // -----如果没有设置相应的参数
            if (! isset($arr[$tmpKey]) || $arr[$tmpKey] === "") {
                
                if ($tmpVal == $pre) { // 则使用默认的值
                    continue;
                } else 
                    if ($tmpVal) {
                        $arr[$tmpKey] = $tmpVal;
                    } else {
                        if (value($v = $_FILES[$tmpKey])) {
                            $filename = dirname($v['tmp_name']) . "/" . $v['name'];
                            move_uploaded_file($v['tmp_name'], $filename);
                            $arr[$tmpKey] = "@$filename";
                        } else {
                            return new ecjia_error('api_call_parameter_incorrect', "未传入参数$tmpKey");
                        }
                    } 
            }
            
            $keysArr[$tmpKey] = $arr[$tmpKey];
        }
        // 检查选填参数必填一的情形
        foreach ($optionArgList as $val) {
            $n = 0;
            foreach ($val as $v) {
                if (in_array($v, array_keys($keysArr))) {
                    $n ++;
                }
            }
            
            if (! $n) {
                $str = implode(",", $val);
                return new ecjia_error('api_call_parameter_incorrect', $str . "必填一个");
            }
        }
        
        if ($method == "POST") {
            if ($baseUrl == "https://graph.qq.com/blog/add_one_blog")
                $response = $this->urlUtils->post($baseUrl, $keysArr, 1);
            else
                $response = $this->urlUtils->post($baseUrl, $keysArr, 0);
        } else 
            if ($method == "GET") {
                $response = $this->urlUtils->get($baseUrl, $keysArr);
            }
        
        return $response;
    }

    /**
     * _call
     * 魔术方法，做api调用转发
     * 
     * @param string $name
     *            调用的方法名称
     * @param array $arg
     *            参数列表数组
     * @since 5.0
     * @return array 返加调用结果数组
     */
    public function __call($name, $arg)
    {
        // 如果APIMap不存在相应的api
        if (empty($this->APIMap[$name])) {
            return new ecjia_error('api_call_name_incorrect', "不存在的API: $name");
        }
        
        // 从APIMap获取api相应参数
        $baseUrl = $this->APIMap[$name][0];
        $argsList = $this->APIMap[$name][1];
        $method = isset($this->APIMap[$name][2]) ? $this->APIMap[$name][2] : "GET";
        
        if (empty($arg)) {
            $arg[0] = null;
        }
        
        // 对于get_tenpay_addr，特殊处理，php json_decode对\xA312此类字符支持不好
        if ($name != "get_tenpay_addr") {
            $response = json_decode($this->_applyAPI($arg[0], $argsList, $baseUrl, $method));
            $responseArr = $this->objToArr($response);
        } else {
            $responseArr = $this->simple_json_parser($this->_applyAPI($arg[0], $argsList, $baseUrl, $method));
        }
        
        // 检查返回ret判断api是否成功调用
        if ($responseArr['ret'] == 0) {
            return $responseArr;
        } else {
            return new ecjia_error($response->ret, ErrorCase::showError($response->ret));
        }
    }
    
    // php 对象到数组转换
    private function objToArr($obj)
    {
        if (! is_object($obj) && ! is_array($obj)) {
            return $obj;
        }
        $arr = array();
        foreach ($obj as $k => $v) {
            $arr[$k] = $this->objToArr($v);
        }
        return $arr;
    }

    /**
     * get_access_token
     * 获得access_token
     * 
     * @param
     *            void
     * @since 5.0
     * @return string 返加access_token
     */
    public function get_access_token()
    {
        return $this->recorder->read("access_token");
    }
    
    // 简单实现json到php数组转换功能
    private function simple_json_parser($json)
    {
        $json = str_replace("{", "", str_replace("}", "", $json));
        $jsonValue = explode(",", $json);
        $arr = array();
        foreach ($jsonValue as $v) {
            $jValue = explode(":", $v);
            $arr[str_replace('"', "", $jValue[0])] = (str_replace('"', "", $jValue[1]));
        }
        return $arr;
    }
}

// end