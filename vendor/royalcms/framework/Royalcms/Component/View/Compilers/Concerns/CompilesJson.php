<?php

namespace Royalcms\Component\View\Compilers\Concerns;

trait CompilesJson
{
    /**
     * The default JSON encoding options.
     *
     * @var int
     */
    private $encodingOptions;

    /**
     * Compile the JSON statement into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileJson($expression)
    {
        /*php5.5 not defind prepotry*/
        if (is_null($this->encodingOptions)) {
            $this->encodingOptions = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;
        }

        $parts = explode(',', $this->stripParentheses($expression));

        $options = isset($parts[1]) ? trim($parts[1]) : $this->encodingOptions;

        $depth = isset($parts[2]) ? trim($parts[2]) : 512;

        return "<?php echo json_encode($parts[0], $options, $depth) ?>";
    }
}
