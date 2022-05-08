<?php

namespace Royalcms\Component\Aliyun\Common\Communication;

use Royalcms\Component\Aliyun\Common\Exceptions\ClientException;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\Common\Utilities\HttpHeaders;
use Royalcms\Component\Aliyun\Common\Models\ServiceOptions;
<<<<<<< HEAD
use Guzzle\Common\Event;
use Royalcms\Component\Aliyun\Common\Communication\ServiceClientInterface;
use Guzzle\Http\EntityBody;
use Guzzle\Http\Message\EntityEnclosingRequest;
use Guzzle\Http\ReadLimitEntityBody;

class HttpServiceClient implements ServiceClientInterface {
	/**
	 * @var \Guzzle\Http\Client.
=======
use Royalcms\Component\Aliyun\Common\Communication\ServiceClientInterface;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Stream\LimitStream;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class HttpServiceClient implements ServiceClientInterface {
	/**
	 * @var \GuzzleHttp\Client.
>>>>>>> v2-test
	 */
	protected $client;

	public function __construct($config = array()) {

        // Create internal client.
<<<<<<< HEAD
		$this->client = new \Guzzle\Http\Client(null, array(
		    'curl.options' => $config[ServiceOptions::CURL_OPTIONS],
        ));

        // Strict redirect. 
        $this->client->getConfig()->set('request.params', array(
            'redirect.strict' => true
        ));

        // Stop error dispatcher.
		$this->client->getEventDispatcher()->addListener('request.error', function(Event $event) {
			$event->stopPropagation();
		});
	}
	
=======
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
>>>>>>> v2-test
	public function sendRequest(HttpRequest $request, ExecutionContext $context) {
        $response = new HttpResponse($request);
        try {

            $coreRequest = $this->buildCoreRequest($request);
<<<<<<< HEAD
            $coreResponse = $coreRequest->send();
            $coreResponse->getBody()->rewind();

            $response->setStatusCode($coreResponse->getStatusCode());
            $response->setUri($coreRequest->getUrl());
            $response->setContent($coreResponse->getBody()->getStream());

            // Replace resource of Guzzle Stream to forbidden resource close when Stream is released.
            $fakedResource = fopen('php://memory', 'r+');
            if ($coreResponse->getBody() !== null) {
                $coreResponse
                    ->getBody()
                    ->setStream($fakedResource);
            }

            // If request has entity, replace resource of Guzzle Stream to forbidden resource close when Stream is released.
            if ($coreRequest instanceof EntityEnclosingRequest && $coreRequest->getBody() !== null) {
                $coreRequest
                    ->getBody()
                    ->setStream($fakedResource);
            }

            fclose($fakedResource);

            for ($iter = $coreResponse->getHeaders()->getIterator();
                    $iter->valid();
                    $iter->next()) {

                $header = $iter->current();
                $response->addHeader($header->getName(), (string) $header);
            }
=======
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
>>>>>>> v2-test

            $request->setResponse($response);
            return $response;
        } catch (\Exception $e) {
            $response->close();
            throw new ClientException($e->getMessage(), $e);
        }
	}
<<<<<<< HEAD
	
=======

    /**
     * @param HttpRequest $request
     * @return \GuzzleHttp\Psr7\Request
     */
>>>>>>> v2-test
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
<<<<<<< HEAD
            $entity = new ReadLimitEntityBody(EntityBody::factory($body), $contentLength,
                $request->getOffset() !== false ? $request->getOffset() : 0);
        }

        $coreRequest = $this->client->createRequest($request->getMethod(), $request->getFullUrl(), $headers, $entity);

        if ($request->getResponseBody() != null) {
            $coreRequest->setResponseBody($request->getResponseBody());
=======
            $entity = new LimitStream(Stream::factory($body), $contentLength,
                $request->getOffset() !== false ? $request->getOffset() : 0);
        }

        $coreRequest = new Request($request->getMethod(), $request->getFullUrl(), $headers, $entity);

        if ($request->getResponseBody() != null) {
            $coreRequest->withBody($request->getResponseBody());
>>>>>>> v2-test
        }

        return $coreRequest;
	}
}
