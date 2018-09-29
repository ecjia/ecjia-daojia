<?php

namespace Royalcms\Component\Aliyun\Common\Communication;

interface ResponseParserInterface {
	public function parse(HttpResponse $response, $options);
}
