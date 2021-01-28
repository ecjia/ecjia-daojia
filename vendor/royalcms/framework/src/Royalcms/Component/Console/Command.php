<?php

namespace Royalcms\Component\Console;

//use Illuminate\Console\OutputStyle;
use Royalcms\Component\Contracts\Support\Arrayable;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Illuminate\Console\Command as LaravelCommand;
use Royalcms\Component\Contracts\Foundation\Royalcms as FoundationRoyalcms;

class Command extends LaravelCommand
{
    /**
     * The Royalcms application instance.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

//    /**
//     * The input interface implementation.
//     *
//     * @var \Symfony\Component\Console\Input\InputInterface
//     */
//    protected $input;

//    /**
//     * The output interface implementation.
//     *
//     * @var \Royalcms\Component\Console\OutputStyle
//     */
//    protected $output;

//    /**
//     * The name and signature of the console command.
//     *
//     * @var string
//     */
//    protected $signature;

//    /**
//     * The console command name.
//     *
//     * @var string
//     */
//    protected $name;
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description;

//    /**
//     * Create a new console command instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        parent::__construct();
//
//        $this->royalcms = $this->laravel;
//    }

//    /**
//     * Configure the console command using a fluent definition.
//     *
//     * @return void
//     */
//    protected function configureUsingFluentDefinition()
//    {
//        list($name, $arguments, $options) = Parser::parse($this->signature);
//
//        parent::__construct($name);
//
//        foreach ($arguments as $argument) {
//            $this->getDefinition()->addArgument($argument);
//        }
//
//        foreach ($options as $option) {
//            $this->getDefinition()->addOption($option);
//        }
//    }

//    /**
//     * Specify the arguments and options on the command.
//     *
//     * @return void
//     */
//    protected function specifyParameters()
//    {
//        // We will loop through all of the arguments and options for the command and
//        // set them all on the base command instance. This specifies what can get
//        // passed into these commands as "parameters" to control the execution.
//        foreach ($this->getArguments() as $arguments) {
//            call_user_func_array([$this, 'addArgument'], $arguments);
//        }
//
//        foreach ($this->getOptions() as $options) {
//            call_user_func_array([$this, 'addOption'], $options);
//        }
//    }

    /**
     * Run the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;

        $this->output = $this->royalcms->make(
            OutputStyle::class, ['input' => $input, 'output' => $output]
        );

        return parent::run($input, $output);
    }

    /**
     * Execute the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $method = method_exists($this, 'handle') ? 'handle' : 'fire';

        return (int) $this->royalcms->call([$this, $method]);
    }

    /**
     * Call another console command.
     *
     * @param  string  $command
     * @param  array   $arguments
     * @return int
     */
    public function call($command, array $arguments = [])
    {
        $instance = $this->getApplication()->find($command);

        $arguments['command'] = $command;

        return $instance->run(new ArrayInput($arguments), $this->output);
    }

    /**
     * Call another console command silently.
     *
     * @param  string  $command
     * @param  array   $arguments
     * @return int
     */
    public function callSilent($command, array $arguments = [])
    {
        $instance = $this->getApplication()->find($command);

        $arguments['command'] = $command;

        return $instance->run(new ArrayInput($arguments), new NullOutput);
    }

    /**
     * Get the value of a command argument.
     *
     * @param  string  $key
     * @return string|array
     */
    public function argument($key = null)
    {
        if (is_null($key)) {
            return $this->input->getArguments();
        }

        return $this->input->getArgument($key);
    }

    /**
     * Get the value of a command option.
     *
     * @param  string  $key
     * @return string|array
     */
    public function option($key = null)
    {
        if (is_null($key)) {
            return $this->input->getOptions();
        }

        return $this->input->getOption($key);
    }

    /**
     * Confirm a question with the user.
     *
     * @param  string  $question
     * @param  bool    $default
     * @return bool
     */
    public function confirm($question, $default = false)
    {
        return $this->output->confirm($question, $default);
    }

    /**
     * Prompt the user for input.
     *
     * @param  string  $question
     * @param  string  $default
     * @return string
     */
    public function ask($question, $default = null)
    {
        return $this->output->ask($question, $default);
    }

//    /**
//     * Prompt the user for input with auto completion.
//     *
//     * @param  string  $question
//     * @param  array   $choices
//     * @param  string  $default
//     * @return string
//     */
//    public function anticipate($question, array $choices, $default = null)
//    {
//        return $this->askWithCompletion($question, $choices, $default);
//    }

//    /**
//     * Prompt the user for input with auto completion.
//     *
//     * @param  string  $question
//     * @param  array   $choices
//     * @param  string  $default
//     * @return string
//     */
//    public function askWithCompletion($question, array $choices, $default = null)
//    {
//        $question = new Question($question, $default);
//
//        $question->setAutocompleterValues($choices);
//
//        return $this->output->askQuestion($question);
//    }

    /**
     * Prompt the user for input but hide the answer from the console.
     *
     * @param  string  $question
     * @param  bool    $fallback
     * @return string
     */
    public function secret($question, $fallback = true)
    {
        $question = new Question($question);

        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->output->askQuestion($question);
    }

    /**
     * Give the user a single choice from an array of answers.
     *
     * @param  string  $question
     * @param  array   $choices
     * @param  string  $default
     * @param  mixed   $attempts
     * @param  bool    $multiple
     * @return string
     */
    public function choice($question, array $choices, $default = null, $attempts = null, $multiple = null)
    {
        $question = new ChoiceQuestion($question, $choices, $default);

        $question->setMaxAttempts($attempts)->setMultiselect($multiple);

        return $this->output->askQuestion($question);
    }

//    /**
//     * Format input to textual table.
//     *
//     * @param  array   $headers
//     * @param  \Royalcms\Component\Contracts\Support\Arrayable|array  $rows
//     * @param  string  $style
//     * @return void
//     */
//    public function table(array $headers, $rows, $style = 'default')
//    {
//        $table = new Table($this->output);
//
//        if ($rows instanceof Arrayable) {
//            $rows = $rows->toArray();
//        }
//
//        $table->setHeaders($headers)->setRows($rows)->setStyle($style)->render();
//    }

//    /**
//     * Write a string as information output.
//     *
//     * @param  string  $string
//     * @return void
//     */
//    public function info($string)
//    {
//        $this->output->writeln("<info>$string</info>");
//    }

//    /**
//     * Write a string as standard output.
//     *
//     * @param  string  $string
//     * @return void
//     */
//    public function line($string)
//    {
//        $this->output->writeln($string);
//    }

//    /**
//     * Write a string as comment output.
//     *
//     * @param  string  $string
//     * @return void
//     */
//    public function comment($string)
//    {
//        $this->output->writeln("<comment>$string</comment>");
//    }

//    /**
//     * Write a string as question output.
//     *
//     * @param  string  $string
//     * @return void
//     */
//    public function question($string)
//    {
//        $this->output->writeln("<question>$string</question>");
//    }

//    /**
//     * Write a string as error output.
//     *
//     * @param  string  $string
//     * @return void
//     */
//    public function error($string)
//    {
//        $this->output->writeln("<error>$string</error>");
//    }

//    /**
//     * Write a string as warning output.
//     *
//     * @param  string  $string
//     * @return void
//     */
//    public function warn($string)
//    {
//        if (! $this->output->getFormatter()->hasStyle('warning')) {
//            $style = new OutputFormatterStyle('yellow');
//
//            $this->output->getFormatter()->setStyle('warning', $style);
//        }
//
//        $this->output->writeln("<warning>$string</warning>");
//    }

//    /**
//     * Get the console command arguments.
//     *
//     * @return array
//     */
//    protected function getArguments()
//    {
//        return [];
//    }
//
//    /**
//     * Get the console command options.
//     *
//     * @return array
//     */
//    protected function getOptions()
//    {
//        return [];
//    }

//    /**
//     * Get the output implementation.
//     *
//     * @return \Symfony\Component\Console\Output\OutputInterface
//     */
//    public function getOutput()
//    {
//        return $this->output;
//    }

    /**
     * Get the Royalcms application instance.
     *
     * @return \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    public function getRoyalcms()
    {
        return $this->royalcms;
    }

    /**
     * Set the Royalcms application instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function setRoyalcms(FoundationRoyalcms $royalcms)
    {
        $this->royalcms = $royalcms;
        $this->laravel = $royalcms;
    }

}
