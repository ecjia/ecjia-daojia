<?php

namespace Royalcms\Component\XmlResponse;

use Royalcms\Component\Support\Facades\Response;
use Royalcms\Component\XmlResponse\Exception\XmlResponseException;

/**
 * Class XmlResponse
 * @package XmlResponse
 */
class XmlResponse
{
    /**
     * @var
     */
    private $caseSensitive;

    /**
     * @var
     */
    private $template;

    /**
     * XmlResponse constructor.
     */
    public function __construct()
    {
        $config = royalcms('config');

        $this->caseSensitive = $config->get('xml-response::config.caseSensitive');
        $this->template = $config->get('xml-response::config.template');
    }

    /**
     * @return mixed
     */
    private function header()
    {
        return array(
            'Content-Type' => 'application/xml'
        );
    }

    /**
     * @param $value
     * @return bool
     */
    private function isType($value)
    {
        return in_array($value, array(
            'model',
            'collection',
            'array',
            'object'
        ));
    }

    /**
     * @param $value
     * @return mixed
     */
    private function caseSensitive($value)
    {
        if ($this->caseSensitive) {
            $value = explode('_', $value);
            $value = lcfirst(join('', array_map("ucfirst", $value)));
        }
        return $value;
    }


    /**
     * @param array $attribute
     * @param \SimpleXMLElement $xml
     * @throws XmlResponseException
     */
    private function addAttribute($attribute = array(), \SimpleXMLElement $xml)
    {
        if (!is_array($attribute)){
            throw new XmlResponseException('Attribute in the header is not an array.');
        }

        foreach ($attribute as $key => $value){
            $xml->addAttribute($key, $value);
        }
    }

    /**
     * @param $array
     * @param bool $xml
     * @param array $headerAttribute
     * @return mixed
     * @throws XmlResponseException
     */
    function array2xml($array, $xml = false, $headerAttribute = array())
    {
        if (!$this->isType(gettype($array))){
            throw new XmlResponseException('It is not possible to convert the data');
        }

        if (!is_array($array)){
            $array = $array->toArray();
        }

        if($xml === false){
            $xml = new \SimpleXMLElement($this->template);
        }

        $this->addAttribute($headerAttribute, $xml);

        foreach($array as $key => $value){
            if(is_array($value)){
                if (is_numeric($key)){
                    $this->array2xml($value, $xml->addChild($this->caseSensitive('row_' . $key)));
                } else {
                    $this->array2xml($value, $xml->addChild($this->caseSensitive($key)));
                }
            } else{
                $xml->addChild($this->caseSensitive($key), htmlspecialchars($value));
            }
        }

        return Response::make($xml->asXML(), 200, $this->header());
    }
}
