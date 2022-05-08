<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Output;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class BufferedOutput extends Output
{
    private $buffer = '';

    /**
     * Empties buffer and returns its content.
     *
     * @return string
     */
    public function fetch()
    {
        $content = $this->buffer;
        $this->buffer = '';

        return $content;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function doWrite($message, $newline)
=======
    protected function doWrite(string $message, bool $newline)
>>>>>>> v2-test
    {
        $this->buffer .= $message;

        if ($newline) {
<<<<<<< HEAD
            $this->buffer .= PHP_EOL;
=======
            $this->buffer .= \PHP_EOL;
>>>>>>> v2-test
        }
    }
}
