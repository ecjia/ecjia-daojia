<?php

namespace Royalcms\Component\Image\Imagick\Commands;

class InterlaceCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Toggles interlaced encoding mode
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $mode = $this->argument(0)->type('bool')->value(true);

        if ($mode) {
            $mode = \Imagick::INTERLACE_LINE;
        } else {
            $mode = \Imagick::INTERLACE_NO;
        }

        $image->getCore()->setInterlaceScheme($mode);

        return true;
    }
}
