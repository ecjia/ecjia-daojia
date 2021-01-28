<?php

namespace Royalcms\Component\Aliyun\Common\Communication;

use Royalcms\Component\Aliyun\Common\Communication\HttpServiceClient;
use Royalcms\Component\Aliyun\Common\Communication\OpenServiceClient;
use Royalcms\Component\Aliyun\Common\Models\ServiceOptions;

class ServiceClientFactory {
    public static function factory() {
        return new static();
    }

	public function createService($config) {
        // ServiceClient to send http request.
		$httpClient = new HttpServiceClient(array(
            ServiceOptions::CURL_OPTIONS => $config[ServiceOptions::CURL_OPTIONS],
        ));

        // ServiceClient to handle open service.
		$openServiceClient = new OpenServiceClient($httpClient, array(
            ServiceOptions::USER_AGENT => $config[ServiceOptions::USER_AGENT],
        ));

        $retryableClient = new RetryableServiceClient($openServiceClient, array(
            ServiceOptions::MAX_ERROR_RETRY => $config[ServiceOptions::MAX_ERROR_RETRY],
        ));

		return $retryableClient;
	}
}
