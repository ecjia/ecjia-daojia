<?php

namespace Royalcms\Component\Image\Gd\Commands;

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

        imageinterlace($image->getCore(), $mode);

        return true;
    }
}
