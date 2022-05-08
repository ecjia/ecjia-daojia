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

<<<<<<< HEAD
use Symfony\Component\Translation\Exception\InvalidResourceException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Config\Resource\FileResource;

=======
>>>>>>> v2-test
/**
 * PhpFileLoader loads translations from PHP files returning an array of translations.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
class PhpFileLoader extends ArrayLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($resource, $locale, $domain = 'messages')
    {
        if (!stream_is_local($resource)) {
            throw new InvalidResourceException(sprintf('This is not a local file "%s".', $resource));
        }

        if (!file_exists($resource)) {
            throw new NotFoundResourceException(sprintf('File "%s" not found.', $resource));
        }

        $messages = require $resource;

        $catalogue = parent::load($messages, $locale, $domain);

        if (class_exists('Symfony\Component\Config\Resource\FileResource')) {
            $catalogue->addResource(new FileResource($resource));
        }

        return $catalogue;
=======
class PhpFileLoader extends FileLoader
{
    private static $cache = [];

    /**
     * {@inheritdoc}
     */
    protected function loadResource($resource)
    {
        if ([] === self::$cache && \function_exists('opcache_invalidate') && filter_var(ini_get('opcache.enable'), \FILTER_VALIDATE_BOOLEAN) && (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) || filter_var(ini_get('opcache.enable_cli'), \FILTER_VALIDATE_BOOLEAN))) {
            self::$cache = null;
        }

        if (null === self::$cache) {
            return require $resource;
        }

        if (isset(self::$cache[$resource])) {
            return self::$cache[$resource];
        }

        return self::$cache[$resource] = require $resource;
>>>>>>> v2-test
    }
}
