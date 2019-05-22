<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-15
 * Time: 09:13
 */

namespace Royalcms\Component\Upload;

use Royalcms\Component\Support\Manager;
use Royalcms\Component\Upload\Uploader\CustomUploader;
use Royalcms\Component\Upload\Uploader\ImageUploader;
use Royalcms\Component\Upload\Uploader\NewImageUploader;
use Royalcms\Component\Upload\Uploader\NewUploader;
use Royalcms\Component\Upload\Uploader\TempImageUploader;
use Royalcms\Component\Upload\Uploader\Uploader;

class UploadManager extends Manager
{

    /**
     * 获取上传对象
     *
     * @param string $driver
     * @param array $options
     * @return \Royalcms\Component\Upload\Uploader\Uploader
     */
    public function uploader($driver, $options = array())
    {
        $uploader = $this->driver($driver);

        $uploader->setOptions($options);

        return $uploader;
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'default';
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function createImageDriver()
    {
        return $this->adapt(new ImageUploader());
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function createCustomDriver()
    {
        return $this->adapt(new CustomUploader());
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function createNewDriver()
    {
        return $this->adapt(new NewUploader());
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function createNewimageDriver()
    {
        return $this->adapt(new NewImageUploader());
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function createTempimageDriver()
    {
        return $this->adapt(new TempImageUploader());
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function createDefaultDriver()
    {
        return $this->adapt(new Uploader());
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function createFileDriver()
    {
        return $this->createDefaultDriver();
    }

    /**
     * @param $uploader
     * @return mixed
     */
    protected function adapt($uploader)
    {

        $uploader->add_sub_dirname_callback(array( 'Royalcms\Component\Upload\Facades\Upload', 'upload_sub_dir' ));
        $uploader->add_filename_callback(array( 'Royalcms\Component\Upload\Facades\Upload', 'random_filename' ));

        return $uploader;
    }

}