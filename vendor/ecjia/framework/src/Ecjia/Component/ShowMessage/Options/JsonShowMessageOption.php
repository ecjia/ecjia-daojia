<?php


namespace Ecjia\Component\ShowMessage\Options;


use Ecjia\Component\ShowMessage\Contracts\ShowMessageOptionInterface;

class JsonShowMessageOption extends AjaxShowMessageOption implements ShowMessageOptionInterface
{

    /**
     * @var array
     */
    protected $options;

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options ?: [];
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function toArray()
    {
        $data = [
            'message' => $this->getMessage(),
            'state'   => $this->getStateFormatted(),
        ];

        $data = array_merge($data, $this->getOptions());

        return $data;
    }
}