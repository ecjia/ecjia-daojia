<?php

namespace Royalcms\Component\Aliyun\Common\Communication;

use Royalcms\Component\Aliyun\Common\Communication\ServiceClientInterface;
use Royalcms\Component\Aliyun\Common\Utilities\HttpHeaders;
use Royalcms\Component\Aliyun\Common\Models\ServiceOptions;

class OpenServiceClient implements ServiceClientInterface  {
    
    /**
     * The client actually send http request.
     * @var ServiceClientInterface
     */
    protected $client;

    protected $userAgent = '';
    
    public function __construct(ServiceClientInterface $client, array $config = array()) {
        $this->client = $client;

        if (isset($config[ServiceOptions::USER_AGENT])) {
            $this->userAgent = $config[ServiceOptions::USER_AGENT];
        }
    }
    
    public function sendRequest(HttpRequest $request, ExecutionContext $context) {
        $request->addHeader(HttpHeaders::USER_AGENT, $this->userAgent);
        $context->getSigner()->sign($request, $context->getCredentials());
        $response =  $this->client->sendRequest($request, $context);
        
        foreach ($context->getResponseHandlers() as $handler) {
            $handler->handle($response);
        }
        
        return $response;
    }

}
