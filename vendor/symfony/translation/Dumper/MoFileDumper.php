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
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Loader\MoFileLoader;
=======
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\MessageCatalogue;
>>>>>>> v2-test

/**
 * MoFileDumper generates a gettext formatted string representation of a message catalogue.
 *
 * @author Stealth35
 */
class MoFileDumper extends FileDumper
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function format(MessageCatalogue $messages, $domain = 'messages')
    {
        $sources = $targets = $sourceOffsets = $targetOffsets = '';
        $offsets = array();
        $size = 0;

        foreach ($messages->all($domain) as $source => $target) {
            $offsets[] = array_map('strlen', array($sources, $source, $targets, $target));
=======
    public function formatCatalogue(MessageCatalogue $messages, string $domain, array $options = [])
    {
        $sources = $targets = $sourceOffsets = $targetOffsets = '';
        $offsets = [];
        $size = 0;

        foreach ($messages->all($domain) as $source => $target) {
            $offsets[] = array_map('strlen', [$sources, $source, $targets, $target]);
>>>>>>> v2-test
            $sources .= "\0".$source;
            $targets .= "\0".$target;
            ++$size;
        }

<<<<<<< HEAD
        $header = array(
=======
        $header = [
>>>>>>> v2-test
            'magicNumber' => MoFileLoader::MO_LITTLE_ENDIAN_MAGIC,
            'formatRevision' => 0,
            'count' => $size,
            'offsetId' => MoFileLoader::MO_HEADER_SIZE,
            'offsetTranslated' => MoFileLoader::MO_HEADER_SIZE + (8 * $size),
            'sizeHashes' => 0,
            'offsetHashes' => MoFileLoader::MO_HEADER_SIZE + (16 * $size),
<<<<<<< HEAD
        );

        $sourcesSize = strlen($sources);
=======
        ];

        $sourcesSize = \strlen($sources);
>>>>>>> v2-test
        $sourcesStart = $header['offsetHashes'] + 1;

        foreach ($offsets as $offset) {
            $sourceOffsets .= $this->writeLong($offset[1])
                          .$this->writeLong($offset[0] + $sourcesStart);
            $targetOffsets .= $this->writeLong($offset[3])
                          .$this->writeLong($offset[2] + $sourcesStart + $sourcesSize);
        }

<<<<<<< HEAD
        $output = implode(array_map(array($this, 'writeLong'), $header))
=======
        $output = implode('', array_map([$this, 'writeLong'], $header))
>>>>>>> v2-test
               .$sourceOffsets
               .$targetOffsets
               .$sources
               .$targets
                ;

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtension()
    {
        return 'mo';
    }

<<<<<<< HEAD
    private function writeLong($str)
=======
    private function writeLong($str): string
>>>>>>> v2-test
    {
        return pack('V*', $str);
    }
}
