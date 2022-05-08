<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
<<<<<<< HEAD
=======
use PHPUnit\Framework\Assert;
>>>>>>> v2-test
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Defines application features from the specific context.
 */
class FilesystemContext implements Context
{
    /**
     * @var string
     */
    private $workingDirectory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    /**
     * @beforeScenario
     */
    public function prepWorkingDirectory()
    {
        $this->workingDirectory = tempnam(sys_get_temp_dir(), 'phpspec-behat');
        $this->filesystem->remove($this->workingDirectory);
        $this->filesystem->mkdir($this->workingDirectory);
        chdir($this->workingDirectory);

<<<<<<< HEAD
=======
        $fakeHomeDirectory = sprintf('%s/fake-home/', $this->workingDirectory);
        $this->filesystem->mkdir($fakeHomeDirectory . '.phpspec');

        if (!empty($_SERVER['HOMEDRIVE']) && !empty($_SERVER['HOMEPATH'])) {
            $_SERVER['HOMEPATH'] = substr($fakeHomeDirectory, 2);
        } else {
            putenv(sprintf('HOME=%s', $fakeHomeDirectory));
        }

>>>>>>> v2-test
        $this->filesystem->mkdir($this->workingDirectory . '/vendor');
        $this->filesystem->copy(
            __DIR__ . '/autoloader/autoload.php',
            $this->workingDirectory . '/vendor/autoload.php'
        );
    }

    /**
     * @afterScenario
     */
    public function removeWorkingDirectory()
    {
        try {
            $this->filesystem->remove($this->workingDirectory);
        } catch (IOException $e) {
            //ignoring exception
        }
    }

    /**
<<<<<<< HEAD
=======
     * @Given I have a custom :template template that contains:
     */
    public function iHaveACustomTemplateThatContains($template, PyStringNode $contents)
    {
        $this->filesystem->dumpFile(sprintf('fake-home/.phpspec/%s.tpl', $template), $contents);
    }

    /**
>>>>>>> v2-test
     * @Given the bootstrap file :file contains:
     */
    public function theFileContains($file, PyStringNode $contents)
    {
        $this->filesystem->dumpFile($file, (string)$contents);
    }

    /**
     * @Given the class file :file contains:
<<<<<<< HEAD
=======
     * @Given the interface file :file contains:
>>>>>>> v2-test
     * @Given the trait file :file contains:
     */
    public function theClassOrTraitFileContains($file, PyStringNode $contents)
    {
        $this->theFileContains($file, $contents);
        require_once($file);
    }

    /**
     * @Given the spec file :file contains:
     */
    public function theSpecFileContains($file, PyStringNode $contents)
    {
        $this->theFileContains($file, $contents);
    }

    /**
     * @Given the config file contains:
     */
    public function theConfigFileContains(PyStringNode $contents)
    {
        $this->theFileContains('phpspec.yml', $contents);
    }

    /**
     * @Given there is no file :file
     */
    public function thereIsNoFile($file)
    {
        if (file_exists($file)) {
            throw new \Exception(sprintf(
                "File unexpectedly exists at path '%s'",
                $file
            ));
        }
    }

    /**
<<<<<<< HEAD
     * @Then the class in :file should contain:
=======
     * @Then the class/interface in :file should contain:
>>>>>>> v2-test
     * @Then a new class/spec should be generated in the :file:
     */
    public function theFileShouldContain($file, PyStringNode $contents)
    {
        if (!file_exists($file)) {
            throw new \Exception(sprintf(
                "File did not exist at path '%s'",
                $file
            ));
        }

        $expectedContents = (string)$contents;
        if ($expectedContents != file_get_contents($file)) {
            throw new \Exception(sprintf(
                "File at '%s' did not contain expected contents.\nExpected: '%s'\nActual: '%s'",
                $file,
                $expectedContents,
                file_get_contents($file)
            ));
        }
    }

    /**
     * @Given the config file located in :folder contains:
     */
    public function theConfigFileInFolderContains($folder, PyStringNode $contents)
    {
        $this->theFileContains($folder.DIRECTORY_SEPARATOR.'phpspec.yml', $contents);
    }

    /**
     * @Given I have not configured an autoloader
     */
    public function iHaveNotConfiguredAnAutoloader()
    {
        $this->filesystem->remove($this->workingDirectory . '/vendor/autoload.php');
    }
<<<<<<< HEAD
=======

    /**
     * @Given there should be no file :path
     */
    public function thereShouldBeNoFile($path)
    {
        Assert::assertFileNotExists($path);
    }
>>>>>>> v2-test
}
