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

<<<<<<< HEAD
=======
use Symfony\Component\Console\Exception\InvalidArgumentException;
>>>>>>> v2-test
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Console\Helper\Table;
<<<<<<< HEAD
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
=======
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\TrimmedBufferOutput;
>>>>>>> v2-test
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Terminal;

/**
 * Output decorator helpers for the Symfony Style Guide.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class SymfonyStyle extends OutputStyle
{
<<<<<<< HEAD
    const MAX_LINE_LENGTH = 120;
=======
    public const MAX_LINE_LENGTH = 120;
>>>>>>> v2-test

    private $input;
    private $questionHelper;
    private $progressBar;
    private $lineLength;
    private $bufferedOutput;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
<<<<<<< HEAD
        $this->bufferedOutput = new BufferedOutput($output->getVerbosity(), false, clone $output->getFormatter());
=======
        $this->bufferedOutput = new TrimmedBufferOutput(\DIRECTORY_SEPARATOR === '\\' ? 4 : 2, $output->getVerbosity(), false, clone $output->getFormatter());
>>>>>>> v2-test
        // Windows cmd wraps lines as soon as the terminal width is reached, whether there are following chars or not.
        $width = (new Terminal())->getWidth() ?: self::MAX_LINE_LENGTH;
        $this->lineLength = min($width - (int) (\DIRECTORY_SEPARATOR === '\\'), self::MAX_LINE_LENGTH);

        parent::__construct($output);
    }

    /**
     * Formats a message as a block of text.
     *
     * @param string|array $messages The message to write in the block
<<<<<<< HEAD
     * @param string|null  $type     The block type (added in [] on first line)
     * @param string|null  $style    The style to apply to the whole block
     * @param string       $prefix   The prefix for the block
     * @param bool         $padding  Whether to add vertical padding
     * @param bool         $escape   Whether to escape the message
     */
    public function block($messages, $type = null, $style = null, $prefix = ' ', $padding = false, $escape = true)
    {
        $messages = \is_array($messages) ? array_values($messages) : array($messages);
=======
     */
    public function block($messages, ?string $type = null, ?string $style = null, string $prefix = ' ', bool $padding = false, bool $escape = true)
    {
        $messages = \is_array($messages) ? array_values($messages) : [$messages];
>>>>>>> v2-test

        $this->autoPrependBlock();
        $this->writeln($this->createBlock($messages, $type, $style, $prefix, $padding, $escape));
        $this->newLine();
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function title($message)
    {
        $this->autoPrependBlock();
        $this->writeln(array(
            sprintf('<comment>%s</>', OutputFormatter::escapeTrailingBackslash($message)),
            sprintf('<comment>%s</>', str_repeat('=', Helper::strlenWithoutDecoration($this->getFormatter(), $message))),
        ));
=======
    public function title(string $message)
    {
        $this->autoPrependBlock();
        $this->writeln([
            sprintf('<comment>%s</>', OutputFormatter::escapeTrailingBackslash($message)),
            sprintf('<comment>%s</>', str_repeat('=', Helper::strlenWithoutDecoration($this->getFormatter(), $message))),
        ]);
>>>>>>> v2-test
        $this->newLine();
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function section($message)
    {
        $this->autoPrependBlock();
        $this->writeln(array(
            sprintf('<comment>%s</>', OutputFormatter::escapeTrailingBackslash($message)),
            sprintf('<comment>%s</>', str_repeat('-', Helper::strlenWithoutDecoration($this->getFormatter(), $message))),
        ));
=======
    public function section(string $message)
    {
        $this->autoPrependBlock();
        $this->writeln([
            sprintf('<comment>%s</>', OutputFormatter::escapeTrailingBackslash($message)),
            sprintf('<comment>%s</>', str_repeat('-', Helper::strlenWithoutDecoration($this->getFormatter(), $message))),
        ]);
>>>>>>> v2-test
        $this->newLine();
    }

    /**
     * {@inheritdoc}
     */
    public function listing(array $elements)
    {
        $this->autoPrependText();
        $elements = array_map(function ($element) {
            return sprintf(' * %s', $element);
        }, $elements);

        $this->writeln($elements);
        $this->newLine();
    }

    /**
     * {@inheritdoc}
     */
    public function text($message)
    {
        $this->autoPrependText();

<<<<<<< HEAD
        $messages = \is_array($message) ? array_values($message) : array($message);
=======
        $messages = \is_array($message) ? array_values($message) : [$message];
>>>>>>> v2-test
        foreach ($messages as $message) {
            $this->writeln(sprintf(' %s', $message));
        }
    }

    /**
     * Formats a command comment.
     *
     * @param string|array $message
     */
    public function comment($message)
    {
        $this->block($message, null, null, '<fg=default;bg=default> // </>', false, false);
    }

    /**
     * {@inheritdoc}
     */
    public function success($message)
    {
        $this->block($message, 'OK', 'fg=black;bg=green', ' ', true);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message)
    {
        $this->block($message, 'ERROR', 'fg=white;bg=red', ' ', true);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message)
    {
<<<<<<< HEAD
        $this->block($message, 'WARNING', 'fg=white;bg=red', ' ', true);
=======
        $this->block($message, 'WARNING', 'fg=black;bg=yellow', ' ', true);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function note($message)
    {
        $this->block($message, 'NOTE', 'fg=yellow', ' ! ');
    }

    /**
<<<<<<< HEAD
=======
     * Formats an info message.
     *
     * @param string|array $message
     */
    public function info($message)
    {
        $this->block($message, 'INFO', 'fg=green', ' ', true);
    }

    /**
>>>>>>> v2-test
     * {@inheritdoc}
     */
    public function caution($message)
    {
        $this->block($message, 'CAUTION', 'fg=white;bg=red', ' ! ', true);
    }

    /**
     * {@inheritdoc}
     */
    public function table(array $headers, array $rows)
    {
        $style = clone Table::getStyleDefinition('symfony-style-guide');
        $style->setCellHeaderFormat('<info>%s</info>');

        $table = new Table($this);
        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->setStyle($style);

        $table->render();
        $this->newLine();
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function ask($question, $default = null, $validator = null)
=======
     * Formats a horizontal table.
     */
    public function horizontalTable(array $headers, array $rows)
    {
        $style = clone Table::getStyleDefinition('symfony-style-guide');
        $style->setCellHeaderFormat('<info>%s</info>');

        $table = new Table($this);
        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->setStyle($style);
        $table->setHorizontal(true);

        $table->render();
        $this->newLine();
    }

    /**
     * Formats a list of key/value horizontally.
     *
     * Each row can be one of:
     * * 'A title'
     * * ['key' => 'value']
     * * new TableSeparator()
     *
     * @param string|array|TableSeparator ...$list
     */
    public function definitionList(...$list)
    {
        $style = clone Table::getStyleDefinition('symfony-style-guide');
        $style->setCellHeaderFormat('<info>%s</info>');

        $table = new Table($this);
        $headers = [];
        $row = [];
        foreach ($list as $value) {
            if ($value instanceof TableSeparator) {
                $headers[] = $value;
                $row[] = $value;
                continue;
            }
            if (\is_string($value)) {
                $headers[] = new TableCell($value, ['colspan' => 2]);
                $row[] = null;
                continue;
            }
            if (!\is_array($value)) {
                throw new InvalidArgumentException('Value should be an array, string, or an instance of TableSeparator.');
            }
            $headers[] = key($value);
            $row[] = current($value);
        }

        $table->setHeaders($headers);
        $table->setRows([$row]);
        $table->setHorizontal();
        $table->setStyle($style);

        $table->render();
        $this->newLine();
    }

    /**
     * {@inheritdoc}
     */
    public function ask(string $question, ?string $default = null, $validator = null)
>>>>>>> v2-test
    {
        $question = new Question($question, $default);
        $question->setValidator($validator);

        return $this->askQuestion($question);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function askHidden($question, $validator = null)
=======
    public function askHidden(string $question, $validator = null)
>>>>>>> v2-test
    {
        $question = new Question($question);

        $question->setHidden(true);
        $question->setValidator($validator);

        return $this->askQuestion($question);
    }

    /**
     * {@inheritdoc}
     */
    public function confirm($question, $default = true)
    {
        return $this->askQuestion(new ConfirmationQuestion($question, $default));
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function choice($question, array $choices, $default = null)
    {
        if (null !== $default) {
            $values = array_flip($choices);
            $default = $values[$default];
=======
    public function choice(string $question, array $choices, $default = null)
    {
        if (null !== $default) {
            $values = array_flip($choices);
            $default = $values[$default] ?? $default;
>>>>>>> v2-test
        }

        return $this->askQuestion(new ChoiceQuestion($question, $choices, $default));
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function progressStart($max = 0)
=======
    public function progressStart(int $max = 0)
>>>>>>> v2-test
    {
        $this->progressBar = $this->createProgressBar($max);
        $this->progressBar->start();
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function progressAdvance($step = 1)
=======
    public function progressAdvance(int $step = 1)
>>>>>>> v2-test
    {
        $this->getProgressBar()->advance($step);
    }

    /**
     * {@inheritdoc}
     */
    public function progressFinish()
    {
        $this->getProgressBar()->finish();
        $this->newLine(2);
        $this->progressBar = null;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function createProgressBar($max = 0)
=======
    public function createProgressBar(int $max = 0)
>>>>>>> v2-test
    {
        $progressBar = parent::createProgressBar($max);

        if ('\\' !== \DIRECTORY_SEPARATOR || 'Hyper' === getenv('TERM_PROGRAM')) {
            $progressBar->setEmptyBarCharacter('░'); // light shade character \u2591
            $progressBar->setProgressCharacter('');
            $progressBar->setBarCharacter('▓'); // dark shade character \u2593
        }

        return $progressBar;
    }

    /**
     * @return mixed
     */
    public function askQuestion(Question $question)
    {
        if ($this->input->isInteractive()) {
            $this->autoPrependBlock();
        }

        if (!$this->questionHelper) {
            $this->questionHelper = new SymfonyQuestionHelper();
        }

        $answer = $this->questionHelper->ask($this->input, $this, $question);

        if ($this->input->isInteractive()) {
            $this->newLine();
            $this->bufferedOutput->write("\n");
        }

        return $answer;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function writeln($messages, $type = self::OUTPUT_NORMAL)
    {
        parent::writeln($messages, $type);
        $this->bufferedOutput->writeln($this->reduceBuffer($messages), $type);
=======
    public function writeln($messages, int $type = self::OUTPUT_NORMAL)
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }

        foreach ($messages as $message) {
            parent::writeln($message, $type);
            $this->writeBuffer($message, true, $type);
        }
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function write($messages, $newline = false, $type = self::OUTPUT_NORMAL)
    {
        parent::write($messages, $newline, $type);
        $this->bufferedOutput->write($this->reduceBuffer($messages), $newline, $type);
=======
    public function write($messages, bool $newline = false, int $type = self::OUTPUT_NORMAL)
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }

        foreach ($messages as $message) {
            parent::write($message, $newline, $type);
            $this->writeBuffer($message, $newline, $type);
        }
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function newLine($count = 1)
=======
    public function newLine(int $count = 1)
>>>>>>> v2-test
    {
        parent::newLine($count);
        $this->bufferedOutput->write(str_repeat("\n", $count));
    }

    /**
     * Returns a new instance which makes use of stderr if available.
     *
     * @return self
     */
    public function getErrorStyle()
    {
        return new self($this->input, $this->getErrorOutput());
    }

<<<<<<< HEAD
    /**
     * @return ProgressBar
     */
    private function getProgressBar()
=======
    private function getProgressBar(): ProgressBar
>>>>>>> v2-test
    {
        if (!$this->progressBar) {
            throw new RuntimeException('The ProgressBar is not started.');
        }

        return $this->progressBar;
    }

<<<<<<< HEAD
    private function autoPrependBlock()
    {
        $chars = substr(str_replace(PHP_EOL, "\n", $this->bufferedOutput->fetch()), -2);

        if (!isset($chars[0])) {
            return $this->newLine(); //empty history, so we should start with a new line.
=======
    private function autoPrependBlock(): void
    {
        $chars = substr(str_replace(\PHP_EOL, "\n", $this->bufferedOutput->fetch()), -2);

        if (!isset($chars[0])) {
            $this->newLine(); //empty history, so we should start with a new line.

            return;
>>>>>>> v2-test
        }
        //Prepend new line for each non LF chars (This means no blank line was output before)
        $this->newLine(2 - substr_count($chars, "\n"));
    }

<<<<<<< HEAD
    private function autoPrependText()
=======
    private function autoPrependText(): void
>>>>>>> v2-test
    {
        $fetched = $this->bufferedOutput->fetch();
        //Prepend new line if last char isn't EOL:
        if ("\n" !== substr($fetched, -1)) {
            $this->newLine();
        }
    }

<<<<<<< HEAD
    private function reduceBuffer($messages)
    {
        // We need to know if the two last chars are PHP_EOL
        // Preserve the last 4 chars inserted (PHP_EOL on windows is two chars) in the history buffer
        return array_map(function ($value) {
            return substr($value, -4);
        }, array_merge(array($this->bufferedOutput->fetch()), (array) $messages));
    }

    private function createBlock($messages, $type = null, $style = null, $prefix = ' ', $padding = false, $escape = false)
    {
        $indentLength = 0;
        $prefixLength = Helper::strlenWithoutDecoration($this->getFormatter(), $prefix);
        $lines = array();
=======
    private function writeBuffer(string $message, bool $newLine, int $type): void
    {
        // We need to know if the last chars are PHP_EOL
        $this->bufferedOutput->write($message, $newLine, $type);
    }

    private function createBlock(iterable $messages, string $type = null, string $style = null, string $prefix = ' ', bool $padding = false, bool $escape = false): array
    {
        $indentLength = 0;
        $prefixLength = Helper::strlenWithoutDecoration($this->getFormatter(), $prefix);
        $lines = [];
>>>>>>> v2-test

        if (null !== $type) {
            $type = sprintf('[%s] ', $type);
            $indentLength = \strlen($type);
            $lineIndentation = str_repeat(' ', $indentLength);
        }

        // wrap and add newlines for each element
        foreach ($messages as $key => $message) {
            if ($escape) {
                $message = OutputFormatter::escape($message);
            }

<<<<<<< HEAD
            $lines = array_merge($lines, explode(PHP_EOL, wordwrap($message, $this->lineLength - $prefixLength - $indentLength, PHP_EOL, true)));
=======
            $lines = array_merge($lines, explode(\PHP_EOL, wordwrap($message, $this->lineLength - $prefixLength - $indentLength, \PHP_EOL, true)));
>>>>>>> v2-test

            if (\count($messages) > 1 && $key < \count($messages) - 1) {
                $lines[] = '';
            }
        }

        $firstLineIndex = 0;
        if ($padding && $this->isDecorated()) {
            $firstLineIndex = 1;
            array_unshift($lines, '');
            $lines[] = '';
        }

        foreach ($lines as $i => &$line) {
            if (null !== $type) {
                $line = $firstLineIndex === $i ? $type.$line : $lineIndentation.$line;
            }

            $line = $prefix.$line;
            $line .= str_repeat(' ', $this->lineLength - Helper::strlenWithoutDecoration($this->getFormatter(), $line));

            if ($style) {
                $line = sprintf('<%s>%s</>', $style, $line);
            }
        }

        return $lines;
    }
}
