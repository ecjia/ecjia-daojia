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
use Symfony\Component\Yaml\Parser as YamlParser;
use Symfony\Component\Yaml\Exception\ParseException;
=======
use Symfony\Component\Translation\Exception\LogicException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser as YamlParser;
use Symfony\Component\Yaml\Yaml;
>>>>>>> v2-test

/**
 * YamlFileLoader loads translations from Yaml files.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
class YamlFileLoader extends ArrayLoader
=======
class YamlFileLoader extends FileLoader
>>>>>>> v2-test
{
    private $yamlParser;

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

        if (!class_exists('Symfony\Component\Yaml\Parser')) {
            throw new \LogicException('Loading translations from the YAML format requires the Symfony Yaml component.');
        }

        if (null === $this->yamlParser) {
=======
    protected function loadResource($resource)
    {
        if (null === $this->yamlParser) {
            if (!class_exists(\Symfony\Component\Yaml\Parser::class)) {
                throw new LogicException('Loading translations from the YAML format requires the Symfony Yaml component.');
            }

>>>>>>> v2-test
            $this->yamlParser = new YamlParser();
        }

        try {
<<<<<<< HEAD
            $messages = $this->yamlParser->parse(file_get_contents($resource));
        } catch (ParseException $e) {
            throw new InvalidResourceException(sprintf('Error parsing YAML, invalid file "%s"', $resource), 0, $e);
        }

        // empty file
        if (null === $messages) {
            $messages = array();
        }

        // not an array
        if (!is_array($messages)) {
            throw new InvalidResourceException(sprintf('The file "%s" must contain a YAML array.', $resource));
        }

        $catalogue = parent::load($messages, $locale, $domain);

        if (class_exists('Symfony\Component\Config\Resource\FileResource')) {
            $catalogue->addResource(new FileResource($resource));
        }

        return $catalogue;
=======
            $messages = $this->yamlParser->parseFile($resource, Yaml::PARSE_CONSTANT);
        } catch (ParseException $e) {
            throw new InvalidResourceException(sprintf('The file "%s" does not contain valid YAML: ', $resource).$e->getMessage(), 0, $e);
        }

        if (null !== $messages && !\is_array($messages)) {
            throw new InvalidResourceException(sprintf('Unable to load file "%s".', $resource));
        }

        return $messages ?: [];
>>>>>>> v2-test
    }
}
