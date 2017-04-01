<?php

namespace Royalcms\Component\Image\Commands;

use Closure;

class PolygonCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Draw a polygon on given image
     *
     * @param  \Royalcms\Component\Image\image $image
     * @return boolean
     */
    public function execute($image)
    {
        $points = $this->argument(0)->type('array')->required()->value();
        $callback = $this->argument(1)->type('closure')->value();

        $vertices_count = count($points);

        // check if number if coordinates is even
        if ($vertices_count % 2 !== 0) {
            throw new \Royalcms\Component\Image\Exception\InvalidArgumentException(
                "The number of given polygon vertices must be even."
            );
        }

        if ($vertices_count < 6) {
            throw new \Royalcms\Component\Image\Exception\InvalidArgumentException(
                "You must have at least 3 points in your array."
            );
        }
        
        $polygon_classname = sprintf('\Royalcms\Component\Image\%s\Shapes\PolygonShape',
            $image->getDriver()->getDriverName());

        $polygon = new $polygon_classname($points);
        
        if ($callback instanceof Closure) {
            $callback($polygon);
        }

        $polygon->applyToImage($image);

        return true;
    }
}
