<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tester;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
<<<<<<< HEAD
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
=======
>>>>>>> v2-test

/**
 * Eases the testing of console commands.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class CommandTester
{
<<<<<<< HEAD
    private $command;
    private $input;
    private $output;
    private $inputs = array();
=======
    use TesterTrait;

    private $command;
    private $input;
>>>>>>> v2-test
    private $statusCode;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * Executes the command.
     *
     * Available execution options:
     *
<<<<<<< HEAD
     *  * interactive: Sets the input interactive flag
     *  * decorated:   Sets the output decorated flag
     *  * verbosity:   Sets the output verbosity flag
=======
     *  * interactive:               Sets the input interactive flag
     *  * decorated:                 Sets the output decorated flag
     *  * verbosity:                 Sets the output verbosity flag
     *  * capture_stderr_separately: Make output of stdOut and stdErr separately available
>>>>>>> v2-test
     *
     * @param array $input   An array of command arguments and options
     * @param array $options An array of execution options
     *
     * @return int The command exit code
     */
<<<<<<< HEAD
    public function execute(array $input, array $options = array())
=======
    public function execute(array $input, array $options = [])
>>>>>>> v2-test
    {
        // set the command name automatically if the application requires
        // this argument and no command name was passed
        if (!isset($input['command'])
            && (null !== $application = $this->command->getApplication())
            && $application->getDefinition()->hasArgument('command')
        ) {
<<<<<<< HEAD
            $input = array_merge(array('command' => $this->command->getName()), $input);
        }

        $this->input = new ArrayInput($input);
        if ($this->inputs) {
            $this->input->setStream(self::createStream($this->inputs));
        }
=======
            $input = array_merge(['command' => $this->command->getName()], $input);
        }

        $this->input = new ArrayInput($input);
        // Use an in-memory input stream even if no inputs are set so that QuestionHelper::ask() does not rely on the blocking STDIN.
        $this->input->setStream(self::createStream($this->inputs));
>>>>>>> v2-test

        if (isset($options['interactive'])) {
            $this->input->setInteractive($options['interactive']);
        }

<<<<<<< HEAD
        $this->output = new StreamOutput(fopen('php://memory', 'w', false));
        $this->output->setDecorated(isset($options['decorated']) ? $options['decorated'] : false);
        if (isset($options['verbosity'])) {
            $this->output->setVerbosity($options['verbosity']);
        }

        return $this->statusCode = $this->command->run($this->input, $this->output);
    }

    /**
     * Gets the display returned by the last execution of the command.
     *
     * @param bool $normalize Whether to normalize end of lines to \n or not
     *
     * @return string The display
     */
    public function getDisplay($normalize = false)
    {
        rewind($this->output->getStream());

        $display = stream_get_contents($this->output->getStream());

        if ($normalize) {
            $display = str_replace(PHP_EOL, "\n", $display);
        }

        return $display;
    }

    /**
     * Gets the input instance used by the last execution of the command.
     *
     * @return InputInterface The current input instance
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Gets the output instance used by the last execution of the command.
     *
     * @return OutputInterface The current output instance
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Gets the status code returned by the last execution of the application.
     *
     * @return int The status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the user inputs.
     *
     * @param array $inputs An array of strings representing each input
     *                      passed to the command input stream
     *
     * @return CommandTester
     */
    public function setInputs(array $inputs)
    {
        $this->inputs = $inputs;

        return $this;
    }

    private static function createStream(array $inputs)
    {
        $stream = fopen('php://memory', 'r+', false);

        fwrite($stream, implode(PHP_EOL, $inputs));
        rewind($stream);

        return $stream;
=======
        if (!isset($options['decorated'])) {
            $options['decorated'] = false;
        }

        $this->initOutput($options);

        return $this->statusCode = $this->command->run($this->input, $this->output);
>>>>>>> v2-test
    }
}
