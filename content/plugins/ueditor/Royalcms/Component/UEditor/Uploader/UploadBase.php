<?php namespace Royalcms\Component\UEditor\Uploader;
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
 * Abstract Class Upload
 * 文件上传抽象类
 *
 *
 * @package Royalcms\Component\UEditor\Uploader
 */
abstract class UploadBase
{
    protected $fileField; //文件域名
    protected $file; //文件上传对象
    protected $base64; //文件上传对象
    protected $config; //配置信息
    protected $oriName; //原始文件名
    protected $fileName; //新文件名
    protected $fullName; //完整文件名,即从当前配置目录开始的URL
    protected $filePath; //完整文件名,即从当前配置目录开始的URL
    protected $fileSize; //文件大小
    protected $fileType; //文件类型
    protected $stateInfo; //上传状态信息,
    protected $stateMap; //上传状态映射表，国际化用户需考虑此处数据的国际化
    
    /**
     * 抽象方法,上传核心方法
     */
    abstract function uploadCore();

    public function __construct(array $config, $request)
    {
        $this->config = $config;
        $this->request = $request;
        $this->fileField = $this->config['fieldName'];
        if (isset($config['allowFiles'])) {
            $this->allowFiles = $config['allowFiles'];
        } else {
            $this->allowFiles = array();
        }

        $stateMap = array(
            "SUCCESS", //上传成功标记，在UEditor中内不可改变，否则flash判断会出错
            trans("UEditor::upload.upload_max_filesize"),
            trans("UEditor::upload.upload_error"),
            trans("UEditor::upload.no_file_uploaded"),
            trans("UEditor::upload.upload_file_empty"),
            "ERROR_TMP_FILE"            => trans("UEditor::upload.ERROR_TMP_FILE"),
            "ERROR_TMP_FILE_NOT_FOUND"  => trans("UEditor::upload.ERROR_TMP_FILE_NOT_FOUND"),
            "ERROR_SIZE_EXCEED"         => trans("UEditor::upload.ERROR_SIZE_EXCEED"),
            "ERROR_TYPE_NOT_ALLOWED"    => trans("UEditor::upload.ERROR_TYPE_NOT_ALLOWED"),
            "ERROR_CREATE_DIR"          => trans("UEditor::upload.ERROR_CREATE_DIR"),
            "ERROR_DIR_NOT_WRITEABLE"   => trans("UEditor::upload.ERROR_DIR_NOT_WRITEABL"),
            "ERROR_FILE_MOVE"           => trans("UEditor::upload.ERROR_FILE_MOVE"),
            "ERROR_FILE_NOT_FOUND"      => trans("UEditor::upload.ERROR_FILE_NOT_FOUND"),
            "ERROR_WRITE_CONTENT"       => trans("UEditor::upload.ERROR_WRITE_CONTENT"),
            "ERROR_UNKNOWN"             => trans("UEditor::upload.ERROR_UNKNOWN"),
            "ERROR_DEAD_LINK"           => trans("UEditor::upload.ERROR_DEAD_LINK"),
            "ERROR_HTTP_LINK"           => trans("UEditor::upload.ERROR_HTTP_LINK"),
            "ERROR_HTTP_CONTENTTYPE"    => trans("UEditor::upload.ERROR_HTTP_CONTENTTYPE"),
            "ERROR_UNKNOWN_MODE"        => trans("UEditor::upload.ERROR_UNKNOWN_MODE"),
        );
        $this->stateMap = $stateMap;

    }

    /**
     *
     *
     *
     * @return array
     */

    public function upload()
    {
        $this->uploadCore();
        return $this->getFileInfo();
    }


    /**
     * 上传错误检查
     * @param $errCode
     * @return string
     */
    protected function getStateInfo($errCode)
    {
        return !$this->stateMap[$errCode] ? $this->stateMap["ERROR_UNKNOWN"] : $this->stateMap[$errCode];
    }

    /**
     * 文件大小检测
     * @return bool
     */
    protected function  checkSize()
    {
        return $this->fileSize <= ($this->config["maxSize"]);
    }

    /**
     * 获取文件扩展名
     * @return string
     */
    protected function getFileExt()
    {
        $file_ext = $this->file->guessExtension();
        $file_ext = $file_ext == 'jpeg' ? 'jpg' : $file_ext;
        return '.' . $file_ext;
    }

    /**
     * 重命名文件
     * @return string
     */
    protected function getFullName()
    {
        //替换日期事件
        $t = time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = $this->config["pathFormat"];
        $format = str_replace("{yyyy}", $d[0], $format);
        $format = str_replace("{yy}", $d[1], $format);
        $format = str_replace("{mm}", $d[2], $format);
        $format = str_replace("{dd}", $d[3], $format);
        $format = str_replace("{hh}", $d[4], $format);
        $format = str_replace("{ii}", $d[5], $format);
        $format = str_replace("{ss}", $d[6], $format);
        $format = str_replace("{time}", $t, $format);

        //过滤文件名的非法自负,并替换文件名
        $oriName = substr($this->oriName, 0, strrpos($this->oriName, '.'));
        $oriName = preg_replace('/[\|\?\"\<\>\/\*\\\\]+/', '', $oriName);
        $format = str_replace("{filename}", $oriName, $format);

        //替换随机字符串
        $randNum = rand(1, 10000000000) . rand(1, 10000000000);
        if (preg_match('/\{rand\:([\d]*)\}/i', $format, $matches)) {
            $format = preg_replace('/\{rand\:[\d]*\}/i', substr($randNum, 0, $matches[1]), $format);
        }

        $ext = $this->getFileExt();
        return $format . $ext;
    }

    /**
     * 获取文件完整路径
     * @return string
     */
    protected function getFilePath()
    {
        $fullName = $this->fullName;

        $rootPath = \RC_Upload::upload_path();

        $fullName = ltrim($fullName, '/');

        return $rootPath . $fullName;
    }
    /**
     * 文件类型检测
     * @return bool
     */
    protected function checkType()
    {
        return in_array($this->getFileExt(), $this->config["allowFiles"]);
    }
    /**
     * 获取当前上传成功文件的各项信息
     * @return array
     */
    public function getFileInfo()
    {
        return array(
            "state"     => $this->stateInfo,
            "url"       => \RC_Upload::upload_url().'/'.$this->fullName,
            "title"     => $this->fileName,
            "original"  => $this->oriName,
            "type"      => $this->fileType,
            "size"      => $this->fileSize
        );
    }

}