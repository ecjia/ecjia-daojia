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

/**
 * Output style helpers.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
interface StyleInterface
{
    /**
     * Formats a command title.
<<<<<<< HEAD
     *
     * @param string $message
     */
    public function title($message);

    /**
     * Formats a section title.
     *
     * @param string $message
     */
    public function section($message);
=======
     */
    public function title(string $message);

    /**
     * Formats a section title.
     */
    public function section(string $message);
>>>>>>> v2-test

    /**
     * Formats a list.
     */
    public function listing(array $elements);

    /**
     * Formats informational text.
     *
     * @param string|array $message
     */
    public function text($message);

    /**
     * Formats a success result bar.
     *
     * @param string|array $message
     */
    public function success($message);

    /**
     * Formats an error result bar.
     *
     * @param string|array $message
     */
    public function error($message);

    /**
     * Formats an warning result bar.
     *
     * @param string|array $message
     */
    public function warning($message);

    /**
     * Formats a note admonition.
     *
     * @param string|array $message
     */
    public function note($message);

    /**
     * Formats a caution admonition.
     *
     * @param string|array $message
     */
    public function caution($message);

    /**
     * Formats a table.
     */
    public function table(array $headers, array $rows);

    /**
     * Asks a question.
     *
<<<<<<< HEAD
     * @param string        $question
     * @param string|null   $default
     * @param callable|null $validator
     *
     * @return mixed
     */
    public function ask($question, $default = null, $validator = null);
=======
     * @return mixed
     */
    public function ask(string $question, ?string $default = null, callable $validator = null);
>>>>>>> v2-test

    /**
     * Asks a question with the user input hidden.
     *
<<<<<<< HEAD
     * @param string        $question
     * @param callable|null $validator
     *
     * @return mixed
     */
    public function askHidden($question, $validator = null);
=======
     * @return mixed
     */
    public function askHidden(string $question, callable $validator = null);
>>>>>>> v2-test

    /**
     * Asks for confirmation.
     *
<<<<<<< HEAD
     * @param string $question
     * @param bool   $default
     *
     * @return bool
     */
    public function confirm($question, $default = true);
=======
     * @return bool
     */
    public function confirm(string $question, bool $default = true);
>>>>>>> v2-test

    /**
     * Asks a choice question.
     *
<<<<<<< HEAD
     * @param string          $question
     * @param array           $choices
=======
>>>>>>> v2-test
     * @param string|int|null $default
     *
     * @return mixed
     */
<<<<<<< HEAD
    public function choice($question, array $choices, $default = null);

    /**
     * Add newline(s).
     *
     * @param int $count The number of newlines
     */
    public function newLine($count = 1);

    /**
     * Starts the progress output.
     *
     * @param int $max Maximum steps (0 if unknown)
     */
    public function progressStart($max = 0);

    /**
     * Advances the progress output X steps.
     *
     * @param int $step Number of steps to advance
     */
    public function progressAdvance($step = 1);
=======
    public function choice(string $question, array $choices, $default = null);

    /**
     * Add newline(s).
     */
    public function newLine(int $count = 1);

    /**
     * Starts the progress output.
     */
    public function progressStart(int $max = 0);

    /**
     * Advances the progress output X steps.
     */
    public function progressAdvance(int $step = 1);
>>>>>>> v2-test

    /**
     * Finishes the progress output.
     */
    public function progressFinish();
}
