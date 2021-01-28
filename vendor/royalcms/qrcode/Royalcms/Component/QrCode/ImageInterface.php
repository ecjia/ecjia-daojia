<?php namespace Royalcms\Component\QrCode;
/**
 * Simple QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Royalcms.
 *
 */

interface ImageInterface {

    /**
     * Creates a new Image object
     *
     * @param $image string An image string
     */
    public function __construct($image);

    /*
     * Returns the width of an image
     *
     * @return int
     */
    public function getWidth();

    /*
     * Returns the height of an image
     *
     * @return int
     */
    public function getHeight();

    /**
     * Returns the image string
     *
     * @return string
     */
    public function getImageResource();
}