<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Exception\InvalidPathException;
use Illuminate\Support\Env;
use InvalidArgumentException;
use Royalcms\Component\Contracts\Foundation\Royalcms;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class LoadEnvironmentVariables
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        /*
        |--------------------------------------------------------------------------
        | Detect The Royalcms Environment
        |--------------------------------------------------------------------------
        |
        | Royalcms takes a dead simple approach to your application environments
        | so you can just specify a machine name for the host that matches a
        | given environment, then we will automatically detect it for you.
        |
        */
        if ($royalcms->configurationIsCached()) {
            return;
        }

        $royalcms->useEnvironmentPath($royalcms->path());
        if (! file_exists($royalcms->environmentFilePath())) {
            $royalcms->useEnvironmentPath($royalcms->basePath());
        }

        $this->checkForSpecificEnvironmentFile($royalcms);

        try {
            $this->createDotenv($royalcms)->safeLoad();
        }
        catch (InvalidFileException $e) {
            $this->writeErrorAndDie($e);
        }

        // Finally, we will set the application's environment based on the configuration
        // values that were loaded. We will pass a callback which will be used to get
        // the environment in a web context where an "--env" switch is not present.
        $royalcms->detectEnvironment(function () {
            return env('ROYALCMS_ENV', 'production');
        });
    }

    /**
     * Detect if a custom environment file matching the APP_ENV exists.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    protected function checkForSpecificEnvironmentFile($royalcms)
    {
        if ($royalcms->runningInConsole() && ($input = new ArgvInput)->hasParameterOption('--env')) {
            if ($this->setEnvironmentFilePath(
                $royalcms, $royalcms->environmentFile().'.'.$input->getParameterOption('--env')
            )) {
                return;
            }
        }

        $environment = Env::get('ROYALCMS_ENV');

        if (! $environment) {
            return;
        }

        $this->setEnvironmentFilePath(
            $royalcms, $royalcms->environmentFile().'.'.$environment
        );
    }

    /**
     * Load a custom environment file.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  string  $file
     * @return bool
     */
    protected function setEnvironmentFilePath($royalcms, $file)
    {
        if (file_exists($royalcms->environmentPath().'/'.$file)) {
            $royalcms->loadEnvironmentFrom($file);

            return true;
        }

        return false;
    }

    /**
     * Create a Dotenv instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return \Dotenv\Dotenv
     */
    protected function createDotenv($royalcms)
    {
        return Dotenv::create(
            Env::getRepository(),
            $royalcms->environmentPath(),
            $royalcms->environmentFile()
        );
    }

    /**
     * Write the error information to the screen and exit.
     *
     * @param  \Dotenv\Exception\InvalidFileException  $e
     * @return void
     */
    protected function writeErrorAndDie(InvalidFileException $e)
    {
        $output = (new ConsoleOutput)->getErrorOutput();

        $output->writeln('The environment file is invalid!');
        $output->writeln($e->getMessage());

        die(1);
    }
}
