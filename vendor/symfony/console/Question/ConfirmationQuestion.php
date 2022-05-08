<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Question;

/**
 * Represents a yes/no question.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ConfirmationQuestion extends Question
{
    private $trueAnswerRegex;

    /**
     * @param string $question        The question to ask to the user
     * @param bool   $default         The default answer to return, true or false
     * @param string $trueAnswerRegex A regex to match the "yes" answer
     */
<<<<<<< HEAD
    public function __construct($question, $default = true, $trueAnswerRegex = '/^y/i')
    {
        parent::__construct($question, (bool) $default);
=======
    public function __construct(string $question, bool $default = true, string $trueAnswerRegex = '/^y/i')
    {
        parent::__construct($question, $default);
>>>>>>> v2-test

        $this->trueAnswerRegex = $trueAnswerRegex;
        $this->setNormalizer($this->getDefaultNormalizer());
    }

    /**
     * Returns the default answer normalizer.
<<<<<<< HEAD
     *
     * @return callable
     */
    private function getDefaultNormalizer()
=======
     */
    private function getDefaultNormalizer(): callable
>>>>>>> v2-test
    {
        $default = $this->getDefault();
        $regex = $this->trueAnswerRegex;

        return function ($answer) use ($default, $regex) {
            if (\is_bool($answer)) {
                return $answer;
            }

            $answerIsTrue = (bool) preg_match($regex, $answer);
            if (false === $default) {
                return $answer && $answerIsTrue;
            }

<<<<<<< HEAD
            return !$answer || $answerIsTrue;
=======
            return '' === $answer || $answerIsTrue;
>>>>>>> v2-test
        };
    }
}
