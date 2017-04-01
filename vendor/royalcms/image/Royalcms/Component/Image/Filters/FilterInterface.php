<?php

namespace Royalcms\Component\Image\Filters;

interface FilterInterface
{
    /**
     * Applies filter to given image
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return \Royalcms\Component\Image\Image
     */
    public function applyFilter(\Royalcms\Component\Image\Image $image);
}
