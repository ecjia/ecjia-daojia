<?php


namespace Ecjia\Component\ApiTransformer;


use Ecjia\Component\ApiTransformer\Contracts\TransformerInterface;

class TransformerManager
{

    /**
     * @var array
     */
    protected $transformers = [];

    /**
     * @param $key
     * @param Transformer $transformer
     * @return $this
     */
    public function registerTransformer($key, Transformer $transformer): TransformerManager
    {
        $this->transformers[$key] = $transformer;
        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function unRegisterTransformer($key): TransformerManager
    {
        if (isset($this->transformers[$key])) {
            unset($this->transformers[$key]);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getTransformers(): array
    {
        return $this->transformers;
    }

    /**
     * @param $type
     * @return Transformer|null
     */
    public function getTransformer($type)
    {
        if (! isset($this->transformers[$type])) {
            return null;
        }

        return $this->transformers[$type];
    }

    /**
     * @param $type
     * @param $data
     *
     * @return array
     */
    public function transformerData($type, $data)
    {
        $outData = array();
        if (empty($data)) {
            return $outData;
        }

        if (is_array($data)) {
            $first = current($data);

            if ($first && is_array($first)) {
                foreach ($data as $key => $value) {
                    $outData[] = $this->transformerHandle($type, $value);
                }
                return array_filter($outData);
            }
            else {
                return $this->transformerHandle($type, $data);
            }
        }

        return $outData;
    }

    /**
     * @param $type
     * @param $value
     */
    public function transformerHandle($type, $value): array
    {
        $transformer = $this->getTransformer($type);
        if (!empty($transformer) && $transformer instanceof TransformerInterface) {
            return $transformer->transformer($value);
        }
        return [];
    }


}