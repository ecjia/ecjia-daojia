<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Dumper;

<<<<<<< HEAD
=======
use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Component\Translation\Exception\RuntimeException;
>>>>>>> v2-test
use Symfony\Component\Translation\MessageCatalogue;

/**
 * FileDumper is an implementation of DumperInterface that dump a message catalogue to file(s).
<<<<<<< HEAD
 * Performs backup of already existing files.
=======
>>>>>>> v2-test
 *
 * Options:
 * - path (mandatory): the directory where the files should be saved
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
abstract class FileDumper implements DumperInterface
{
    /**
     * A template for the relative paths to files.
     *
     * @var string
     */
    protected $relativePathTemplate = '%domain%.%locale%.%extension%';

    /**
<<<<<<< HEAD
     * Make file backup before the dump.
     *
     * @var bool
     */
    private $backup = true;

    /**
=======
>>>>>>> v2-test
     * Sets the template for the relative paths to files.
     *
     * @param string $relativePathTemplate A template for the relative paths to files
     */
<<<<<<< HEAD
    public function setRelativePathTemplate($relativePathTemplate)
=======
    public function setRelativePathTemplate(string $relativePathTemplate)
>>>>>>> v2-test
    {
        $this->relativePathTemplate = $relativePathTemplate;
    }

    /**
<<<<<<< HEAD
     * Sets backup flag.
     *
     * @param bool
     */
    public function setBackup($backup)
    {
        $this->backup = $backup;
    }

    /**
     * {@inheritdoc}
     */
    public function dump(MessageCatalogue $messages, $options = array())
    {
        if (!array_key_exists('path', $options)) {
            throw new \InvalidArgumentException('The file dumper needs a path option.');
=======
     * {@inheritdoc}
     */
    public function dump(MessageCatalogue $messages, array $options = [])
    {
        if (!\array_key_exists('path', $options)) {
            throw new InvalidArgumentException('The file dumper needs a path option.');
>>>>>>> v2-test
        }

        // save a file for each domain
        foreach ($messages->getDomains() as $domain) {
<<<<<<< HEAD
            // backup
            $fullpath = $options['path'].'/'.$this->getRelativePath($domain, $messages->getLocale());
            if (file_exists($fullpath)) {
                if ($this->backup) {
                    copy($fullpath, $fullpath.'~');
                }
            } else {
                $directory = dirname($fullpath);
                if (!file_exists($directory) && !@mkdir($directory, 0777, true)) {
                    throw new \RuntimeException(sprintf('Unable to create directory "%s".', $directory));
                }
            }
            // save file
            file_put_contents($fullpath, $this->format($messages, $domain));
=======
            $fullpath = $options['path'].'/'.$this->getRelativePath($domain, $messages->getLocale());
            if (!file_exists($fullpath)) {
                $directory = \dirname($fullpath);
                if (!file_exists($directory) && !@mkdir($directory, 0777, true)) {
                    throw new RuntimeException(sprintf('Unable to create directory "%s".', $directory));
                }
            }

            $intlDomain = $domain.MessageCatalogue::INTL_DOMAIN_SUFFIX;
            $intlMessages = $messages->all($intlDomain);

            if ($intlMessages) {
                $intlPath = $options['path'].'/'.$this->getRelativePath($intlDomain, $messages->getLocale());
                file_put_contents($intlPath, $this->formatCatalogue($messages, $intlDomain, $options));

                $messages->replace([], $intlDomain);

                try {
                    if ($messages->all($domain)) {
                        file_put_contents($fullpath, $this->formatCatalogue($messages, $domain, $options));
                    }
                    continue;
                } finally {
                    $messages->replace($intlMessages, $intlDomain);
                }
            }

            file_put_contents($fullpath, $this->formatCatalogue($messages, $domain, $options));
>>>>>>> v2-test
        }
    }

    /**
     * Transforms a domain of a message catalogue to its string representation.
     *
<<<<<<< HEAD
     * @param MessageCatalogue $messages
     * @param string           $domain
     *
     * @return string representation
     */
    abstract protected function format(MessageCatalogue $messages, $domain);
=======
     * @return string representation
     */
    abstract public function formatCatalogue(MessageCatalogue $messages, string $domain, array $options = []);
>>>>>>> v2-test

    /**
     * Gets the file extension of the dumper.
     *
     * @return string file extension
     */
    abstract protected function getExtension();

    /**
     * Gets the relative file path using the template.
<<<<<<< HEAD
     *
     * @param string $domain The domain
     * @param string $locale The locale
     *
     * @return string The relative file path
     */
    private function getRelativePath($domain, $locale)
    {
        return strtr($this->relativePathTemplate, array(
            '%domain%' => $domain,
            '%locale%' => $locale,
            '%extension%' => $this->getExtension(),
        ));
=======
     */
    private function getRelativePath(string $domain, string $locale): string
    {
        return strtr($this->relativePathTemplate, [
            '%domain%' => $domain,
            '%locale%' => $locale,
            '%extension%' => $this->getExtension(),
        ]);
>>>>>>> v2-test
    }
}
