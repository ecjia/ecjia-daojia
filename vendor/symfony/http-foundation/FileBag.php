<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * FileBag is a container for uploaded files.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Bulat Shakirzyanov <mallluhuct@gmail.com>
 */
class FileBag extends ParameterBag
{
<<<<<<< HEAD
    private static $fileKeys = array('error', 'name', 'size', 'tmp_name', 'type');

    /**
     * Constructor.
     *
     * @param array $parameters An array of HTTP files
     */
    public function __construct(array $parameters = array())
=======
    private const FILE_KEYS = ['error', 'name', 'size', 'tmp_name', 'type'];

    /**
     * @param array|UploadedFile[] $parameters An array of HTTP files
     */
    public function __construct(array $parameters = [])
>>>>>>> v2-test
    {
        $this->replace($parameters);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function replace(array $files = array())
    {
        $this->parameters = array();
=======
    public function replace(array $files = [])
    {
        $this->parameters = [];
>>>>>>> v2-test
        $this->add($files);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function set($key, $value)
    {
        if (!is_array($value) && !$value instanceof UploadedFile) {
=======
    public function set(string $key, $value)
    {
        if (!\is_array($value) && !$value instanceof UploadedFile) {
>>>>>>> v2-test
            throw new \InvalidArgumentException('An uploaded file must be an array or an instance of UploadedFile.');
        }

        parent::set($key, $this->convertFileInformation($value));
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function add(array $files = array())
=======
    public function add(array $files = [])
>>>>>>> v2-test
    {
        foreach ($files as $key => $file) {
            $this->set($key, $file);
        }
    }

    /**
     * Converts uploaded files to UploadedFile instances.
     *
     * @param array|UploadedFile $file A (multi-dimensional) array of uploaded file information
     *
<<<<<<< HEAD
     * @return array A (multi-dimensional) array of UploadedFile instances
=======
     * @return UploadedFile[]|UploadedFile|null A (multi-dimensional) array of UploadedFile instances
>>>>>>> v2-test
     */
    protected function convertFileInformation($file)
    {
        if ($file instanceof UploadedFile) {
            return $file;
        }

<<<<<<< HEAD
        $file = $this->fixPhpFilesArray($file);
        if (is_array($file)) {
            $keys = array_keys($file);
            sort($keys);

            if ($keys == self::$fileKeys) {
                if (UPLOAD_ERR_NO_FILE == $file['error']) {
                    $file = null;
                } else {
                    $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type'], $file['size'], $file['error']);
                }
            } else {
                $file = array_map(array($this, 'convertFileInformation'), $file);
=======
        if (\is_array($file)) {
            $file = $this->fixPhpFilesArray($file);
            $keys = array_keys($file);
            sort($keys);

            if (self::FILE_KEYS == $keys) {
                if (\UPLOAD_ERR_NO_FILE == $file['error']) {
                    $file = null;
                } else {
                    $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type'], $file['error'], false);
                }
            } else {
                $file = array_map([$this, 'convertFileInformation'], $file);
                if (array_keys($keys) === $keys) {
                    $file = array_filter($file);
                }
>>>>>>> v2-test
            }
        }

        return $file;
    }

    /**
     * Fixes a malformed PHP $_FILES array.
     *
     * PHP has a bug that the format of the $_FILES array differs, depending on
     * whether the uploaded file fields had normal field names or array-like
     * field names ("normal" vs. "parent[child]").
     *
     * This method fixes the array to look like the "normal" $_FILES array.
     *
     * It's safe to pass an already converted array, in which case this method
     * just returns the original array unmodified.
     *
     * @param array $data
     *
     * @return array
     */
    protected function fixPhpFilesArray($data)
    {
<<<<<<< HEAD
        if (!is_array($data)) {
            return $data;
        }

        $keys = array_keys($data);
        sort($keys);

        if (self::$fileKeys != $keys || !isset($data['name']) || !is_array($data['name'])) {
=======
        $keys = array_keys($data);
        sort($keys);

        if (self::FILE_KEYS != $keys || !isset($data['name']) || !\is_array($data['name'])) {
>>>>>>> v2-test
            return $data;
        }

        $files = $data;
<<<<<<< HEAD
        foreach (self::$fileKeys as $k) {
=======
        foreach (self::FILE_KEYS as $k) {
>>>>>>> v2-test
            unset($files[$k]);
        }

        foreach ($data['name'] as $key => $name) {
<<<<<<< HEAD
            $files[$key] = $this->fixPhpFilesArray(array(
=======
            $files[$key] = $this->fixPhpFilesArray([
>>>>>>> v2-test
                'error' => $data['error'][$key],
                'name' => $name,
                'type' => $data['type'][$key],
                'tmp_name' => $data['tmp_name'][$key],
                'size' => $data['size'][$key],
<<<<<<< HEAD
            ));
=======
            ]);
>>>>>>> v2-test
        }

        return $files;
    }
}
