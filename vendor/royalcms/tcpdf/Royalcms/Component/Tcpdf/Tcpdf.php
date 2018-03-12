<?php

namespace Royalcms\Component\Tcpdf;

use RC_Config;

class Tcpdf
{
	protected static $format;
	
	protected $royalcms;
	
	/** @var  TCPDFHelper */
	protected $tcpdf;

	public function __construct($royalcms)
	{
		$this->royalcms = $royalcms;
		$this->reset();
	}

	public function reset()
	{
		$this->tcpdf = new TcpdfHelper(
			RC_Config::get('tcpdf::config.page_orientation', 'P'),
			RC_Config::get('tcpdf::config.page_units', 'mm'),
			static::$format ? static::$format : RC_Config::get('tcpdf::config.page_format', 'A4'),
			RC_Config::get('tcpdf::config.unicode', true),
			RC_Config::get('tcpdf::config.encoding', 'UTF-8')
		);
	}

	public static function changeFormat($format)
	{
		static::$format = $format;
	}

	public function __call($method, $args)
	{
		if (method_exists($this->tcpdf, $method)) {
			return call_user_func_array([$this->tcpdf, $method], $args);
		}
		throw new \RuntimeException(sprintf('the method %s does not exists in TCPDF', $method));
	}

	public function setHeaderCallback($headerCallback)
	{
		$this->tcpdf->setHeaderCallback($headerCallback);
	}

	public function setFooterCallback($footerCallback)
	{
		$this->tcpdf->setFooterCallback($footerCallback);
	}
}
