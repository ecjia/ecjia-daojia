<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/29
 * Time: 16:28
 */

namespace Ecjia\Component\FileHash;


use Royalcms\Component\DirectoryHasher\Result;
use Royalcms\Component\DirectoryHasher\Writer\File\FileInterface;
use DOMDocument;

/**
 * Writer for exporting Result into an xml-file
 */
class WriteXml implements FileInterface
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
            
            $fileName = str_replace(base_path(), '', $resultfile->getFilename());

            //$fileName = str_replace(DIRECTORY_SEPARATOR, '/', $fileName);

            $resultnode->setAttribute('name', $fileName);

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