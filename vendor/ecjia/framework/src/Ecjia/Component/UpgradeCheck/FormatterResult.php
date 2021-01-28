<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/21
 * Time: 16:44
 */

namespace Ecjia\Component\UpgradeCheck;


class FormatterResult
{

    /**
     * 版本号
     * @var
     */
    protected $version;

    /**
     * 构建日期
     * @var
     */
    protected $build;

    /**
     * 更新说明
     * @var
     */
    protected $readme;

    /**
     * 帮助链接
     * @var
     */
    protected $help_link;

    /**
     * 下载链接
     * @var
     */
    protected $download_link;

    /**
     * 修改文件列表
     * @var array
     */
    protected $modifyFileList = [];

    /**
     * 删除文件列表
     * @var array
     */
    protected $deleteFileList = [];

    /**
     * 新增文件列表
     * @var array
     */
    protected $newFileList = [];


    public function __construct(array $result)
    {
        $this->version = $result['version'];
        $this->build = $result['build'];
        $this->readme = $result['readme'];
        $this->help_link = $result['help_link'];
        $this->download_link = $result['download_link'];

        $this->formatterChangeList($result['changelist']);
    }

    /**
     * @param $result
     * @return array|static
     */
    protected function formatterChangeList($result)
    {
        $result = explode("\n", $result);

        $result = collect($result)->filter()->map(function($item) {
            $item = explode("\t", $item);
            if ($item[0] == 'M') {
                $this->modifyFileList[] = $item[1];
            } elseif ($item[0] == 'A') {
                $this->newFileList[] = $item[1];
            } elseif ($item[0] == 'D') {
                $this->deleteFileList[] = $item[1];
            }
            return $item;
        });

        return $result;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * @return mixed
     */
    public function getReadme()
    {
        return $this->readme;
    }

    /**
     * @return array
     */
    public function getModifyFileList()
    {
        return $this->modifyFileList;
    }

    /**
     * @return array
     */
    public function getDeleteFileList()
    {
        return $this->deleteFileList;
    }

    /**
     * @return array
     */
    public function getNewFileList()
    {
        return $this->newFileList;
    }

    /**
     * @return mixed
     */
    public function getHelpLink()
    {
        return $this->help_link;
    }

    /**
     * @return mixed
     */
    public function getDownloadLink()
    {
        return $this->download_link;
    }

}