<?php


namespace Ecjia\Component\HealthCheck\Contracts;


interface CheckerInterface
{

    /**
     * @return string
     */
    public function getOk();

    /**
     * @return string
     */
    public function getCancel();

    /**
     * @return string
     */
    public function getInfo();

}