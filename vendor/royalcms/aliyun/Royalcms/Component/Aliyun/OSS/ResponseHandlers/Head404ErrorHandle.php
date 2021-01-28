<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-13
 * Time: 11:04
 */

namespace Royalcms\Component\Aliyun\OSS\ResponseHandlers;

use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\OSS\Models\OSSErrorCode;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSExceptionFactory;
use Royalcms\Component\Aliyun\Common\Resources\ResourceManager;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSHeaders;

class Head404ErrorHandle extends OSSErrorResponseHandler
{

    public function handle(HttpResponse $response) {
        if ($response->getStatusCode() == 404) {
            $response->close();
            throw OSSExceptionFactory::factory()->create(OSSErrorCode::NO_SUCH_KEY,
                ResourceManager::getInstance()->getString('NoSuchKey'),
                $response->getHeader(OSSHeaders::OSS_HEADER_REQUEST_ID));
        }
    }
}