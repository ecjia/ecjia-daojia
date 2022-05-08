<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Loader;

use Symfony\Component\Translation\Exception\InvalidResourceException;
<<<<<<< HEAD
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Config\Resource\FileResource;
=======
>>>>>>> v2-test

/**
 * JsonFileLoader loads translations from an json file.
 *
 * @author singles
 */
<<<<<<< HEAD
class JsonFileLoader extends ArrayLoader
=======
class JsonFileLoader extends FileLoader
>>>>>>> v2-test
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function load($resource, $locale, $domain = 'messages')
    {
        if (!stream_is_local($resource)) {
            throw new InvalidResourceException(sprintf('This is not a local file "%s".', $resource));
        }

        if (!file_exists($resource)) {
            throw new NotFoundResourceException(sprintf('File "%s" not found.', $resource));
        }

        $messages = array();
=======
    protected function loadResource($resource)
    {
        $messages = [];
>>>>>>> v2-test
        if ($data = file_get_contents($resource)) {
            $messages = json_decode($data, true);

            if (0 < $errorCode = json_last_error()) {
<<<<<<< HEAD
                throw new InvalidResourceException(sprintf('Error parsing JSON - %s', $this->getJSONErrorMessage($errorCode)));
            }
        }

        if (null === $messages) {
            $messages = array();
        }

        $catalogue = parent::load($messages, $locale, $domain);
        $catalogue->addResource(new FileResource($resource));

        return $catalogue;
=======
                throw new InvalidResourceException('Error parsing JSON: '.$this->getJSONErrorMessage($errorCode));
            }
        }

        return $messages;
>>>>>>> v2-test
    }

    /**
     * Translates JSON_ERROR_* constant into meaningful message.
<<<<<<< HEAD
     *
     * @param int $errorCode Error code returned by json_last_error() call
     *
     * @return string Message string
     */
    private function getJSONErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded';
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch';
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON';
            case JSON_ERROR_UTF8:
=======
     */
    private function getJSONErrorMessage(int $errorCode): string
    {
        switch ($errorCode) {
            case \JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded';
            case \JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch';
            case \JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case \JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON';
            case \JSON_ERROR_UTF8:
>>>>>>> v2-test
                return 'Malformed UTF-8 characters, possibly incorrectly encoded';
            default:
                return 'Unknown error';
        }
    }
}
