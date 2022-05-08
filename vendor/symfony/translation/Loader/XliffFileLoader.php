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
use Symfony\Component\Config\Util\XmlUtils;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Exception\InvalidResourceException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Config\Resource\FileResource;
=======
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\Util\XmlUtils;
use Symfony\Component\Translation\Exception\InvalidResourceException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Translation\Exception\RuntimeException;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Util\XliffUtils;
>>>>>>> v2-test

/**
 * XliffFileLoader loads translations from XLIFF files.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class XliffFileLoader implements LoaderInterface
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function load($resource, $locale, $domain = 'messages')
    {
=======
    public function load($resource, string $locale, string $domain = 'messages')
    {
        if (!class_exists(XmlUtils::class)) {
            throw new RuntimeException('Loading translations from the Xliff format requires the Symfony Config component.');
        }

>>>>>>> v2-test
        if (!stream_is_local($resource)) {
            throw new InvalidResourceException(sprintf('This is not a local file "%s".', $resource));
        }

        if (!file_exists($resource)) {
            throw new NotFoundResourceException(sprintf('File "%s" not found.', $resource));
        }

<<<<<<< HEAD
        list($xml, $encoding) = $this->parseFile($resource);
        $xml->registerXPathNamespace('xliff', 'urn:oasis:names:tc:xliff:document:1.2');

        $catalogue = new MessageCatalogue($locale);
        foreach ($xml->xpath('//xliff:trans-unit') as $translation) {
            $attributes = $translation->attributes();

            if (!(isset($attributes['resname']) || isset($translation->source))) {
                continue;
            }

            $source = isset($attributes['resname']) && $attributes['resname'] ? $attributes['resname'] : $translation->source;
            // If the xlf file has another encoding specified, try to convert it because
            // simple_xml will always return utf-8 encoded values
            $target = $this->utf8ToCharset((string) (isset($translation->target) ? $translation->target : $source), $encoding);

            $catalogue->set((string) $source, $target, $domain);

            if (isset($translation->note)) {
                $notes = array();
                foreach ($translation->note as $xmlNote) {
                    $noteAttributes = $xmlNote->attributes();
                    $note = array('content' => $this->utf8ToCharset((string) $xmlNote, $encoding));
                    if (isset($noteAttributes['priority'])) {
                        $note['priority'] = (int) $noteAttributes['priority'];
                    }

                    if (isset($noteAttributes['from'])) {
                        $note['from'] = (string) $noteAttributes['from'];
                    }

                    $notes[] = $note;
                }

                $catalogue->setMetadata((string) $source, array('notes' => $notes), $domain);
            }
        }

        if (class_exists('Symfony\Component\Config\Resource\FileResource')) {
=======
        $catalogue = new MessageCatalogue($locale);
        $this->extract($resource, $catalogue, $domain);

        if (class_exists(FileResource::class)) {
>>>>>>> v2-test
            $catalogue->addResource(new FileResource($resource));
        }

        return $catalogue;
    }

<<<<<<< HEAD
    /**
     * Convert a UTF8 string to the specified encoding.
     *
     * @param string $content  String to decode
     * @param string $encoding Target encoding
     *
     * @return string
     */
    private function utf8ToCharset($content, $encoding = null)
    {
        if ('UTF-8' !== $encoding && !empty($encoding)) {
            if (function_exists('mb_convert_encoding')) {
                return mb_convert_encoding($content, $encoding, 'UTF-8');
            }

            if (function_exists('iconv')) {
                return iconv('UTF-8', $encoding, $content);
            }

            throw new \RuntimeException('No suitable convert encoding function (use UTF-8 as your encoding or install the iconv or mbstring extension).');
        }

        return $content;
    }

    /**
     * Validates and parses the given file into a SimpleXMLElement.
     *
     * @param string $file
     *
     * @return \SimpleXMLElement
     *
     * @throws \RuntimeException
     * @throws InvalidResourceException
     */
    private function parseFile($file)
    {
        try {
            $dom = XmlUtils::loadFile($file);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidResourceException(sprintf('Unable to load "%s": %s', $file, $e->getMessage()), $e->getCode(), $e);
        }

        $internalErrors = libxml_use_internal_errors(true);

        $location = str_replace('\\', '/', __DIR__).'/schema/dic/xliff-core/xml.xsd';
        $parts = explode('/', $location);
        if (0 === stripos($location, 'phar://')) {
            $tmpfile = tempnam(sys_get_temp_dir(), 'sf2');
            if ($tmpfile) {
                copy($location, $tmpfile);
                $parts = explode('/', str_replace('\\', '/', $tmpfile));
            }
        }
        $drive = '\\' === DIRECTORY_SEPARATOR ? array_shift($parts).'/' : '';
        $location = 'file:///'.$drive.implode('/', array_map('rawurlencode', $parts));

        $source = file_get_contents(__DIR__.'/schema/dic/xliff-core/xliff-core-1.2-strict.xsd');
        $source = str_replace('http://www.w3.org/2001/xml.xsd', $location, $source);

        $disableEntities = libxml_disable_entity_loader(false);

        if (!@$dom->schemaValidateSource($source)) {
            libxml_disable_entity_loader($disableEntities);

            throw new InvalidResourceException(sprintf('Invalid resource provided: "%s"; Errors: %s', $file, implode("\n", $this->getXmlErrors($internalErrors))));
        }

        libxml_disable_entity_loader($disableEntities);

        $dom->normalizeDocument();

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return array(simplexml_import_dom($dom), strtoupper($dom->encoding));
    }

    /**
     * Returns the XML errors of the internal XML parser.
     *
     * @param bool $internalErrors
     *
     * @return array An array of errors
     */
    private function getXmlErrors($internalErrors)
    {
        $errors = array();
        foreach (libxml_get_errors() as $error) {
            $errors[] = sprintf('[%s %s] %s (in %s - line %d, column %d)',
                LIBXML_ERR_WARNING == $error->level ? 'WARNING' : 'ERROR',
                $error->code,
                trim($error->message),
                $error->file ?: 'n/a',
                $error->line,
                $error->column
            );
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return $errors;
=======
    private function extract($resource, MessageCatalogue $catalogue, string $domain)
    {
        try {
            $dom = XmlUtils::loadFile($resource);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidResourceException(sprintf('Unable to load "%s": ', $resource).$e->getMessage(), $e->getCode(), $e);
        }

        $xliffVersion = XliffUtils::getVersionNumber($dom);
        if ($errors = XliffUtils::validateSchema($dom)) {
            throw new InvalidResourceException(sprintf('Invalid resource provided: "%s"; Errors: ', $resource).XliffUtils::getErrorsAsString($errors));
        }

        if ('1.2' === $xliffVersion) {
            $this->extractXliff1($dom, $catalogue, $domain);
        }

        if ('2.0' === $xliffVersion) {
            $this->extractXliff2($dom, $catalogue, $domain);
        }
    }

    /**
     * Extract messages and metadata from DOMDocument into a MessageCatalogue.
     */
    private function extractXliff1(\DOMDocument $dom, MessageCatalogue $catalogue, string $domain)
    {
        $xml = simplexml_import_dom($dom);
        $encoding = strtoupper($dom->encoding);

        $namespace = 'urn:oasis:names:tc:xliff:document:1.2';
        $xml->registerXPathNamespace('xliff', $namespace);

        foreach ($xml->xpath('//xliff:file') as $file) {
            $fileAttributes = $file->attributes();

            $file->registerXPathNamespace('xliff', $namespace);

            foreach ($file->xpath('.//xliff:trans-unit') as $translation) {
                $attributes = $translation->attributes();

                if (!(isset($attributes['resname']) || isset($translation->source))) {
                    continue;
                }

                $source = isset($attributes['resname']) && $attributes['resname'] ? $attributes['resname'] : $translation->source;
                // If the xlf file has another encoding specified, try to convert it because
                // simple_xml will always return utf-8 encoded values
                $target = $this->utf8ToCharset((string) ($translation->target ?? $translation->source), $encoding);

                $catalogue->set((string) $source, $target, $domain);

                $metadata = [
                    'source' => (string) $translation->source,
                    'file' => [
                        'original' => (string) $fileAttributes['original'],
                    ],
                ];
                if ($notes = $this->parseNotesMetadata($translation->note, $encoding)) {
                    $metadata['notes'] = $notes;
                }

                if (isset($translation->target) && $translation->target->attributes()) {
                    $metadata['target-attributes'] = [];
                    foreach ($translation->target->attributes() as $key => $value) {
                        $metadata['target-attributes'][$key] = (string) $value;
                    }
                }

                if (isset($attributes['id'])) {
                    $metadata['id'] = (string) $attributes['id'];
                }

                $catalogue->setMetadata((string) $source, $metadata, $domain);
            }
        }
    }

    private function extractXliff2(\DOMDocument $dom, MessageCatalogue $catalogue, string $domain)
    {
        $xml = simplexml_import_dom($dom);
        $encoding = strtoupper($dom->encoding);

        $xml->registerXPathNamespace('xliff', 'urn:oasis:names:tc:xliff:document:2.0');

        foreach ($xml->xpath('//xliff:unit') as $unit) {
            foreach ($unit->segment as $segment) {
                $attributes = $unit->attributes();
                $source = $attributes['name'] ?? $segment->source;

                // If the xlf file has another encoding specified, try to convert it because
                // simple_xml will always return utf-8 encoded values
                $target = $this->utf8ToCharset((string) ($segment->target ?? $segment->source), $encoding);

                $catalogue->set((string) $source, $target, $domain);

                $metadata = [];
                if (isset($segment->target) && $segment->target->attributes()) {
                    $metadata['target-attributes'] = [];
                    foreach ($segment->target->attributes() as $key => $value) {
                        $metadata['target-attributes'][$key] = (string) $value;
                    }
                }

                if (isset($unit->notes)) {
                    $metadata['notes'] = [];
                    foreach ($unit->notes->note as $noteNode) {
                        $note = [];
                        foreach ($noteNode->attributes() as $key => $value) {
                            $note[$key] = (string) $value;
                        }
                        $note['content'] = (string) $noteNode;
                        $metadata['notes'][] = $note;
                    }
                }

                $catalogue->setMetadata((string) $source, $metadata, $domain);
            }
        }
    }

    /**
     * Convert a UTF8 string to the specified encoding.
     */
    private function utf8ToCharset(string $content, string $encoding = null): string
    {
        if ('UTF-8' !== $encoding && !empty($encoding)) {
            return mb_convert_encoding($content, $encoding, 'UTF-8');
        }

        return $content;
    }

    private function parseNotesMetadata(\SimpleXMLElement $noteElement = null, string $encoding = null): array
    {
        $notes = [];

        if (null === $noteElement) {
            return $notes;
        }

        /** @var \SimpleXMLElement $xmlNote */
        foreach ($noteElement as $xmlNote) {
            $noteAttributes = $xmlNote->attributes();
            $note = ['content' => $this->utf8ToCharset((string) $xmlNote, $encoding)];
            if (isset($noteAttributes['priority'])) {
                $note['priority'] = (int) $noteAttributes['priority'];
            }

            if (isset($noteAttributes['from'])) {
                $note['from'] = (string) $noteAttributes['from'];
            }

            $notes[] = $note;
        }

        return $notes;
>>>>>>> v2-test
    }
}
