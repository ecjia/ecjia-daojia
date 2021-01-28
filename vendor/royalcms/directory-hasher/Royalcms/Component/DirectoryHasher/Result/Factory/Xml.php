<?php

namespace Royalcms\Component\DirectoryHasher\Result\Factory;

use DOMDocument;
use DOMXPath;
use DOMNode;
use Royalcms\Component\DirectoryHasher\Result;
use Royalcms\Component\DirectoryHasher\Result\File;

/**
 * Builds results from xml-files
 */
class Xml
{
    /**
     * @var \callable
     */
    protected $filenameAttrCallback = null;

    public function setFileNameAttrCallback(callable $callable)
    {
        if (is_callable($callable)) {
            $this->filenameAttrCallback = $callable;
        }
    }

    /**
     * Builds a Result from an xml-file
     *
     * @param string $filename
     * @return \Royalcms\Component\DirectoryHasher\Result
     */
    public function buildResultFromFile($filename) {
        $document = new DOMDocument();
        $document->load($filename);

        return $this->buildResultFromDOM($document);
    }

    /**
     * Builds a Result from an xml-content
     *
     * @param string $filecontent
     * @return \Royalcms\Component\DirectoryHasher\Result
     */
    public function buildResultFromString($filecontent) {
        $document = new DOMDocument();
        $document->loadXML($filecontent);

        return $this->buildResultFromDOM($document);
    }

    /**
     * Builds a Result from a DOM-Object
     *
     * @param DOMDocument $document
     * @return \Royalcms\Component\DirectoryHasher\Result
     */
    public function buildResultFromDOM(DOMDocument $document) {
        $result = new Result();
        $xpath = new DOMXPath($document);

        $entries = $xpath->query('//files/file');

        foreach ($entries as $entry) {

            $filenameAttr = $entry->attributes->getNamedItem('name');
            if ($filenameAttr !== null) {

                if (is_callable($this->filenameAttrCallback)) {
                    call_user_func($this->filenameAttrCallback, $filenameAttr);
                }

                $fileResult = new File($filenameAttr->value);
                foreach ($this->getHashesFromFileNode($entry) as $name => $value) {
                    $fileResult->addHash($name, $value);
                }
                $result->addFileResult($fileResult);
            }
        }

        return $result;
    }

    /**
     * Returns an array with hashes from a file-node
     *
     * @param DomNode $node
     * @return array
     */
    public function getHashesFromFileNode(DomNode $node) {
        $hashes = array();
        if ($node->hasChildNodes()) {
            $children = $node->childNodes;
            /* @var $children \DOMNodeList */
            foreach ($children as $childnode) {
                /* @var $childnode DOMNode */
                if ($childnode->nodeName === 'hash') {
                    $attributes = $childnode->attributes;
                    /* @var $attributes \DOMNamedNodeMap */
                    $hash = $attributes->getNamedItem('hash');
                    /* @var $hash \DOMAttr */
                    $hashes[$hash->value] = $childnode->nodeValue;
                }
            }
        }

        return $hashes;
    }

}
