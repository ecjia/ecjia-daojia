<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DomCrawler\Field;

/**
 * FileFormField represents a file form field (an HTML file input tag).
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class FileFormField extends FormField
{
    /**
     * Sets the PHP error code associated with the field.
     *
     * @param int $error The error code (one of UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE, UPLOAD_ERR_PARTIAL, UPLOAD_ERR_NO_FILE, UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE, or UPLOAD_ERR_EXTENSION)
     *
     * @throws \InvalidArgumentException When error code doesn't exist
     */
<<<<<<< HEAD
    public function setErrorCode($error)
    {
        $codes = array(UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE, UPLOAD_ERR_PARTIAL, UPLOAD_ERR_NO_FILE, UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE, UPLOAD_ERR_EXTENSION);
        if (!in_array($error, $codes)) {
            throw new \InvalidArgumentException(sprintf('The error code %s is not valid.', $error));
        }

        $this->value = array('name' => '', 'type' => '', 'tmp_name' => '', 'error' => $error, 'size' => 0);
=======
    public function setErrorCode(int $error)
    {
        $codes = [\UPLOAD_ERR_INI_SIZE, \UPLOAD_ERR_FORM_SIZE, \UPLOAD_ERR_PARTIAL, \UPLOAD_ERR_NO_FILE, \UPLOAD_ERR_NO_TMP_DIR, \UPLOAD_ERR_CANT_WRITE, \UPLOAD_ERR_EXTENSION];
        if (!\in_array($error, $codes)) {
            throw new \InvalidArgumentException(sprintf('The error code "%s" is not valid.', $error));
        }

        $this->value = ['name' => '', 'type' => '', 'tmp_name' => '', 'error' => $error, 'size' => 0];
>>>>>>> v2-test
    }

    /**
     * Sets the value of the field.
<<<<<<< HEAD
     *
     * @param string $value The value of the field
     */
    public function upload($value)
=======
     */
    public function upload(?string $value)
>>>>>>> v2-test
    {
        $this->setValue($value);
    }

    /**
     * Sets the value of the field.
<<<<<<< HEAD
     *
     * @param string $value The value of the field
     */
    public function setValue($value)
    {
        if (null !== $value && is_readable($value)) {
            $error = UPLOAD_ERR_OK;
=======
     */
    public function setValue(?string $value)
    {
        if (null !== $value && is_readable($value)) {
            $error = \UPLOAD_ERR_OK;
>>>>>>> v2-test
            $size = filesize($value);
            $info = pathinfo($value);
            $name = $info['basename'];

            // copy to a tmp location
<<<<<<< HEAD
            $tmp = sys_get_temp_dir().'/'.sha1(uniqid(mt_rand(), true));
            if (array_key_exists('extension', $info)) {
=======
            $tmp = sys_get_temp_dir().'/'.strtr(substr(base64_encode(hash('sha256', uniqid(mt_rand(), true), true)), 0, 7), '/', '_');
            if (\array_key_exists('extension', $info)) {
>>>>>>> v2-test
                $tmp .= '.'.$info['extension'];
            }
            if (is_file($tmp)) {
                unlink($tmp);
            }
            copy($value, $tmp);
            $value = $tmp;
        } else {
<<<<<<< HEAD
            $error = UPLOAD_ERR_NO_FILE;
=======
            $error = \UPLOAD_ERR_NO_FILE;
>>>>>>> v2-test
            $size = 0;
            $name = '';
            $value = '';
        }

<<<<<<< HEAD
        $this->value = array('name' => $name, 'type' => '', 'tmp_name' => $value, 'error' => $error, 'size' => $size);
=======
        $this->value = ['name' => $name, 'type' => '', 'tmp_name' => $value, 'error' => $error, 'size' => $size];
>>>>>>> v2-test
    }

    /**
     * Sets path to the file as string for simulating HTTP request.
<<<<<<< HEAD
     *
     * @param string $path The path to the file
     */
    public function setFilePath($path)
=======
     */
    public function setFilePath(string $path)
>>>>>>> v2-test
    {
        parent::setValue($path);
    }

    /**
     * Initializes the form field.
     *
     * @throws \LogicException When node type is incorrect
     */
    protected function initialize()
    {
        if ('input' !== $this->node->nodeName) {
            throw new \LogicException(sprintf('A FileFormField can only be created from an input tag (%s given).', $this->node->nodeName));
        }

        if ('file' !== strtolower($this->node->getAttribute('type'))) {
<<<<<<< HEAD
            throw new \LogicException(sprintf('A FileFormField can only be created from an input tag with a type of file (given type is %s).', $this->node->getAttribute('type')));
=======
            throw new \LogicException(sprintf('A FileFormField can only be created from an input tag with a type of file (given type is "%s").', $this->node->getAttribute('type')));
>>>>>>> v2-test
        }

        $this->setValue(null);
    }
}
