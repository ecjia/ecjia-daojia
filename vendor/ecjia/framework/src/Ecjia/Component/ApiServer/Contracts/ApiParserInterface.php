<?php


namespace Ecjia\Component\ApiServer\Contracts;


interface ApiParserInterface
{

    /**
     * 获取完整的类名
     * @return string
     */
    public function getFullClassName();

    /**
     * 获取完整的文件名
     * @return string
     */
    public function getFullFileName();

    /**
     * 获取API处理对象
     * @return mixed
     */
    public function getApihandler();

}