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

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;

/**
 * Base class for output classes.
 *
 * There are five levels of verbosity:
 *
 *  * normal: no option passed (normal output)
 *  * verbose: -v (more output)
 *  * very verbose: -vv (highly extended output)
 *  * debug: -vvv (all debug output)
 *  * quiet: -q (no output)
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class Output implements OutputInterface
{
    private $verbosity;
    private $formatter;

    /**
     * @param int                           $verbosity The verbosity level (one of the VERBOSITY constants in OutputInterface)
     * @param bool                          $decorated Whether to decorate messages
     * @param OutputFormatterInterface|null $formatter Output formatter instance (null to use default OutputFormatter)
     */
<<<<<<< HEAD
    public function __construct($verbosity = self::VERBOSITY_NORMAL, $decorated = false, OutputFormatterInterface $formatter = null)
=======
    public function __construct(?int $verbosity = self::VERBOSITY_NORMAL, bool $decorated = false, OutputFormatterInterface $formatter = null)
>>>>>>> v2-test
    {
        $this->verbosity = null === $verbosity ? self::VERBOSITY_NORMAL : $verbosity;
        $this->formatter = $formatter ?: new OutputFormatter();
        $this->formatter->setDecorated($decorated);
    }

    /**
     * {@inheritdoc}
     */
    public function setFormatter(OutputFormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormatter()
    {
        return $this->formatter;
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
        $this->formatter->setDecorated($decorated);
    }

    /**
     * {@inheritdoc}
     */
    public function isDecorated()
    {
        return $this->formatter->isDecorated();
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setVerbosity($level)
    {
        $this->verbosity = (int) $level;
=======
    public function setVerbosity(int $level)
    {
        $this->verbosity = $level;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function getVerbosity()
    {
        return $this->verbosity;
    }

    /**
     * {@inheritdoc}
     */
    public function isQuiet()
    {
        return self::VERBOSITY_QUIET === $this->verbosity;
    }

    /**
     * {@inheritdoc}
     */
    public function isVerbose()
    {
        return self::VERBOSITY_VERBOSE <= $this->verbosity;
    }

    /**
     * {@inheritdoc}
     */
    public function isVeryVerbose()
    {
        return self::VERBOSITY_VERY_VERBOSE <= $this->verbosity;
    }

    /**
     * {@inheritdoc}
     */
    public function isDebug()
    {
        return self::VERBOSITY_DEBUG <= $this->verbosity;
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
        $this->write($messages, true, $options);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function write($messages, $newline = false, $options = self::OUTPUT_NORMAL)
    {
        $messages = (array) $messages;
=======
    public function write($messages, bool $newline = false, int $options = self::OUTPUT_NORMAL)
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }
>>>>>>> v2-test

        $types = self::OUTPUT_NORMAL | self::OUTPUT_RAW | self::OUTPUT_PLAIN;
        $type = $types & $options ?: self::OUTPUT_NORMAL;

        $verbosities = self::VERBOSITY_QUIET | self::VERBOSITY_NORMAL | self::VERBOSITY_VERBOSE | self::VERBOSITY_VERY_VERBOSE | self::VERBOSITY_DEBUG;
        $verbosity = $verbosities & $options ?: self::VERBOSITY_NORMAL;

        if ($verbosity > $this->getVerbosity()) {
            return;
        }

        foreach ($messages as $message) {
            switch ($type) {
                case OutputInterface::OUTPUT_NORMAL:
                    $message = $this->formatter->format($message);
                    break;
                case OutputInterface::OUTPUT_RAW:
                    break;
                case OutputInterface::OUTPUT_PLAIN:
                    $message = strip_tags($this->formatter->format($message));
                    break;
            }

            $this->doWrite($message, $newline);
        }
    }

    /**
     * Writes a message to the output.
<<<<<<< HEAD
     *
     * @param string $message A message to write to the output
     * @param bool   $newline Whether to add a newline or not
     */
    abstract protected function doWrite($message, $newline);
=======
     */
    abstract protected function doWrite(string $message, bool $newline);
>>>>>>> v2-test
}
