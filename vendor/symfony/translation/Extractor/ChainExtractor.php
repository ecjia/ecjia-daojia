<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Extractor;

use Symfony\Component\Translation\MessageCatalogue;

/**
 * ChainExtractor extracts translation messages from template files.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class ChainExtractor implements ExtractorInterface
{
    /**
     * The extractors.
     *
     * @var ExtractorInterface[]
     */
<<<<<<< HEAD
    private $extractors = array();
=======
    private $extractors = [];
>>>>>>> v2-test

    /**
     * Adds a loader to the translation extractor.
     *
<<<<<<< HEAD
     * @param string             $format    The format of the loader
     * @param ExtractorInterface $extractor The loader
     */
    public function addExtractor($format, ExtractorInterface $extractor)
=======
     * @param string $format The format of the loader
     */
    public function addExtractor(string $format, ExtractorInterface $extractor)
>>>>>>> v2-test
    {
        $this->extractors[$format] = $extractor;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setPrefix($prefix)
=======
    public function setPrefix(string $prefix)
>>>>>>> v2-test
    {
        foreach ($this->extractors as $extractor) {
            $extractor->setPrefix($prefix);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function extract($directory, MessageCatalogue $catalogue)
    {
        foreach ($this->extractors as $extractor) {
            $extractor->extract($directory, $catalogue);
        }
    }
}
