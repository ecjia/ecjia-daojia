<?php

namespace Royalcms\Component\DirectoryHasher\Writer\File;

use Royalcms\Component\DirectoryHasher\Result;
use DOMDocument;

/**
 * Writer for exporting Result into an xml-file
 */
class Xml implements FileInterface
{
    /**
     * {@inheritdoc}
     */
    public function write(Result $result, $file) {
        $dom = new DOMDocument();
        $hashes = $dom->createElement('files');
        $dom->appendChild($hashes);

        foreach($result as $resultfile)
        {
            /* @var $resultfile \Royalcms\Component\DirectoryHasher\Result\File */
            $resultnode = $dom->createElement('file');
            $resultnode->setAttribute('name', $resultfile->getFilename());

            foreach($resultfile->getHashes() as $hash => $value) {
                $hashnode = $dom->createElement('hash', $value);
                $hashnode->setAttribute('hash', $hash);
                $resultnode->appendChild($hashnode);
            }
            $hashes->appendChild($resultnode);
        }
        $dom->save($file);
    }
}
