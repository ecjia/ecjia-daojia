<?php

namespace Fake;

use PhpSpec\Console\Prompter as PrompterInterface;

class Prompter implements PrompterInterface
{
    private $answers = array();
    private $hasBeenAsked = false;
    private $question;
<<<<<<< HEAD
=======
    private $unansweredQuestions = false;
>>>>>>> v2-test

    public function setAnswer($answer)
    {
        $this->answers[] = $answer;
    }

<<<<<<< HEAD
    public function askConfirmation($question, $default = true)
    {
        $this->hasBeenAsked = true;
        $this->question = $question;
=======
    public function askConfirmation(string $question, bool $default = true) : bool
    {
        $this->hasBeenAsked = true;
        $this->question = $question;

        $this->unansweredQuestions = count($this->answers) > 1;
>>>>>>> v2-test
        return (bool)array_shift($this->answers);
    }

    public function hasBeenAsked($question = null)
    {
        if (!$question) {
            return $this->hasBeenAsked;
        }

        return $this->hasBeenAsked
<<<<<<< HEAD
            && preg_replace('/\s+/', ' ', trim(strip_tags($this->question))) == preg_replace('/\s+/', ' ', $question) ;
=======
            && $this->normalise($this->question) == $this->normalise($question);
    }

    public function hasUnansweredQuestions()
    {
        return $this->unansweredQuestions;
    }

    /**
     * @return mixed
     */
    private function normalise($question)
    {
        return preg_replace('/\s+/', '', trim(strip_tags($question)));
>>>>>>> v2-test
    }
}
