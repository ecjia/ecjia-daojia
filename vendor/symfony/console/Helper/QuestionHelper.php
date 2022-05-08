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
use Symfony\Component\Console\Exception\InvalidArgumentException;
=======
use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Exception\MissingInputException;
>>>>>>> v2-test
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StreamableInputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
<<<<<<< HEAD
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
=======
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Terminal;
use function Symfony\Component\String\s;
>>>>>>> v2-test

/**
 * The QuestionHelper class provides helpers to interact with the user.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class QuestionHelper extends Helper
{
    private $inputStream;
    private static $shell;
<<<<<<< HEAD
    private static $stty;
=======
    private static $stty = true;
    private static $stdinIsInteractive;
>>>>>>> v2-test

    /**
     * Asks a question to the user.
     *
     * @return mixed The user answer
     *
     * @throws RuntimeException If there is no data to read in the input stream
     */
    public function ask(InputInterface $input, OutputInterface $output, Question $question)
    {
        if ($output instanceof ConsoleOutputInterface) {
            $output = $output->getErrorOutput();
        }

        if (!$input->isInteractive()) {
<<<<<<< HEAD
            if ($question instanceof ChoiceQuestion) {
                $choices = $question->getChoices();

                return $choices[$question->getDefault()];
            }

            return $question->getDefault();
=======
            return $this->getDefaultAnswer($question);
>>>>>>> v2-test
        }

        if ($input instanceof StreamableInputInterface && $stream = $input->getStream()) {
            $this->inputStream = $stream;
        }

<<<<<<< HEAD
        if (!$question->getValidator()) {
            return $this->doAsk($output, $question);
        }

        $interviewer = function () use ($output, $question) {
            return $this->doAsk($output, $question);
        };

        return $this->validateAttempts($interviewer, $output, $question);
    }

    /**
     * Sets the input stream to read from when interacting with the user.
     *
     * This is mainly useful for testing purpose.
     *
     * @deprecated since version 3.2, to be removed in 4.0. Use
     *             StreamableInputInterface::setStream() instead.
     *
     * @param resource $stream The input stream
     *
     * @throws InvalidArgumentException In case the stream is not a resource
     */
    public function setInputStream($stream)
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.2 and will be removed in 4.0. Use %s::setStream() instead.', __METHOD__, StreamableInputInterface::class), E_USER_DEPRECATED);

        if (!\is_resource($stream)) {
            throw new InvalidArgumentException('Input stream must be a valid resource.');
        }

        $this->inputStream = $stream;
    }

    /**
     * Returns the helper's input stream.
     *
     * @deprecated since version 3.2, to be removed in 4.0. Use
     *             StreamableInputInterface::getStream() instead.
     *
     * @return resource
     */
    public function getInputStream()
    {
        if (0 === \func_num_args() || func_get_arg(0)) {
            @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.2 and will be removed in 4.0. Use %s::getStream() instead.', __METHOD__, StreamableInputInterface::class), E_USER_DEPRECATED);
        }

        return $this->inputStream;
=======
        try {
            if (!$question->getValidator()) {
                return $this->doAsk($output, $question);
            }

            $interviewer = function () use ($output, $question) {
                return $this->doAsk($output, $question);
            };

            return $this->validateAttempts($interviewer, $output, $question);
        } catch (MissingInputException $exception) {
            $input->setInteractive(false);

            if (null === $fallbackOutput = $this->getDefaultAnswer($question)) {
                throw $exception;
            }

            return $fallbackOutput;
        }
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'question';
    }

    /**
     * Prevents usage of stty.
     */
    public static function disableStty()
    {
        self::$stty = false;
    }

    /**
     * Asks the question to the user.
     *
<<<<<<< HEAD
     * @return bool|mixed|null|string
=======
     * @return bool|mixed|string|null
>>>>>>> v2-test
     *
     * @throws RuntimeException In case the fallback is deactivated and the response cannot be hidden
     */
    private function doAsk(OutputInterface $output, Question $question)
    {
        $this->writePrompt($output, $question);

<<<<<<< HEAD
        $inputStream = $this->inputStream ?: STDIN;
        $autocomplete = $question->getAutocompleterValues();

        if (null === $autocomplete || !$this->hasSttyAvailable()) {
            $ret = false;
            if ($question->isHidden()) {
                try {
                    $ret = trim($this->getHiddenResponse($output, $inputStream));
=======
        $inputStream = $this->inputStream ?: \STDIN;
        $autocomplete = $question->getAutocompleterCallback();

        if (\function_exists('sapi_windows_cp_set')) {
            // Codepage used by cmd.exe on Windows to allow special characters (éàüñ).
            @sapi_windows_cp_set(1252);
        }

        if (null === $autocomplete || !self::$stty || !Terminal::hasSttyAvailable()) {
            $ret = false;
            if ($question->isHidden()) {
                try {
                    $hiddenResponse = $this->getHiddenResponse($output, $inputStream, $question->isTrimmable());
                    $ret = $question->isTrimmable() ? trim($hiddenResponse) : $hiddenResponse;
>>>>>>> v2-test
                } catch (RuntimeException $e) {
                    if (!$question->isHiddenFallback()) {
                        throw $e;
                    }
                }
            }

            if (false === $ret) {
<<<<<<< HEAD
                $ret = fgets($inputStream, 4096);
                if (false === $ret) {
                    throw new RuntimeException('Aborted');
                }
                $ret = trim($ret);
            }
        } else {
            $ret = trim($this->autocomplete($output, $question, $inputStream, \is_array($autocomplete) ? $autocomplete : iterator_to_array($autocomplete, false)));
=======
                $ret = $this->readInput($inputStream, $question);
                if (false === $ret) {
                    throw new MissingInputException('Aborted.');
                }
                if ($question->isTrimmable()) {
                    $ret = trim($ret);
                }
            }
        } else {
            $autocomplete = $this->autocomplete($output, $question, $inputStream, $autocomplete);
            $ret = $question->isTrimmable() ? trim($autocomplete) : $autocomplete;
        }

        if ($output instanceof ConsoleSectionOutput) {
            $output->addContent($ret);
>>>>>>> v2-test
        }

        $ret = \strlen($ret) > 0 ? $ret : $question->getDefault();

        if ($normalizer = $question->getNormalizer()) {
            return $normalizer($ret);
        }

        return $ret;
    }

    /**
<<<<<<< HEAD
=======
     * @return mixed
     */
    private function getDefaultAnswer(Question $question)
    {
        $default = $question->getDefault();

        if (null === $default) {
            return $default;
        }

        if ($validator = $question->getValidator()) {
            return \call_user_func($question->getValidator(), $default);
        } elseif ($question instanceof ChoiceQuestion) {
            $choices = $question->getChoices();

            if (!$question->isMultiselect()) {
                return $choices[$default] ?? $default;
            }

            $default = explode(',', $default);
            foreach ($default as $k => $v) {
                $v = $question->isTrimmable() ? trim($v) : $v;
                $default[$k] = $choices[$v] ?? $v;
            }
        }

        return $default;
    }

    /**
>>>>>>> v2-test
     * Outputs the question prompt.
     */
    protected function writePrompt(OutputInterface $output, Question $question)
    {
        $message = $question->getQuestion();

        if ($question instanceof ChoiceQuestion) {
<<<<<<< HEAD
            $maxWidth = max(array_map(array($this, 'strlen'), array_keys($question->getChoices())));

            $messages = (array) $question->getQuestion();
            foreach ($question->getChoices() as $key => $value) {
                $width = $maxWidth - $this->strlen($key);
                $messages[] = '  [<info>'.$key.str_repeat(' ', $width).'</info>] '.$value;
            }

            $output->writeln($messages);
=======
            $output->writeln(array_merge([
                $question->getQuestion(),
            ], $this->formatChoiceQuestionChoices($question, 'info')));
>>>>>>> v2-test

            $message = $question->getPrompt();
        }

        $output->write($message);
    }

    /**
<<<<<<< HEAD
=======
     * @return string[]
     */
    protected function formatChoiceQuestionChoices(ChoiceQuestion $question, string $tag)
    {
        $messages = [];

        $maxWidth = max(array_map('self::strlen', array_keys($choices = $question->getChoices())));

        foreach ($choices as $key => $value) {
            $padding = str_repeat(' ', $maxWidth - self::strlen($key));

            $messages[] = sprintf("  [<$tag>%s$padding</$tag>] %s", $key, $value);
        }

        return $messages;
    }

    /**
>>>>>>> v2-test
     * Outputs an error message.
     */
    protected function writeError(OutputInterface $output, \Exception $error)
    {
        if (null !== $this->getHelperSet() && $this->getHelperSet()->has('formatter')) {
            $message = $this->getHelperSet()->get('formatter')->formatBlock($error->getMessage(), 'error');
        } else {
            $message = '<error>'.$error->getMessage().'</error>';
        }

        $output->writeln($message);
    }

    /**
     * Autocompletes a question.
     *
<<<<<<< HEAD
     * @param OutputInterface $output
     * @param Question        $question
     * @param resource        $inputStream
     * @param array           $autocomplete
     *
     * @return string
     */
    private function autocomplete(OutputInterface $output, Question $question, $inputStream, array $autocomplete)
    {
=======
     * @param resource $inputStream
     */
    private function autocomplete(OutputInterface $output, Question $question, $inputStream, callable $autocomplete): string
    {
        $cursor = new Cursor($output, $inputStream);

        $fullChoice = '';
>>>>>>> v2-test
        $ret = '';

        $i = 0;
        $ofs = -1;
<<<<<<< HEAD
        $matches = $autocomplete;
=======
        $matches = $autocomplete($ret);
>>>>>>> v2-test
        $numMatches = \count($matches);

        $sttyMode = shell_exec('stty -g');

        // Disable icanon (so we can fread each keypress) and echo (we'll do echoing here instead)
        shell_exec('stty -icanon -echo');

        // Add highlighted text style
        $output->getFormatter()->setStyle('hl', new OutputFormatterStyle('black', 'white'));

        // Read a keypress
        while (!feof($inputStream)) {
            $c = fread($inputStream, 1);

<<<<<<< HEAD
            // Backspace Character
            if ("\177" === $c) {
                if (0 === $numMatches && 0 !== $i) {
                    --$i;
                    // Move cursor backwards
                    $output->write("\033[1D");
=======
            // as opposed to fgets(), fread() returns an empty string when the stream content is empty, not false.
            if (false === $c || ('' === $ret && '' === $c && null === $question->getDefault())) {
                shell_exec(sprintf('stty %s', $sttyMode));
                throw new MissingInputException('Aborted.');
            } elseif ("\177" === $c) { // Backspace Character
                if (0 === $numMatches && 0 !== $i) {
                    --$i;
                    $cursor->moveLeft(s($fullChoice)->slice(-1)->width(false));

                    $fullChoice = self::substr($fullChoice, 0, $i);
>>>>>>> v2-test
                }

                if (0 === $i) {
                    $ofs = -1;
<<<<<<< HEAD
                    $matches = $autocomplete;
=======
                    $matches = $autocomplete($ret);
>>>>>>> v2-test
                    $numMatches = \count($matches);
                } else {
                    $numMatches = 0;
                }

                // Pop the last character off the end of our string
<<<<<<< HEAD
                $ret = substr($ret, 0, $i);
=======
                $ret = self::substr($ret, 0, $i);
>>>>>>> v2-test
            } elseif ("\033" === $c) {
                // Did we read an escape sequence?
                $c .= fread($inputStream, 2);

                // A = Up Arrow. B = Down Arrow
                if (isset($c[2]) && ('A' === $c[2] || 'B' === $c[2])) {
                    if ('A' === $c[2] && -1 === $ofs) {
                        $ofs = 0;
                    }

                    if (0 === $numMatches) {
                        continue;
                    }

                    $ofs += ('A' === $c[2]) ? -1 : 1;
                    $ofs = ($numMatches + $ofs) % $numMatches;
                }
            } elseif (\ord($c) < 32) {
                if ("\t" === $c || "\n" === $c) {
                    if ($numMatches > 0 && -1 !== $ofs) {
<<<<<<< HEAD
                        $ret = $matches[$ofs];
                        // Echo out remaining chars for current match
                        $output->write(substr($ret, $i));
                        $i = \strlen($ret);
=======
                        $ret = (string) $matches[$ofs];
                        // Echo out remaining chars for current match
                        $remainingCharacters = substr($ret, \strlen(trim($this->mostRecentlyEnteredValue($fullChoice))));
                        $output->write($remainingCharacters);
                        $fullChoice .= $remainingCharacters;
                        $i = self::strlen($fullChoice);

                        $matches = array_filter(
                            $autocomplete($ret),
                            function ($match) use ($ret) {
                                return '' === $ret || 0 === strpos($match, $ret);
                            }
                        );
                        $numMatches = \count($matches);
                        $ofs = -1;
>>>>>>> v2-test
                    }

                    if ("\n" === $c) {
                        $output->write($c);
                        break;
                    }

                    $numMatches = 0;
                }

                continue;
            } else {
<<<<<<< HEAD
                $output->write($c);
                $ret .= $c;
                ++$i;

                $numMatches = 0;
                $ofs = 0;

                foreach ($autocomplete as $value) {
                    // If typed characters match the beginning chunk of value (e.g. [AcmeDe]moBundle)
                    if (0 === strpos($value, $ret)) {
=======
                if ("\x80" <= $c) {
                    $c .= fread($inputStream, ["\xC0" => 1, "\xD0" => 1, "\xE0" => 2, "\xF0" => 3][$c & "\xF0"]);
                }

                $output->write($c);
                $ret .= $c;
                $fullChoice .= $c;
                ++$i;

                $tempRet = $ret;

                if ($question instanceof ChoiceQuestion && $question->isMultiselect()) {
                    $tempRet = $this->mostRecentlyEnteredValue($fullChoice);
                }

                $numMatches = 0;
                $ofs = 0;

                foreach ($autocomplete($ret) as $value) {
                    // If typed characters match the beginning chunk of value (e.g. [AcmeDe]moBundle)
                    if (0 === strpos($value, $tempRet)) {
>>>>>>> v2-test
                        $matches[$numMatches++] = $value;
                    }
                }
            }

<<<<<<< HEAD
            // Erase characters from cursor to end of line
            $output->write("\033[K");

            if ($numMatches > 0 && -1 !== $ofs) {
                // Save cursor position
                $output->write("\0337");
                // Write highlighted text
                $output->write('<hl>'.OutputFormatter::escapeTrailingBackslash(substr($matches[$ofs], $i)).'</hl>');
                // Restore cursor position
                $output->write("\0338");
=======
            $cursor->clearLineAfter();

            if ($numMatches > 0 && -1 !== $ofs) {
                $cursor->savePosition();
                // Write highlighted text, complete the partially entered response
                $charactersEntered = \strlen(trim($this->mostRecentlyEnteredValue($fullChoice)));
                $output->write('<hl>'.OutputFormatter::escapeTrailingBackslash(substr($matches[$ofs], $charactersEntered)).'</hl>');
                $cursor->restorePosition();
>>>>>>> v2-test
            }
        }

        // Reset stty so it behaves normally again
        shell_exec(sprintf('stty %s', $sttyMode));

<<<<<<< HEAD
        return $ret;
=======
        return $fullChoice;
    }

    private function mostRecentlyEnteredValue(string $entered): string
    {
        // Determine the most recent value that the user entered
        if (false === strpos($entered, ',')) {
            return $entered;
        }

        $choices = explode(',', $entered);
        if (\strlen($lastChoice = trim($choices[\count($choices) - 1])) > 0) {
            return $lastChoice;
        }

        return $entered;
>>>>>>> v2-test
    }

    /**
     * Gets a hidden response from user.
     *
<<<<<<< HEAD
     * @param OutputInterface $output      An Output instance
     * @param resource        $inputStream The handler resource
     *
     * @return string The answer
     *
     * @throws RuntimeException In case the fallback is deactivated and the response cannot be hidden
     */
    private function getHiddenResponse(OutputInterface $output, $inputStream)
=======
     * @param resource $inputStream The handler resource
     * @param bool     $trimmable   Is the answer trimmable
     *
     * @throws RuntimeException In case the fallback is deactivated and the response cannot be hidden
     */
    private function getHiddenResponse(OutputInterface $output, $inputStream, bool $trimmable = true): string
>>>>>>> v2-test
    {
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $exe = __DIR__.'/../Resources/bin/hiddeninput.exe';

            // handle code running from a phar
            if ('phar:' === substr(__FILE__, 0, 5)) {
                $tmpExe = sys_get_temp_dir().'/hiddeninput.exe';
                copy($exe, $tmpExe);
                $exe = $tmpExe;
            }

<<<<<<< HEAD
            $value = rtrim(shell_exec($exe));
=======
            $sExec = shell_exec($exe);
            $value = $trimmable ? rtrim($sExec) : $sExec;
>>>>>>> v2-test
            $output->writeln('');

            if (isset($tmpExe)) {
                unlink($tmpExe);
            }

            return $value;
        }

<<<<<<< HEAD
        if ($this->hasSttyAvailable()) {
            $sttyMode = shell_exec('stty -g');

            shell_exec('stty -echo');
            $value = fgets($inputStream, 4096);
            shell_exec(sprintf('stty %s', $sttyMode));

            if (false === $value) {
                throw new RuntimeException('Aborted');
            }

            $value = trim($value);
            $output->writeln('');

            return $value;
        }

        if (false !== $shell = $this->getShell()) {
            $readCmd = 'csh' === $shell ? 'set mypassword = $<' : 'read -r mypassword';
            $command = sprintf("/usr/bin/env %s -c 'stty -echo; %s; stty echo; echo \$mypassword'", $shell, $readCmd);
            $value = rtrim(shell_exec($command));
            $output->writeln('');

            return $value;
        }

        throw new RuntimeException('Unable to hide the response.');
=======
        if (self::$stty && Terminal::hasSttyAvailable()) {
            $sttyMode = shell_exec('stty -g');
            shell_exec('stty -echo');
        } elseif ($this->isInteractiveInput($inputStream)) {
            throw new RuntimeException('Unable to hide the response.');
        }

        $value = fgets($inputStream, 4096);

        if (self::$stty && Terminal::hasSttyAvailable()) {
            shell_exec(sprintf('stty %s', $sttyMode));
        }

        if (false === $value) {
            throw new MissingInputException('Aborted.');
        }
        if ($trimmable) {
            $value = trim($value);
        }
        $output->writeln('');

        return $value;
>>>>>>> v2-test
    }

    /**
     * Validates an attempt.
     *
<<<<<<< HEAD
     * @param callable        $interviewer A callable that will ask for a question and return the result
     * @param OutputInterface $output      An Output instance
     * @param Question        $question    A Question instance
=======
     * @param callable $interviewer A callable that will ask for a question and return the result
>>>>>>> v2-test
     *
     * @return mixed The validated response
     *
     * @throws \Exception In case the max number of attempts has been reached and no valid response has been given
     */
    private function validateAttempts(callable $interviewer, OutputInterface $output, Question $question)
    {
        $error = null;
        $attempts = $question->getMaxAttempts();
<<<<<<< HEAD
=======

>>>>>>> v2-test
        while (null === $attempts || $attempts--) {
            if (null !== $error) {
                $this->writeError($output, $error);
            }

            try {
<<<<<<< HEAD
                return \call_user_func($question->getValidator(), $interviewer());
=======
                return $question->getValidator()($interviewer());
>>>>>>> v2-test
            } catch (RuntimeException $e) {
                throw $e;
            } catch (\Exception $error) {
            }
        }

        throw $error;
    }

<<<<<<< HEAD
    /**
     * Returns a valid unix shell.
     *
     * @return string|bool The valid shell name, false in case no valid shell is found
     */
    private function getShell()
    {
        if (null !== self::$shell) {
            return self::$shell;
        }

        self::$shell = false;

        if (file_exists('/usr/bin/env')) {
            // handle other OSs with bash/zsh/ksh/csh if available to hide the answer
            $test = "/usr/bin/env %s -c 'echo OK' 2> /dev/null";
            foreach (array('bash', 'zsh', 'ksh', 'csh') as $sh) {
                if ('OK' === rtrim(shell_exec(sprintf($test, $sh)))) {
                    self::$shell = $sh;
                    break;
                }
            }
        }

        return self::$shell;
    }

    /**
     * Returns whether Stty is available or not.
     *
     * @return bool
     */
    private function hasSttyAvailable()
    {
        if (null !== self::$stty) {
            return self::$stty;
        }

        exec('stty 2>&1', $output, $exitcode);

        return self::$stty = 0 === $exitcode;
=======
    private function isInteractiveInput($inputStream): bool
    {
        if ('php://stdin' !== (stream_get_meta_data($inputStream)['uri'] ?? null)) {
            return false;
        }

        if (null !== self::$stdinIsInteractive) {
            return self::$stdinIsInteractive;
        }

        if (\function_exists('stream_isatty')) {
            return self::$stdinIsInteractive = stream_isatty(fopen('php://stdin', 'r'));
        }

        if (\function_exists('posix_isatty')) {
            return self::$stdinIsInteractive = posix_isatty(fopen('php://stdin', 'r'));
        }

        if (!\function_exists('exec')) {
            return self::$stdinIsInteractive = true;
        }

        exec('stty 2> /dev/null', $output, $status);

        return self::$stdinIsInteractive = 1 !== $status;
    }

    /**
     * Reads one or more lines of input and returns what is read.
     *
     * @param resource $inputStream The handler resource
     * @param Question $question    The question being asked
     *
     * @return string|bool The input received, false in case input could not be read
     */
    private function readInput($inputStream, Question $question)
    {
        if (!$question->isMultiline()) {
            return fgets($inputStream, 4096);
        }

        $multiLineStreamReader = $this->cloneInputStream($inputStream);
        if (null === $multiLineStreamReader) {
            return false;
        }

        $ret = '';
        while (false !== ($char = fgetc($multiLineStreamReader))) {
            if (\PHP_EOL === "{$ret}{$char}") {
                break;
            }
            $ret .= $char;
        }

        return $ret;
    }

    /**
     * Clones an input stream in order to act on one instance of the same
     * stream without affecting the other instance.
     *
     * @param resource $inputStream The handler resource
     *
     * @return resource|null The cloned resource, null in case it could not be cloned
     */
    private function cloneInputStream($inputStream)
    {
        $streamMetaData = stream_get_meta_data($inputStream);
        $seekable = $streamMetaData['seekable'] ?? false;
        $mode = $streamMetaData['mode'] ?? 'rb';
        $uri = $streamMetaData['uri'] ?? null;

        if (null === $uri) {
            return null;
        }

        $cloneStream = fopen($uri, $mode);

        // For seekable and writable streams, add all the same data to the
        // cloned stream and then seek to the same offset.
        if (true === $seekable && !\in_array($mode, ['r', 'rb', 'rt'])) {
            $offset = ftell($inputStream);
            rewind($inputStream);
            stream_copy_to_stream($inputStream, $cloneStream);
            fseek($inputStream, $offset);
            fseek($cloneStream, $offset);
        }

        return $cloneStream;
>>>>>>> v2-test
    }
}
