<?php
namespace Ecjia\Component\EcjiaCloud\Services;

use Ecjia\Component\EcjiaCloud\EcjiaCloud;
use Ecjia\Component\EcjiaCloud\ServerHost;

class CloudExpressService
{
    /**
     * @var EcjiaCloud
     */
    private $cloud;

    /**
     * @var string
     */
    private $api = 'express/track';

    /**
     * @var string
     */
    private $app_key;

    /**
     * @var string
     */
    private $app_secret;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $order;

    /**
     * CloudExpressService constructor.
     * @param string $app_key
     * @param string $app_secret
     */
    public function __construct(?string $app_key = null, ?string $app_secret = null)
    {
        $this->cloud = EcjiaCloud::instance()->setServerHost(ServerHost::CLOUD_EXPRESS_HOST)->api($this->api);
        $this->app_key    = $app_key;
        $this->app_secret = $app_secret;
    }


    /**
     * @return string
     */
    public function getAppKey(): string
    {
        return $this->app_key;
    }

    /**
     * @param string $app_key
     * @return CloudExpressService
     */
    public function setAppKey(string $app_key): CloudExpressService
    {
        $this->app_key = $app_key;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppSecret(): string
    {
        return $this->app_secret;
    }

    /**
     * @param string $app_secret
     * @return CloudExpressService
     */
    public function setAppSecret(string $app_secret): CloudExpressService
    {
        $this->app_secret = $app_secret;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     * @return CloudExpressService
     */
    public function setCompany(string $company): CloudExpressService
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return CloudExpressService
     */
    public function setNumber(string $number): CloudExpressService
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @param string $order
     * @return CloudExpressService
     */
    public function setOrder(string $order): CloudExpressService
    {
        $this->order = $order;
        return $this;
    }

    /**
     * 获取请求数据
     * @return array
     */
    public function getRequestData()
    {
        return [
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret,
            'company' => $this->company,
            'number' => $this->number,
            'order' => $this->order,
        ];
    }

    /**
     * @return array|\ecjia_error
     */
    public function request()
    {
        $cloud = $this->cloud->data($params)->run();

        if (is_ecjia_error($cloud->getError())) {
            return $cloud->getError();
        }

        return $cloud->getReturnData();
    }

}