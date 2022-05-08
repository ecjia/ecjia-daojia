<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
<<<<<<< HEAD
 * Attachment class for attaching files to a {@link Swift_Mime_Message}.
=======
 * Attachment class for attaching files to a {@link Swift_Mime_SimpleMessage}.
>>>>>>> v2-test
 *
 * @author Chris Corbyn
 */
class Swift_Attachment extends Swift_Mime_Attachment
{
    /**
     * Create a new Attachment.
     *
     * Details may be optionally provided to the constructor.
     *
     * @param string|Swift_OutputByteStream $data
     * @param string                        $filename
     * @param string                        $contentType
     */
    public function __construct($data = null, $filename = null, $contentType = null)
    {
<<<<<<< HEAD
        call_user_func_array(
            array($this, 'Swift_Mime_Attachment::__construct'),
=======
        \call_user_func_array(
            [$this, 'Swift_Mime_Attachment::__construct'],
>>>>>>> v2-test
            Swift_DependencyContainer::getInstance()
                ->createDependenciesFor('mime.attachment')
            );

<<<<<<< HEAD
        $this->setBody($data);
        $this->setFilename($filename);
        if ($contentType) {
            $this->setContentType($contentType);
        }
    }

    /**
     * Create a new Attachment.
     *
     * @param string|Swift_OutputByteStream $data
     * @param string                        $filename
     * @param string                        $contentType
     *
     * @return Swift_Mime_Attachment
     */
    public static function newInstance($data = null, $filename = null, $contentType = null)
    {
        return new self($data, $filename, $contentType);
=======
        $this->setBody($data, $contentType);
        $this->setFilename($filename);
>>>>>>> v2-test
    }

    /**
     * Create a new Attachment from a filesystem path.
     *
     * @param string $path
     * @param string $contentType optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_Attachment
     */
    public static function fromPath($path, $contentType = null)
    {
        return self::newInstance()->setFile(
            new Swift_ByteStream_FileByteStream($path),
            $contentType
            );
=======
     * @return self
     */
    public static function fromPath($path, $contentType = null)
    {
        return (new self())->setFile(
            new Swift_ByteStream_FileByteStream($path),
            $contentType
        );
>>>>>>> v2-test
    }
}
