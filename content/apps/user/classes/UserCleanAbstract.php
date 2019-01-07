<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 12:05
 */

namespace Ecjia\App\User;


abstract class UserCleanAbstract
{

    protected $user_id;

    /**
     * 代号标识
     * @var string
     */
    protected $code;

    /**
     * 名称
     * @var string
     */
    protected $name;

    /**
     * 描述
     * @var string
     */
    protected $description;

    /**
     * 排序
     * @var int
     */
    protected $sort = 0;


    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }


    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * 数据描述及输出显示内容
     */
    abstract public function handlePrintData();

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    abstract public function handleCount();


    /**
     * 执行清除操作
     *
     * @return mixed
     */
    abstract public function handleClean();

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    abstract public function handleAdminLog();

}