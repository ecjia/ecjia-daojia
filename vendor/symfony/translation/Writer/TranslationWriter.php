<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Writer;

<<<<<<< HEAD
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Dumper\DumperInterface;
=======
use Symfony\Component\Translation\Dumper\DumperInterface;
use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Component\Translation\Exception\RuntimeException;
use Symfony\Component\Translation\MessageCatalogue;
>>>>>>> v2-test

/**
 * TranslationWriter writes translation messages.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
<<<<<<< HEAD
class TranslationWriter
{
    /**
     * Dumpers used for export.
     *
     * @var array
     */
    private $dumpers = array();
=======
class TranslationWriter implements TranslationWriterInterface
{
    private $dumpers = [];
>>>>>>> v2-test

    /**
     * Adds a dumper to the writer.
     *
<<<<<<< HEAD
     * @param string          $format The format of the dumper
     * @param DumperInterface $dumper The dumper
=======
     * @param string $format The format of the dumper
>>>>>>> v2-test
     */
    public function addDumper($format, DumperInterface $dumper)
    {
        $this->dumpers[$format] = $dumper;
    }

    /**
<<<<<<< HEAD
     * Disables dumper backup.
     */
    public function disableBackup()
    {
        foreach ($this->dumpers as $dumper) {
            if (method_exists($dumper, 'setBackup')) {
                $dumper->setBackup(false);
            }
        }
    }

    /**
=======
>>>>>>> v2-test
     * Obtains the list of supported formats.
     *
     * @return array
     */
    public function getFormats()
    {
        return array_keys($this->dumpers);
    }

    /**
     * Writes translation from the catalogue according to the selected format.
     *
<<<<<<< HEAD
     * @param MessageCatalogue $catalogue The message catalogue to dump
     * @param string           $format    The format to use to dump the messages
     * @param array            $options   Options that are passed to the dumper
     *
     * @throws \InvalidArgumentException
     */
    public function writeTranslations(MessageCatalogue $catalogue, $format, $options = array())
    {
        if (!isset($this->dumpers[$format])) {
            throw new \InvalidArgumentException(sprintf('There is no dumper associated with format "%s".', $format));
=======
     * @param string $format  The format to use to dump the messages
     * @param array  $options Options that are passed to the dumper
     *
     * @throws InvalidArgumentException
     */
    public function write(MessageCatalogue $catalogue, string $format, array $options = [])
    {
        if (!isset($this->dumpers[$format])) {
            throw new InvalidArgumentException(sprintf('There is no dumper associated with format "%s".', $format));
>>>>>>> v2-test
        }

        // get the right dumper
        $dumper = $this->dumpers[$format];

        if (isset($options['path']) && !is_dir($options['path']) && !@mkdir($options['path'], 0777, true) && !is_dir($options['path'])) {
<<<<<<< HEAD
            throw new \RuntimeException(sprintf('Translation Writer was not able to create directory "%s"', $options['path']));
=======
            throw new RuntimeException(sprintf('Translation Writer was not able to create directory "%s".', $options['path']));
>>>>>>> v2-test
        }

        // save
        $dumper->dump($catalogue, $options);
    }
}
