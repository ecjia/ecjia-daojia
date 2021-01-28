<?php

namespace Royalcms\Component\Aliyun\Common\Communication;

use Royalcms\Component\Aliyun\Common\Utilities\ServiceConstants;
use Royalcms\Component\Aliyun\Common\Resources\ResourceManager;
use Royalcms\Component\Aliyun\Common\Auth\SignerInterface;

class ExecutionContext {
	/**
	 * Charset
	 * @var string
	 */
	protected $charset;
	
	/**
	 * Handlers to handle response
	 * @var array
	 */
	protected $responseHandlers;
	
	/**
	 * Signer for request
	 * @var SignerInterface
	 */
	protected $signer;
	
	/**
	 * Credentials
	 * @var array
	 */
	protected $credentials;
	
	/**
	 * Params
	 * @var array
	 */
	protected $parameters;
	
	public function __construct() {
	    $this->charset = ServiceConstants::CHARSET;
	    $this->params = array();
	}
	
	public function getCredentials() {
		return $this->credentials;
	}
	
	public function setCredentials($credentials) {
		$this->credentials = $credentials;
	}
	
	public function getCharset() {
		return $this->charset; 
	}
	
	public function setCharset($charset) {
		$this->charset = (string)$charset;
	}
	
	public function getResponseHandlers() {
		return $this->responseHandlers;
	}
	
	public function setResponseHandler(array $responseHandlers) {
		$this->responseHandlers = $responseHandlers;
	}
	
	public function getSigner() {
		return $this->signer;
	}
	
	public function setSigner(SignerInterface $signer) {
		$this->signer = $signer;
	}
	
	public function setParameter($key, $value) {
	    $this->parameters[$key] = $value;
	}
	
	public function getParameters() {
	    return $this->parameters;
	}
	
}
