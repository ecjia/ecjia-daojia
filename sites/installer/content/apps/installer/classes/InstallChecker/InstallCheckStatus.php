<?php


namespace Ecjia\App\Installer\InstallChecker;


class InstallCheckStatus
{
    /**
     * 第0步状态
     * @var int
     */
    const STEP0 = 0b00000000;

    /**
     * 第一步状态
     * @var int
     */
    const STEP1 = 0b00000001;

    /**
     * 第二步状态
     * @var int
     */
    const STEP2 = 0b00000010;

    /**
     * 第三步状态
     * @var int
     */
    const STEP3 = 0b00000100;

    /**
     * 第四步状态
     * @var int
     */
    const STEP4 = 0b00001000;

    /**
     * 第五步状态
     * @var int
     */
    const STEP5 = 0b00010000;

    /**
     * 第六步状态
     * @var int
     */
    const STEP6 = 0b00100000;

    /**
     * 第七步状态
     * @var int
     */
    const STEP7 = 0b01000000;

    /**
     * 第八步状态
     * @var int
     */
    const STEP8 = 0b10000000;

    protected $status;

    public function __construct($status = 0)
    {
        $this->status = $status;
    }

    /**
     * 添加已经完成的状态标记
     * @param $status
     * @return $this
     */
    public function addFinishStatus($status)
    {
        $this->status = $this->status | $status;

        return $this;
    }

    /**
     * 检测该状态是否存在
     * @param $step
     * @param $status
     * @return int
     */
    public function checkStatus($step, $status)
    {
        return $step & $status = $step;
    }

    /**
     * 获取最终的状态结果值
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    public static function make($status = 0)
    {
        return new static($status);
    }


}