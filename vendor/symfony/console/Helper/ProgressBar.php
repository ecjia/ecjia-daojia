<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Helper;

<<<<<<< HEAD
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
=======
use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
>>>>>>> v2-test
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Terminal;

/**
 * The ProgressBar provides helpers to display progress output.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Chris Jones <leeked@gmail.com>
 */
final class ProgressBar
{
    private $barWidth = 28;
    private $barChar;
    private $emptyBarChar = '-';
    private $progressChar = '>';
    private $format;
    private $internalFormat;
    private $redrawFreq = 1;
<<<<<<< HEAD
=======
    private $writeCount;
    private $lastWriteTime;
    private $minSecondsBetweenRedraws = 0;
    private $maxSecondsBetweenRedraws = 1;
>>>>>>> v2-test
    private $output;
    private $step = 0;
    private $max;
    private $startTime;
    private $stepWidth;
    private $percent = 0.0;
    private $formatLineCount;
<<<<<<< HEAD
    private $messages = array();
    private $overwrite = true;
    private $terminal;
    private $firstRun = true;
=======
    private $messages = [];
    private $overwrite = true;
    private $terminal;
    private $previousMessage;
    private $cursor;
>>>>>>> v2-test

    private static $formatters;
    private static $formats;

    /**
<<<<<<< HEAD
     * @param OutputInterface $output An OutputInterface instance
     * @param int             $max    Maximum steps (0 if unknown)
     */
    public function __construct(OutputInterface $output, $max = 0)
=======
     * @param int $max Maximum steps (0 if unknown)
     */
    public function __construct(OutputInterface $output, int $max = 0, float $minSecondsBetweenRedraws = 1 / 25)
>>>>>>> v2-test
    {
        if ($output instanceof ConsoleOutputInterface) {
            $output = $output->getErrorOutput();
        }

        $this->output = $output;
        $this->setMaxSteps($max);
        $this->terminal = new Terminal();

<<<<<<< HEAD
=======
        if (0 < $minSecondsBetweenRedraws) {
            $this->redrawFreq = null;
            $this->minSecondsBetweenRedraws = $minSecondsBetweenRedraws;
        }

>>>>>>> v2-test
        if (!$this->output->isDecorated()) {
            // disable overwrite when output does not support ANSI codes.
            $this->overwrite = false;

            // set a reasonable redraw frequency so output isn't flooded
<<<<<<< HEAD
            $this->setRedrawFrequency($max / 10);
        }

        $this->startTime = time();
=======
            $this->redrawFreq = null;
        }

        $this->startTime = time();
        $this->cursor = new Cursor($output);
>>>>>>> v2-test
    }

    /**
     * Sets a placeholder formatter for a given name.
     *
     * This method also allow you to override an existing placeholder.
     *
     * @param string   $name     The placeholder name (including the delimiter char like %)
     * @param callable $callable A PHP callable
     */
<<<<<<< HEAD
    public static function setPlaceholderFormatterDefinition($name, callable $callable)
=======
    public static function setPlaceholderFormatterDefinition(string $name, callable $callable): void
>>>>>>> v2-test
    {
        if (!self::$formatters) {
            self::$formatters = self::initPlaceholderFormatters();
        }

        self::$formatters[$name] = $callable;
    }

    /**
     * Gets the placeholder formatter for a given name.
     *
     * @param string $name The placeholder name (including the delimiter char like %)
     *
     * @return callable|null A PHP callable
     */
<<<<<<< HEAD
    public static function getPlaceholderFormatterDefinition($name)
=======
    public static function getPlaceholderFormatterDefinition(string $name): ?callable
>>>>>>> v2-test
    {
        if (!self::$formatters) {
            self::$formatters = self::initPlaceholderFormatters();
        }

<<<<<<< HEAD
        return isset(self::$formatters[$name]) ? self::$formatters[$name] : null;
=======
        return self::$formatters[$name] ?? null;
>>>>>>> v2-test
    }

    /**
     * Sets a format for a given name.
     *
     * This method also allow you to override an existing format.
     *
     * @param string $name   The format name
     * @param string $format A format string
     */
<<<<<<< HEAD
    public static function setFormatDefinition($name, $format)
=======
    public static function setFormatDefinition(string $name, string $format): void
>>>>>>> v2-test
    {
        if (!self::$formats) {
            self::$formats = self::initFormats();
        }

        self::$formats[$name] = $format;
    }

    /**
     * Gets the format for a given name.
     *
     * @param string $name The format name
     *
     * @return string|null A format string
     */
<<<<<<< HEAD
    public static function getFormatDefinition($name)
=======
    public static function getFormatDefinition(string $name): ?string
>>>>>>> v2-test
    {
        if (!self::$formats) {
            self::$formats = self::initFormats();
        }

<<<<<<< HEAD
        return isset(self::$formats[$name]) ? self::$formats[$name] : null;
=======
        return self::$formats[$name] ?? null;
>>>>>>> v2-test
    }

    /**
     * Associates a text with a named placeholder.
     *
     * The text is displayed when the progress bar is rendered but only
     * when the corresponding placeholder is part of the custom format line
     * (by wrapping the name with %).
     *
     * @param string $message The text to associate with the placeholder
     * @param string $name    The name of the placeholder
     */
<<<<<<< HEAD
    public function setMessage($message, $name = 'message')
=======
    public function setMessage(string $message, string $name = 'message')
>>>>>>> v2-test
    {
        $this->messages[$name] = $message;
    }

<<<<<<< HEAD
    public function getMessage($name = 'message')
=======
    public function getMessage(string $name = 'message')
>>>>>>> v2-test
    {
        return $this->messages[$name];
    }

<<<<<<< HEAD
    /**
     * Gets the progress bar start time.
     *
     * @return int The progress bar start time
     */
    public function getStartTime()
=======
    public function getStartTime(): int
>>>>>>> v2-test
    {
        return $this->startTime;
    }

<<<<<<< HEAD
    /**
     * Gets the progress bar maximal steps.
     *
     * @return int The progress bar max steps
     */
    public function getMaxSteps()
=======
    public function getMaxSteps(): int
>>>>>>> v2-test
    {
        return $this->max;
    }

<<<<<<< HEAD
    /**
     * Gets the current step position.
     *
     * @return int The progress bar step
     */
    public function getProgress()
=======
    public function getProgress(): int
>>>>>>> v2-test
    {
        return $this->step;
    }

<<<<<<< HEAD
    /**
     * Gets the progress bar step width.
     *
     * @return int The progress bar step width
     */
    private function getStepWidth()
=======
    private function getStepWidth(): int
>>>>>>> v2-test
    {
        return $this->stepWidth;
    }

<<<<<<< HEAD
    /**
     * Gets the current progress bar percent.
     *
     * @return float The current progress bar percent
     */
    public function getProgressPercent()
=======
    public function getProgressPercent(): float
>>>>>>> v2-test
    {
        return $this->percent;
    }

<<<<<<< HEAD
    /**
     * Sets the progress bar width.
     *
     * @param int $size The progress bar size
     */
    public function setBarWidth($size)
    {
        $this->barWidth = max(1, (int) $size);
    }

    /**
     * Gets the progress bar width.
     *
     * @return int The progress bar size
     */
    public function getBarWidth()
=======
    public function getBarOffset(): float
    {
        return floor($this->max ? $this->percent * $this->barWidth : (null === $this->redrawFreq ? min(5, $this->barWidth / 15) * $this->writeCount : $this->step) % $this->barWidth);
    }

    public function getEstimated(): float
    {
        if (!$this->step) {
            return 0;
        }

        return round((time() - $this->startTime) / $this->step * $this->max);
    }

    public function getRemaining(): float
    {
        if (!$this->step) {
            return 0;
        }

        return round((time() - $this->startTime) / $this->step * ($this->max - $this->step));
    }

    public function setBarWidth(int $size)
    {
        $this->barWidth = max(1, $size);
    }

    public function getBarWidth(): int
>>>>>>> v2-test
    {
        return $this->barWidth;
    }

<<<<<<< HEAD
    /**
     * Sets the bar character.
     *
     * @param string $char A character
     */
    public function setBarCharacter($char)
=======
    public function setBarCharacter(string $char)
>>>>>>> v2-test
    {
        $this->barChar = $char;
    }

<<<<<<< HEAD
    /**
     * Gets the bar character.
     *
     * @return string A character
     */
    public function getBarCharacter()
=======
    public function getBarCharacter(): string
>>>>>>> v2-test
    {
        if (null === $this->barChar) {
            return $this->max ? '=' : $this->emptyBarChar;
        }

        return $this->barChar;
    }

<<<<<<< HEAD
    /**
     * Sets the empty bar character.
     *
     * @param string $char A character
     */
    public function setEmptyBarCharacter($char)
=======
    public function setEmptyBarCharacter(string $char)
>>>>>>> v2-test
    {
        $this->emptyBarChar = $char;
    }

<<<<<<< HEAD
    /**
     * Gets the empty bar character.
     *
     * @return string A character
     */
    public function getEmptyBarCharacter()
=======
    public function getEmptyBarCharacter(): string
>>>>>>> v2-test
    {
        return $this->emptyBarChar;
    }

<<<<<<< HEAD
    /**
     * Sets the progress bar character.
     *
     * @param string $char A character
     */
    public function setProgressCharacter($char)
=======
    public function setProgressCharacter(string $char)
>>>>>>> v2-test
    {
        $this->progressChar = $char;
    }

<<<<<<< HEAD
    /**
     * Gets the progress bar character.
     *
     * @return string A character
     */
    public function getProgressCharacter()
=======
    public function getProgressCharacter(): string
>>>>>>> v2-test
    {
        return $this->progressChar;
    }

<<<<<<< HEAD
    /**
     * Sets the progress bar format.
     *
     * @param string $format The format
     */
    public function setFormat($format)
=======
    public function setFormat(string $format)
>>>>>>> v2-test
    {
        $this->format = null;
        $this->internalFormat = $format;
    }

    /**
     * Sets the redraw frequency.
     *
     * @param int|float $freq The frequency in steps
     */
<<<<<<< HEAD
    public function setRedrawFrequency($freq)
    {
        $this->redrawFreq = max((int) $freq, 1);
=======
    public function setRedrawFrequency(?int $freq)
    {
        $this->redrawFreq = null !== $freq ? max(1, $freq) : null;
    }

    public function minSecondsBetweenRedraws(float $seconds): void
    {
        $this->minSecondsBetweenRedraws = $seconds;
    }

    public function maxSecondsBetweenRedraws(float $seconds): void
    {
        $this->maxSecondsBetweenRedraws = $seconds;
    }

    /**
     * Returns an iterator that will automatically update the progress bar when iterated.
     *
     * @param int|null $max Number of steps to complete the bar (0 if indeterminate), if null it will be inferred from $iterable
     */
    public function iterate(iterable $iterable, int $max = null): iterable
    {
        $this->start($max ?? (is_countable($iterable) ? \count($iterable) : 0));

        foreach ($iterable as $key => $value) {
            yield $key => $value;

            $this->advance();
        }

        $this->finish();
>>>>>>> v2-test
    }

    /**
     * Starts the progress output.
     *
     * @param int|null $max Number of steps to complete the bar (0 if indeterminate), null to leave unchanged
     */
<<<<<<< HEAD
    public function start($max = null)
=======
    public function start(int $max = null)
>>>>>>> v2-test
    {
        $this->startTime = time();
        $this->step = 0;
        $this->percent = 0.0;

        if (null !== $max) {
            $this->setMaxSteps($max);
        }

        $this->display();
    }

    /**
     * Advances the progress output X steps.
     *
     * @param int $step Number of steps to advance
     */
<<<<<<< HEAD
    public function advance($step = 1)
=======
    public function advance(int $step = 1)
>>>>>>> v2-test
    {
        $this->setProgress($this->step + $step);
    }

    /**
     * Sets whether to overwrite the progressbar, false for new line.
<<<<<<< HEAD
     *
     * @param bool $overwrite
     */
    public function setOverwrite($overwrite)
    {
        $this->overwrite = (bool) $overwrite;
    }

    /**
     * Sets the current progress.
     *
     * @param int $step The current progress
     */
    public function setProgress($step)
    {
        $step = (int) $step;

=======
     */
    public function setOverwrite(bool $overwrite)
    {
        $this->overwrite = $overwrite;
    }

    public function setProgress(int $step)
    {
>>>>>>> v2-test
        if ($this->max && $step > $this->max) {
            $this->max = $step;
        } elseif ($step < 0) {
            $step = 0;
        }

<<<<<<< HEAD
        $prevPeriod = (int) ($this->step / $this->redrawFreq);
        $currPeriod = (int) ($step / $this->redrawFreq);
        $this->step = $step;
        $this->percent = $this->max ? (float) $this->step / $this->max : 0;
        if ($prevPeriod !== $currPeriod || $this->max === $step) {
=======
        $redrawFreq = $this->redrawFreq ?? (($this->max ?: 10) / 10);
        $prevPeriod = (int) ($this->step / $redrawFreq);
        $currPeriod = (int) ($step / $redrawFreq);
        $this->step = $step;
        $this->percent = $this->max ? (float) $this->step / $this->max : 0;
        $timeInterval = microtime(true) - $this->lastWriteTime;

        // Draw regardless of other limits
        if ($this->max === $step) {
            $this->display();

            return;
        }

        // Throttling
        if ($timeInterval < $this->minSecondsBetweenRedraws) {
            return;
        }

        // Draw each step period, but not too late
        if ($prevPeriod !== $currPeriod || $timeInterval >= $this->maxSecondsBetweenRedraws) {
>>>>>>> v2-test
            $this->display();
        }
    }

<<<<<<< HEAD
    /**
     * Finishes the progress output.
     */
    public function finish()
=======
    public function setMaxSteps(int $max)
    {
        $this->format = null;
        $this->max = max(0, $max);
        $this->stepWidth = $this->max ? Helper::strlen((string) $this->max) : 4;
    }

    /**
     * Finishes the progress output.
     */
    public function finish(): void
>>>>>>> v2-test
    {
        if (!$this->max) {
            $this->max = $this->step;
        }

        if ($this->step === $this->max && !$this->overwrite) {
            // prevent double 100% output
            return;
        }

        $this->setProgress($this->max);
    }

    /**
     * Outputs the current progress string.
     */
<<<<<<< HEAD
    public function display()
=======
    public function display(): void
>>>>>>> v2-test
    {
        if (OutputInterface::VERBOSITY_QUIET === $this->output->getVerbosity()) {
            return;
        }

        if (null === $this->format) {
            $this->setRealFormat($this->internalFormat ?: $this->determineBestFormat());
        }

        $this->overwrite($this->buildLine());
    }

    /**
     * Removes the progress bar from the current line.
     *
     * This is useful if you wish to write some output
     * while a progress bar is running.
     * Call display() to show the progress bar again.
     */
<<<<<<< HEAD
    public function clear()
=======
    public function clear(): void
>>>>>>> v2-test
    {
        if (!$this->overwrite) {
            return;
        }

        if (null === $this->format) {
            $this->setRealFormat($this->internalFormat ?: $this->determineBestFormat());
        }

        $this->overwrite('');
    }

<<<<<<< HEAD
    /**
     * Sets the progress bar format.
     *
     * @param string $format The format
     */
    private function setRealFormat($format)
=======
    private function setRealFormat(string $format)
>>>>>>> v2-test
    {
        // try to use the _nomax variant if available
        if (!$this->max && null !== self::getFormatDefinition($format.'_nomax')) {
            $this->format = self::getFormatDefinition($format.'_nomax');
        } elseif (null !== self::getFormatDefinition($format)) {
            $this->format = self::getFormatDefinition($format);
        } else {
            $this->format = $format;
        }

        $this->formatLineCount = substr_count($this->format, "\n");
    }

    /**
<<<<<<< HEAD
     * Sets the progress bar maximal steps.
     *
     * @param int $max The progress bar max steps
     */
    private function setMaxSteps($max)
    {
        $this->max = max(0, (int) $max);
        $this->stepWidth = $this->max ? Helper::strlen($this->max) : 4;
    }

    /**
     * Overwrites a previous message to the output.
     *
     * @param string $message The message
     */
    private function overwrite($message)
    {
        if ($this->overwrite) {
            if (!$this->firstRun) {
                // Move the cursor to the beginning of the line
                $this->output->write("\x0D");

                // Erase the line
                $this->output->write("\x1B[2K");

                // Erase previous lines
                if ($this->formatLineCount > 0) {
                    $this->output->write(str_repeat("\x1B[1A\x1B[2K", $this->formatLineCount));
                }
            }
        } elseif ($this->step > 0) {
            $this->output->writeln('');
        }

        $this->firstRun = false;

        $this->output->write($message);
    }

    private function determineBestFormat()
=======
     * Overwrites a previous message to the output.
     */
    private function overwrite(string $message): void
    {
        if ($this->previousMessage === $message) {
            return;
        }

        $originalMessage = $message;

        if ($this->overwrite) {
            if (null !== $this->previousMessage) {
                if ($this->output instanceof ConsoleSectionOutput) {
                    $lines = floor(Helper::strlen($message) / $this->terminal->getWidth()) + $this->formatLineCount + 1;
                    $this->output->clear($lines);
                } else {
                    if ($this->formatLineCount > 0) {
                        $this->cursor->moveUp($this->formatLineCount);
                    }

                    $this->cursor->moveToColumn(1);
                    $this->cursor->clearLine();
                }
            }
        } elseif ($this->step > 0) {
            $message = \PHP_EOL.$message;
        }

        $this->previousMessage = $originalMessage;
        $this->lastWriteTime = microtime(true);

        $this->output->write($message);
        ++$this->writeCount;
    }

    private function determineBestFormat(): string
>>>>>>> v2-test
    {
        switch ($this->output->getVerbosity()) {
            // OutputInterface::VERBOSITY_QUIET: display is disabled anyway
            case OutputInterface::VERBOSITY_VERBOSE:
                return $this->max ? 'verbose' : 'verbose_nomax';
            case OutputInterface::VERBOSITY_VERY_VERBOSE:
                return $this->max ? 'very_verbose' : 'very_verbose_nomax';
            case OutputInterface::VERBOSITY_DEBUG:
                return $this->max ? 'debug' : 'debug_nomax';
            default:
                return $this->max ? 'normal' : 'normal_nomax';
        }
    }

<<<<<<< HEAD
    private static function initPlaceholderFormatters()
    {
        return array(
            'bar' => function (ProgressBar $bar, OutputInterface $output) {
                $completeBars = floor($bar->getMaxSteps() > 0 ? $bar->getProgressPercent() * $bar->getBarWidth() : $bar->getProgress() % $bar->getBarWidth());
=======
    private static function initPlaceholderFormatters(): array
    {
        return [
            'bar' => function (self $bar, OutputInterface $output) {
                $completeBars = $bar->getBarOffset();
>>>>>>> v2-test
                $display = str_repeat($bar->getBarCharacter(), $completeBars);
                if ($completeBars < $bar->getBarWidth()) {
                    $emptyBars = $bar->getBarWidth() - $completeBars - Helper::strlenWithoutDecoration($output->getFormatter(), $bar->getProgressCharacter());
                    $display .= $bar->getProgressCharacter().str_repeat($bar->getEmptyBarCharacter(), $emptyBars);
                }

                return $display;
            },
<<<<<<< HEAD
            'elapsed' => function (ProgressBar $bar) {
                return Helper::formatTime(time() - $bar->getStartTime());
            },
            'remaining' => function (ProgressBar $bar) {
=======
            'elapsed' => function (self $bar) {
                return Helper::formatTime(time() - $bar->getStartTime());
            },
            'remaining' => function (self $bar) {
>>>>>>> v2-test
                if (!$bar->getMaxSteps()) {
                    throw new LogicException('Unable to display the remaining time if the maximum number of steps is not set.');
                }

<<<<<<< HEAD
                if (!$bar->getProgress()) {
                    $remaining = 0;
                } else {
                    $remaining = round((time() - $bar->getStartTime()) / $bar->getProgress() * ($bar->getMaxSteps() - $bar->getProgress()));
                }

                return Helper::formatTime($remaining);
            },
            'estimated' => function (ProgressBar $bar) {
=======
                return Helper::formatTime($bar->getRemaining());
            },
            'estimated' => function (self $bar) {
>>>>>>> v2-test
                if (!$bar->getMaxSteps()) {
                    throw new LogicException('Unable to display the estimated time if the maximum number of steps is not set.');
                }

<<<<<<< HEAD
                if (!$bar->getProgress()) {
                    $estimated = 0;
                } else {
                    $estimated = round((time() - $bar->getStartTime()) / $bar->getProgress() * $bar->getMaxSteps());
                }

                return Helper::formatTime($estimated);
            },
            'memory' => function (ProgressBar $bar) {
                return Helper::formatMemory(memory_get_usage(true));
            },
            'current' => function (ProgressBar $bar) {
                return str_pad($bar->getProgress(), $bar->getStepWidth(), ' ', STR_PAD_LEFT);
            },
            'max' => function (ProgressBar $bar) {
                return $bar->getMaxSteps();
            },
            'percent' => function (ProgressBar $bar) {
                return floor($bar->getProgressPercent() * 100);
            },
        );
    }

    private static function initFormats()
    {
        return array(
=======
                return Helper::formatTime($bar->getEstimated());
            },
            'memory' => function (self $bar) {
                return Helper::formatMemory(memory_get_usage(true));
            },
            'current' => function (self $bar) {
                return str_pad($bar->getProgress(), $bar->getStepWidth(), ' ', \STR_PAD_LEFT);
            },
            'max' => function (self $bar) {
                return $bar->getMaxSteps();
            },
            'percent' => function (self $bar) {
                return floor($bar->getProgressPercent() * 100);
            },
        ];
    }

    private static function initFormats(): array
    {
        return [
>>>>>>> v2-test
            'normal' => ' %current%/%max% [%bar%] %percent:3s%%',
            'normal_nomax' => ' %current% [%bar%]',

            'verbose' => ' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%',
            'verbose_nomax' => ' %current% [%bar%] %elapsed:6s%',

            'very_verbose' => ' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%',
            'very_verbose_nomax' => ' %current% [%bar%] %elapsed:6s%',

            'debug' => ' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%',
            'debug_nomax' => ' %current% [%bar%] %elapsed:6s% %memory:6s%',
<<<<<<< HEAD
        );
    }

    /**
     * @return string
     */
    private function buildLine()
=======
        ];
    }

    private function buildLine(): string
>>>>>>> v2-test
    {
        $regex = "{%([a-z\-_]+)(?:\:([^%]+))?%}i";
        $callback = function ($matches) {
            if ($formatter = $this::getPlaceholderFormatterDefinition($matches[1])) {
<<<<<<< HEAD
                $text = \call_user_func($formatter, $this, $this->output);
=======
                $text = $formatter($this, $this->output);
>>>>>>> v2-test
            } elseif (isset($this->messages[$matches[1]])) {
                $text = $this->messages[$matches[1]];
            } else {
                return $matches[0];
            }

            if (isset($matches[2])) {
                $text = sprintf('%'.$matches[2], $text);
            }

            return $text;
        };
        $line = preg_replace_callback($regex, $callback, $this->format);

        // gets string length for each sub line with multiline format
        $linesLength = array_map(function ($subLine) {
            return Helper::strlenWithoutDecoration($this->output->getFormatter(), rtrim($subLine, "\r"));
        }, explode("\n", $line));

        $linesWidth = max($linesLength);

        $terminalWidth = $this->terminal->getWidth();
        if ($linesWidth <= $terminalWidth) {
            return $line;
        }

        $this->setBarWidth($this->barWidth - $linesWidth + $terminalWidth);

        return preg_replace_callback($regex, $callback, $this->format);
    }
}
