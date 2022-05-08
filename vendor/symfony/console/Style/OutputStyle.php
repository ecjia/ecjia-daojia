<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Style;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Decorates output to add console style guide helpers.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class OutputStyle implements OutputInterface, StyleInterface
{
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function newLine($count = 1)
    {
        $this->output->write(str_repeat(PHP_EOL, $count));
    }

    /**
     * @param int $max
     *
     * @return ProgressBar
     */
    public function createProgressBar($max = 0)
=======
    public function newLine(int $count = 1)
    {
        $this->output->write(str_repeat(\PHP_EOL, $count));
    }

    /**
     * @return ProgressBar
     */
    public function createProgressBar(int $max = 0)
>>>>>>> v2-test
    {
        return new ProgressBar($this->output, $max);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function write($messages, $newline = false, $type = self::OUTPUT_NORMAL)
=======
    public function write($messages, bool $newline = false, int $type = self::OUTPUT_NORMAL)
>>>>>>> v2-test
    {
        $this->output->write($messages, $newline, $type);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function writeln($messages, $type = self::OUTPUT_NORMAL)
=======
    public function writeln($messages, int $type = self::OUTPUT_NORMAL)
>>>>>>> v2-test
    {
        $this->output->writeln($messages, $type);
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
        $this->output->setVerbosity($level);
    }

    /**
     * {@inheritdoc}
     */
    public function getVerbosity()
    {
        return $this->output->getVerbosity();
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
        $this->output->setDecorated($decorated);
    }

    /**
     * {@inheritdoc}
     */
    public function isDecorated()
    {
        return $this->output->isDecorated();
    }

    /**
     * {@inheritdoc}
     */
    public function setFormatter(OutputFormatterInterface $formatter)
    {
        $this->output->setFormatter($formatter);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormatter()
    {
        return $this->output->getFormatter();
    }

    /**
     * {@inheritdoc}
     */
    public function isQuiet()
    {
        return $this->output->isQuiet();
    }

    /**
     * {@inheritdoc}
     */
    public function isVerbose()
    {
        return $this->output->isVerbose();
    }

    /**
     * {@inheritdoc}
     */
    public function isVeryVerbose()
    {
        return $this->output->isVeryVerbose();
    }

    /**
     * {@inheritdoc}
     */
    public function isDebug()
    {
        return $this->output->isDebug();
    }

    protected function getErrorOutput()
    {
        if (!$this->output instanceof ConsoleOutputInterface) {
            return $this->output;
        }

        return $this->output->getErrorOutput();
    }
}
