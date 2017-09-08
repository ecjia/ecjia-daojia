<?php

namespace Ecjia\App\Push;

class PushSend
{
    /**
     * 推送内容对象
     * @var PushContent
     */
    protected $pushContent;
    
    /**
     * 推送的设备token
     * @var array
     */
    protected $deviceToken = array();
    
    /**
     * 推送的客户端类型
     * @var string
     */
    protected $client;
    
    protected $appKey;
    protected $appSecret;
    
    
    protected $customFields = array();
    
    
	public function __construct($key, $secret, $debug = false) {
		$this->appKey = $key;
		$this->appSecret = $secret;
		$this->timestamp = strval(SYS_TIME);
		$this->debug = $debug;
	}
    
    
    public function setPushContent(PushContent $content)
    {
        $this->pushContent = $content;
        
        return $this;
    }
    
    
    public function getPushContent()
    {
        return $this->pushContent;
    }
    
    public function setDeviceToken($deviceToken)
    {
        $this->deviceToken = $deviceToken;
        
        return $this;
    }
    
    public function getDeviceToken()
    {
        return $this->deviceToken;
    }
    
    
    public function setClient($client)
    {
        $this->client = $client;
        
        return $this;
    }
    
    public function getClient()
    {
        return $this->client;
    }
    
    
    public function setCustomFields(array $fields) 
    {
        $this->customFields = $fields;
        
        return $this;
    }
    
    public function getCustomFields()
    {
        return $this->customFields;
    }
    
    public function send()
    {     
        $notification = with(new NotificationFactory())->notification($this->client);
        
        $notification->setAppKey($this->appKey);
        $notification->setAppSecret($this->appSecret);
        $notification->setDebug($this->debug);
        $notification->addContent($this->pushContent->getSubject(), $this->pushContent->getContent());
        $notification->addDeviceToken($this->deviceToken);
        $notification->addField($this->customFields);
        
        return $notification->sendUnicast();
    }
    
    
    public function broadcastSend()
    {
        $notification = with(new NotificationFactory())->notification($this->client);
        
        $notification->setAppKey($this->appKey);
        $notification->setAppSecret($this->appSecret);
        $notification->setDebug($this->debug);
        $notification->addContent($this->pushContent->getSubject(), $this->pushContent->getContent());
        $notification->addField($this->customFields);
        
        return $notification->sendBroadcast();
    }
    
    
}