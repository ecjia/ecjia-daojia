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

<<<<<<< HEAD
use Symfony\Component\Console\Formatter\OutputFormatter;
=======
use Symfony\Component\Console\Formatter\NullOutputFormatter;
>>>>>>> v2-test
use Symfony\Component\Console\Formatter\OutputFormatterInterface;

/**
 * NullOutput suppresses all output.
 *
 *     $output = new NullOutput();
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
 */
class NullOutput implements OutputInterface
{
<<<<<<< HEAD
=======
    private $formatter;

>>>>>>> v2-test
    /**
     * {@inheritdoc}
     */
    public function setFormatter(OutputFormatterInterface $formatter)
    {
        // do nothing
    }

    /**
     * {@inheritdoc}
     */
    public function getFormatter()
    {
<<<<<<< HEAD
        // to comply with the interface we must return a OutputFormatterInterface
        return new OutputFormatter();
=======
        if ($this->formatter) {
            return $this->formatter;
        }
        // to comply with the interface we must return a OutputFormatterInterface
        return $this->formatter = new NullOutputFormatter();
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setDecorated($decorated)
=======
    public function setDecorated(bool $decorated)
>>>>>>> v2-test
    {
        // do nothing
    }

    /**
     * {@inheritdoc}
     */
    public function isDecorated()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setVerbosity($level)
=======
    public function setVerbosity(int $level)
>>>>>>> v2-test
    {
        // do nothing
    }

    /**
     * {@inheritdoc}
     */
    public function getVerbosity()
    {
        return self::VERBOSITY_QUIET;
    }

    /**
     * {@inheritdoc}
     */
    public function isQuiet()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isVerbose()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isVeryVerbose()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isDebug()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function writeln($messages, $options = self::OUTPUT_NORMAL)
=======
    public function writeln($messages, int $options = self::OUTPUT_NORMAL)
>>>>>>> v2-test
    {
        // do nothing
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function write($messages, $newline = false, $options = self::OUTPUT_NORMAL)
=======
    public function write($messages, bool $newline = false, int $options = self::OUTPUT_NORMAL)
>>>>>>> v2-test
    {
        // do nothing
    }
}
