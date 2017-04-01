<?php namespace Royalcms\Component\QrCode;
/**
 * Simple QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Royalcms.
 *
 */

class ImageMerge implements ImageMergeInterface {

    /**
     * Holds the QrCode image
     *
     * @var Image $sourceImage
     */
    protected $sourceImage;

    /**
     * Holds the merging image
     *
     * @var Image $mergeImage
     */
    protected $mergeImage;

    /**
     * The height of the source image
     *
     * @var int
     */
    protected $sourceImageHeight;

    /**
     * The width of the source image
     *
     * @var int
     */
    protected $sourceImageWidth;

    /**
     * The height of the merge image
     *
     * @var int
     */
    protected $mergeImageHeight;

    /**
     * The width of the merge image
     *
     * @var int
     */
    protected $mergeImageWidth;

    /**
     * The height of the merge image after it is merged
     *
     * @var int
     */
    protected $postMergeImageHeight;

    /**
     * The width of the merge image after it is merged
     *
     * @var int
     */
    protected $postMergeImageWidth;

    /**
     * The position that the merge image is placed on top of the source image
     *
     * @var int
     */
    protected $centerY;

    /**
     * The position that the merge image is placed on top of the source image
     *
     * @var int
     */
    protected $centerX;

    /**
     * Creates a new ImageMerge object. 
     *
     * @param $sourceImage Image The image that will be merged over.
     * @param $mergeImage Image The image that will be used to merge with $sourceImage
     */
    function __construct(Image $sourceImage, Image $mergeImage)
    {
        $this->sourceImage = $sourceImage;
        $this->mergeImage = $mergeImage;
    }

    /**
     * Returns an QrCode that has been merge with another image.
     * This is usually used with logos to imprint a logo into a QrCode
     *
     * @return str
     */
    public function merge($percentage)
    {
        $this->setProperties($percentage);

        $this->createConrnerQr();
        
        $this->createLogoQr();

        /**
         * @todo 不能生成圆角Logo
        imagecopyresized(
            $this->sourceImage->getImageResource(),
            $this->mergeImage->getImageResource(),
            $this->centerX,
            $this->centerY,
            0,
            0,
            $this->postMergeImageWidth,
            $this->postMergeImageHeight,
            $this->mergeImageWidth,
            $this->mergeImageHeight
        );
        */

        return $this->createImage();
    }
    
    
    public function createLogoQr()
    {
        //计算logo图片的宽高及相对于二维码的摆放位置,将logo拷贝到二维码中央
        $logo_qr_height = $logo_qr_width = $this->sourceImageWidth/5 - 8;
        $from_width = ($this->sourceImageWidth - $logo_qr_width)/2;
        imagecopyresampled(
        $this->sourceImage->getImageResource(),
        $this->mergeImage->getImageResource(),
        $from_width,
        $from_width,
        0,
        0,
        $logo_qr_width,
        $logo_qr_height,
        $this->mergeImageWidth,
        $this->mergeImageHeight
        );
    }
    
    
    public function createConrnerQr()
    {
        //计算圆角图片的宽高及相对于二维码的摆放位置,将圆角图片拷贝到二维码中央
        $corner_qr_height = $corner_qr_width = $this->sourceImageWidth/5;
        $from_width = ($this->sourceImageWidth - $corner_qr_width)/2;
        
        imagecopyresampled(
            $this->sourceImage->getImageResource(), 
            $this->mergeImage->getCornerImageResource(), 
            $from_width, 
            $from_width, 
            0, 
            0, 
            $corner_qr_width, 
            $corner_qr_height, 
            $this->mergeImage->getCornerWidth(), 
            $this->mergeImage->getCornerHeight()
        );
        
    }

    /**
     * Creates a PNG Image
     *
     * @return string
     */
    protected function createImage()
    {
        ob_start();
        imagepng($this->sourceImage->getImageResource());
        return ob_get_clean();
    }

    /**
     * Sets the objects properties
     *
     * @param $percentage float The percentage that the merge image should take up.
     */
    protected function setProperties($percentage)
    {
        if ($percentage > 1)  throw new \InvalidArgumentException('$percentage must be less than 1');

        $this->sourceImageHeight = $this->sourceImage->getHeight();
        $this->sourceImageWidth = $this->sourceImage->getWidth();

        $this->mergeImageHeight = $this->mergeImage->getHeight();
        $this->mergeImageWidth = $this->mergeImage->getWidth();

        $this->calculateOverlap($percentage);
        $this->calculateCenter();
    }

    /**
     * Calculates the center of the source Image using the Merge image.
     *
     * @return void
     */
    private function calculateCenter()
    {
        $this->centerY = ($this->sourceImageHeight / 2) - ($this->postMergeImageHeight / 2);
        $this->centerX = ($this->sourceImageWidth / 2) - ($this->postMergeImageHeight / 2);
    }

    /**
     * Calculates the width of the merge image being placed on the source image.
     *
     * @param float $percentage
     * @return void
     */
    private function calculateOverlap($percentage)
    {
        $this->postMergeImageHeight = $this->sourceImageHeight * $percentage;
        $this->postMergeImageWidth = $this->sourceImageWidth * $percentage;
    }
}
