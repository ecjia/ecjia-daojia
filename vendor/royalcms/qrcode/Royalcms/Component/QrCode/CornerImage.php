<?php namespace Royalcms\Component\QrCode;


class CornerImage extends Image {
    
    /**
     * Holds the image resource.
     *
     * @var resource
     */
    protected $corner;
    
    /**
     * Creates a new Image object
     *
     * @param $image string An image string
     */
    
    public function __construct($image)
    {
        parent::__construct($image);
        
        $this->corner();
    }
    
    /**
     * 圆角图片
     */
    public function corner()
    {
        $cornerPath = realpath(__DIR__.'/../../../resources/corner.png');
        $this->corner = imagecreatefromstring(file_get_contents($cornerPath));
    }
    
    /*
     * Returns the width of an image
    *
    * @return int
    */
    public function getCornerWidth()
    {
        return imagesx($this->corner);
    }
    
    /*
     * Returns the height of an image
    *
    * @return int
    */
    public function getCornerHeight()
    {
        return imagesy($this->corner);
    }
    

    /**
     * Returns the image string
     *
     * @return string
     */
    public function getCornerImageResource()
    {
        return $this->corner;
    }
    
}

// end