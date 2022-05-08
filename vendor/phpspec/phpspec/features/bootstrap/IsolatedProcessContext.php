<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Symfony\Component\Process\Process;

/**
 * Defines application features from the specific context.
 */
class IsolatedProcessContext implements Context, SnippetAcceptingContext
{
    /**
     * @var Process
     */
    private $process;

    private $lastOutput;

<<<<<<< HEAD
=======
    protected $executablePath = __DIR__ . '/../../bin/phpspec';

>>>>>>> v2-test
    /**
     * @Given I have started describing the :class class
     */
    public function iHaveStartedDescribingTheClass($class)
    {
<<<<<<< HEAD
        $command = sprintf('%s %s %s', $this->buildPhpSpecCmd(), 'describe', escapeshellarg($class));

        $process = new Process($command);
=======
        $process = $this->createPhpSpecProcess([
            'describe',
            escapeshellarg($class)
        ]);
>>>>>>> v2-test

        $process->run();

        if ($process->getExitCode() !== 0) {
            throw new \Exception('The describe process ended with an error');
        }
    }

    /**
     * @When I run phpspec and answer :answer when asked if I want to generate the code
     */
    public function iRunPhpspecAndAnswerWhenAskedIfIWantToGenerateTheCode($answer)
    {
<<<<<<< HEAD
        $command = sprintf('%s %s', $this->buildPhpSpecCmd(), 'run');
=======
>>>>>>> v2-test
        $env = array(
            'SHELL_INTERACTIVE' => true,
            'HOME' => getenv('HOME'),
            'PATH' => getenv('PATH'),
<<<<<<< HEAD
        );

        $this->process = $process = new Process($command);
=======
            'COLUMNS' => 80,
        );

        $this->process = $process = $this->createPhpSpecProcess(['run']);
>>>>>>> v2-test

        $process->setEnv($env);
        $process->setInput($answer);
        $process->run();
    }

    /**
     * @return string
     */
    protected function buildPhpSpecCmd()
    {
<<<<<<< HEAD
        $isWindows = DIRECTORY_SEPARATOR === '\\';
        $cmd = escapeshellcmd('' . __DIR__ . '/../../bin/phpspec');
=======
        if (!file_exists($this->executablePath)) {
            throw new \RuntimeException('Could not find phpspec executable at ' . $this->executablePath);
        }

        $isWindows = DIRECTORY_SEPARATOR === '\\';
        $cmd = escapeshellcmd($this->executablePath);
>>>>>>> v2-test
        if ($isWindows) {
            $cmd = 'php ' . $cmd;
        }

        return $cmd;
    }

    /**
     * @Then the tests should be rerun
     */
    public function theTestsShouldBeRerun()
    {
        if (substr_count($this->process->getOutput(), 'specs') !== 2) {
            throw new \Exception('The tests were not rerun');
        }
    }

    /**
     * @Then I should see an error about the missing autoloader
     */
    public function iShouldSeeAnErrorAboutTheMissingAutoloader()
    {
        if (!preg_match('/autoload/', $this->process->getErrorOutput().$this->process->getOutput())) {
<<<<<<< HEAD
            throw new \Exception('There was no error regarding a missing autoloader:');
=======
            throw new \Exception(sprintf('There was no error regarding a missing autoloader: %s', $this->process->getErrorOutput().$this->process->getOutput()));
>>>>>>> v2-test
        }
    }

    /**
     * @When I run phpspec
     */
    public function iRunPhpspec()
    {
<<<<<<< HEAD
        $process = new Process(
            $this->buildPhpSpecCmd() . ' run'
        );
=======
        $process = $this->createPhpSpecProcess(['run']);
>>>>>>> v2-test
        $process->run();
        $this->lastOutput = $process->getOutput();
    }

    /**
     * @When I run phpspec with the :formatter formatter
     */
    public function iRunPhpspecWithThe($formatter)
    {
<<<<<<< HEAD
        $process = new Process(
            $this->buildPhpSpecCmd() . " --format=$formatter run"
        );
=======
        $process = $this->createPhpSpecProcess([
            "--format=$formatter",
            "run"
        ]);
>>>>>>> v2-test
        $process->run();
        $this->lastOutput = $process->getErrorOutput().$process->getOutput();

    }

    /**
     * @Then I should see :message
     */
    public function iShouldSee($message)
    {
        if (strpos($this->lastOutput, $message) === false) {
<<<<<<< HEAD
            throw new \Exception("Missing message: $message");
        }
    }

=======
            throw new \Exception("Missing message: $message\nActual: {$this->lastOutput}");
        }
    }

    /**
     * @Then the suite should pass
     */
    public function theSuiteShouldPass()
    {
        $exitCode = $this->process->getExitCode();
        if ($exitCode !== 0) {
            throw new \Exception(sprintf('Expected that tests will pass, but exit code was %s.', $exitCode));
        }
    }

    private function createPhpSpecProcess(array $arguments)
    {
        $command = $this->buildPhpSpecCmd() . ' ' . implode(' ', $arguments);

        if (method_exists(Process::class, 'fromShellCommandline')) {
            return Process::fromShellCommandline($command);
        }

        return new Process($command);
    }
>>>>>>> v2-test
}
