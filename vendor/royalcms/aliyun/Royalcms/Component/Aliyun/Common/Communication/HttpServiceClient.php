<?php

namespace Royalcms\Component\Aliyun\Common\Communication;

use Royalcms\Component\Aliyun\Common\Exceptions\ClientException;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\Common\Utilities\HttpHeaders;
use Royalcms\Component\Aliyun\Common\Models\ServiceOptions;
use Royalcms\Component\Aliyun\Common\Communication\ServiceClientInterface;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Stream\LimitStream;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class HttpServiceClient implements ServiceClientInterface {
	/**
	 * @var \GuzzleHttp\Client.
	 */
	protected $client;

	public function __construct($config = array()) {

        // Create internal client.
		$this->client = new \GuzzleHttp\Client([
            'curl.options' => $config[ServiceOptions::CURL_OPTIONS],
            'allow_redirects.strict' => true, // Strict redirect.
            'stream' => true
        ]);

	}

    /**
     * Send Request
     * @param HttpRequest $request
     * @param ExecutionContext $context
     * @return HttpResponse
     */
	public function sendRequest(HttpRequest $request, ExecutionContext $context) {
        $response = new HttpResponse($request);
        try {

            $coreRequest = $this->buildCoreRequest($request);
            $coreResponse = $this->client->send($coreRequest, ['timeout' => 5]);
//            $coreResponse->getBody()->rewind();
            $coreResponse->getBody();

            $response->setStatusCode($coreResponse->getStatusCode());
            $response->setUri($coreRequest->getUri());
            $response->setContent($coreResponse->getBody()->getContents());

//            // Replace resource of Guzzle Stream to forbidden resource close when Stream is released.
//            $fakedResource = fopen('php://memory', 'r+');
////            if ($coreResponse->getBody() !== null) {
////                $coreResponse
////                    ->getBody()
////                    ->write($fakedResource);
////            }
//
//            // If request has entity, replace resource of Guzzle Stream to forbidden resource close when Stream is released.
//            if ($coreRequest instanceof RequestInterface && $coreRequest->getBody() !== null) {
//                $coreRequest
//                    ->getBody()
//                    ->write($fakedResource);
//            }
//
//            fclose($fakedResource);

//            for ($iter = $coreResponse->getHeaders()->getIterator();
//                    $iter->valid();
//                    $iter->next()) {
//
//                $header = $iter->current();
//                $response->addHeader($header->getName(), (string) $header);
//            }

            $request->setResponse($response);
            return $response;
        } catch (\Exception $e) {
            $response->close();
            throw new ClientException($e->getMessage(), $e);
        }
	}

    /**
     * @param HttpRequest $request
     * @return \GuzzleHttp\Psr7\Request
     */
	protected function buildCoreRequest(HttpRequest $request) {

        $headers = $request->getHeaders();
        $contentLength = 0;
        if (!$request->isParameterInUrl()) {
            $body = $request->getParameterString();
            $contentLength = strlen($body);
        } else {
            $body = $request->getContent();
            if ($body !== null) {
                AssertUtils::assertSet(HttpHeaders::CONTENT_LENGTH, $headers);
                $contentLength = (int) $headers[HttpHeaders::CONTENT_LENGTH];
            }
        }

        $entity = null;
        $headers[HttpHeaders::CONTENT_LENGTH] = (string) $contentLength;
        if ($body !== null) {
            $entity = new LimitStream(Stream::factory($body), $contentLength,
                $request->getOffset() !== false ? $request->getOffset() : 0);
        }

        $coreRequest = new Request($request->getMethod(), $request->getFullUrl(), $headers, $entity);

        if ($request->getResponseBody() != null) {
            $coreRequest->withBody($request->getResponseBody());
        }

        return $coreRequest;
	}
}
