<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\Console;

use PhpSpec\CodeAnalysis\MagicAwareAccessInspector;
use PhpSpec\CodeAnalysis\StaticRejectingNamespaceResolver;
use PhpSpec\CodeAnalysis\TokenizedNamespaceResolver;
use PhpSpec\CodeAnalysis\TokenizedTypeHintRewriter;
use PhpSpec\CodeAnalysis\VisibilityAccessInspector;
<<<<<<< HEAD
use PhpSpec\Console\Assembler\PresenterAssembler;
use PhpSpec\Process\Prerequisites\SuitePrerequisites;
use PhpSpec\Util\ReservedWordsMethodNameChecker;
use PhpSpec\Process\ReRunner;
use PhpSpec\Util\MethodAnalyser;
use Symfony\Component\EventDispatcher\EventDispatcher;
use PhpSpec\ServiceContainer;
use PhpSpec\CodeGenerator;
=======
use PhpSpec\CodeGenerator;
use PhpSpec\Config\OptionsConfig;
use PhpSpec\Console\Assembler\PresenterAssembler;
use PhpSpec\Console\Prompter\Question;
use PhpSpec\Console\Provider\NamespacesAutocompleteProvider;
use PhpSpec\Factory\ReflectionFactory;
>>>>>>> v2-test
use PhpSpec\Formatter as SpecFormatter;
use PhpSpec\Listener;
use PhpSpec\Loader;
use PhpSpec\Locator;
use PhpSpec\Matcher;
<<<<<<< HEAD
use PhpSpec\Runner;
use PhpSpec\Wrapper;
use PhpSpec\Config\OptionsConfig;
use Symfony\Component\Process\PhpExecutableFinder;
use PhpSpec\Message\CurrentExampleTracker;
use PhpSpec\Process\Shutdown\Shutdown;

class ContainerAssembler
{
    /**
     * @param ServiceContainer $container
     */
    public function build(ServiceContainer $container)
    {
=======
use PhpSpec\Message\CurrentExampleTracker;
use PhpSpec\NamespaceProvider\ComposerPsrNamespaceProvider;
use PhpSpec\NamespaceProvider\NamespaceProvider;
use PhpSpec\Process\Prerequisites\SuitePrerequisites;
use PhpSpec\Process\ReRunner;
use PhpSpec\Runner;
use PhpSpec\ServiceContainer\IndexedServiceContainer;
use PhpSpec\Util\ClassFileAnalyser;
use PhpSpec\Util\ClassNameChecker;
use PhpSpec\Util\Filesystem;
use PhpSpec\Util\MethodAnalyser;
use PhpSpec\Util\ReservedWordsMethodNameChecker;
use PhpSpec\Wrapper;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Finder\Finder;
use PhpSpec\Process\Shutdown\Shutdown;

/**
 * @internal
 */
final class ContainerAssembler
{
    /**
     * @param IndexedServiceContainer $container
     */
    public function build(IndexedServiceContainer $container): void
    {
        $this->setupParameters($container);
>>>>>>> v2-test
        $this->setupIO($container);
        $this->setupEventDispatcher($container);
        $this->setupConsoleEventDispatcher($container);
        $this->setupGenerators($container);
        $this->setupPresenter($container);
        $this->setupLocator($container);
        $this->setupLoader($container);
        $this->setupFormatter($container);
        $this->setupRunner($container);
        $this->setupCommands($container);
        $this->setupResultConverter($container);
        $this->setupRerunner($container);
        $this->setupMatchers($container);
        $this->setupSubscribers($container);
        $this->setupCurrentExample($container);
        $this->setupShutdown($container);
    }

<<<<<<< HEAD
    private function setupIO(ServiceContainer $container)
    {
        if (!$container->isDefined('console.prompter')) {
            $container->setShared('console.prompter', function ($c) {
                return $c->get('console.prompter.factory')->getPrompter();
            });
        }
        $container->setShared('console.io', function (ServiceContainer $c) {
            return new IO(
=======
    private function setupParameters(IndexedServiceContainer $container): void
    {
        $container->setParam(
            'generator.private-constructor.message',
            'Do you want me to make the constructor of {CLASSNAME} private for you?'
        );
    }

    private function setupIO(IndexedServiceContainer $container): void
    {
        if (!$container->has('console.prompter')) {
            $container->define('console.prompter', function ($c) {
                return new Question(
                    $c->get('console.input'),
                    $c->get('console.output'),
                    $c->get('console.helper_set')->get('question')
                );
            });
        }
        $container->define('console.io', function (IndexedServiceContainer $c) {
            return new ConsoleIO(
>>>>>>> v2-test
                $c->get('console.input'),
                $c->get('console.output'),
                new OptionsConfig(
                    $c->getParam('stop_on_failure', false),
                    $c->getParam('code_generation', true),
                    $c->getParam('rerun', true),
                    $c->getParam('fake', false),
<<<<<<< HEAD
                    $c->getParam('bootstrap', false)
=======
                    $c->getParam('bootstrap', false),
                    $c->getParam('verbose', false)
>>>>>>> v2-test
                ),
                $c->get('console.prompter')
            );
        });
<<<<<<< HEAD
    }

    private function setupResultConverter(ServiceContainer $container)
    {
        $container->setShared('console.result_converter', function () {
=======
        $container->define('util.filesystem', function () {
            return new Filesystem();
        });
        $container->define('console.autocomplete_provider', function (IndexedServiceContainer $container) {
            return new NamespacesAutocompleteProvider(
                new Finder(),
                $container->getByTag('locator.locators')
            );
        });
    }

    private function setupResultConverter(IndexedServiceContainer $container): void
    {
        $container->define('console.result_converter', function () {
>>>>>>> v2-test
            return new ResultConverter();
        });
    }

<<<<<<< HEAD
    private function setupCommands(ServiceContainer $container)
    {
        $container->setShared('console.commands.run', function () {
            return new Command\RunCommand();
        });

        $container->setShared('console.commands.describe', function () {
            return new Command\DescribeCommand();
        });
    }

    /**
     * @param ServiceContainer $container
     */
    private function setupConsoleEventDispatcher(ServiceContainer $container)
    {
        $container->setShared('console_event_dispatcher', function (ServiceContainer $c) {
=======
    private function setupCommands(IndexedServiceContainer $container): void
    {
        $container->define('console.commands.run', function () {
            return new Command\RunCommand();
        }, ['console.commands']);

        $container->define('console.commands.describe', function () {
            return new Command\DescribeCommand();
        }, ['console.commands']);
    }

    /**
     * @param IndexedServiceContainer $container
     */
    private function setupConsoleEventDispatcher(IndexedServiceContainer $container): void
    {
        $container->define('console_event_dispatcher', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            $dispatcher = new EventDispatcher();

            array_map(
                array($dispatcher, 'addSubscriber'),
<<<<<<< HEAD
                $c->getByPrefix('console_event_dispatcher.listeners')
=======
                $c->getByTag('console_event_dispatcher.listeners')
>>>>>>> v2-test
            );

            return $dispatcher;
        });
    }

    /**
<<<<<<< HEAD
     * @param ServiceContainer $container
     */
    private function setupEventDispatcher(ServiceContainer $container)
    {
        $container->setShared('event_dispatcher', function () {
            return new EventDispatcher();
        });

        $container->setShared('event_dispatcher.listeners.stats', function () {
            return new Listener\StatisticsCollector();
        });
        $container->setShared('event_dispatcher.listeners.class_not_found', function (ServiceContainer $c) {
=======
     * @param IndexedServiceContainer $container
     */
    private function setupEventDispatcher(IndexedServiceContainer $container): void
    {
        $container->define('event_dispatcher', function () {
            return new EventDispatcher();
        });

        $container->define('event_dispatcher.listeners.stats', function () {
            return new Listener\StatisticsCollector();
        }, ['event_dispatcher.listeners']);
        $container->define('event_dispatcher.listeners.class_not_found', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Listener\ClassNotFoundListener(
                $c->get('console.io'),
                $c->get('locator.resource_manager'),
                $c->get('code_generator')
            );
<<<<<<< HEAD
        });
        $container->setShared('event_dispatcher.listeners.collaborator_not_found', function (ServiceContainer $c) {
=======
        }, ['event_dispatcher.listeners']);
        $container->define('event_dispatcher.listeners.collaborator_not_found', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Listener\CollaboratorNotFoundListener(
                $c->get('console.io'),
                $c->get('locator.resource_manager'),
                $c->get('code_generator')
            );
<<<<<<< HEAD
        });
        $container->setShared('event_dispatcher.listeners.collaborator_method_not_found', function (ServiceContainer $c) {
=======
        }, ['event_dispatcher.listeners']);
        $container->define('event_dispatcher.listeners.collaborator_method_not_found', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Listener\CollaboratorMethodNotFoundListener(
                $c->get('console.io'),
                $c->get('locator.resource_manager'),
                $c->get('code_generator'),
                $c->get('util.reserved_words_checker')
            );
<<<<<<< HEAD
        });
        $container->setShared('event_dispatcher.listeners.named_constructor_not_found', function (ServiceContainer $c) {
=======
        }, ['event_dispatcher.listeners']);
        $container->define('event_dispatcher.listeners.named_constructor_not_found', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Listener\NamedConstructorNotFoundListener(
                $c->get('console.io'),
                $c->get('locator.resource_manager'),
                $c->get('code_generator')
            );
<<<<<<< HEAD
        });
        $container->setShared('event_dispatcher.listeners.method_not_found', function (ServiceContainer $c) {
=======
        }, ['event_dispatcher.listeners']);
        $container->define('event_dispatcher.listeners.method_not_found', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Listener\MethodNotFoundListener(
                $c->get('console.io'),
                $c->get('locator.resource_manager'),
                $c->get('code_generator'),
                $c->get('util.reserved_words_checker')
            );
<<<<<<< HEAD
        });
        $container->setShared('event_dispatcher.listeners.stop_on_failure', function (ServiceContainer $c) {
            return new Listener\StopOnFailureListener(
                $c->get('console.io')
            );
        });
        $container->setShared('event_dispatcher.listeners.rerun', function (ServiceContainer $c) {
=======
        }, ['event_dispatcher.listeners']);
        $container->define('event_dispatcher.listeners.stop_on_failure', function (IndexedServiceContainer $c) {
            return new Listener\StopOnFailureListener(
                $c->get('console.io')
            );
        }, ['event_dispatcher.listeners']);
        $container->define('event_dispatcher.listeners.rerun', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Listener\RerunListener(
                $c->get('process.rerunner'),
                $c->get('process.prerequisites')
            );
<<<<<<< HEAD
        });
        $container->setShared('process.prerequisites', function (ServiceContainer $c) {
=======
        }, ['event_dispatcher.listeners']);
        $container->define('process.prerequisites', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new SuitePrerequisites(
                $c->get('process.executioncontext')
            );
        });
<<<<<<< HEAD
        $container->setShared('event_dispatcher.listeners.method_returned_null', function (ServiceContainer $c) {
=======
        $container->define('event_dispatcher.listeners.method_returned_null', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Listener\MethodReturnedNullListener(
                $c->get('console.io'),
                $c->get('locator.resource_manager'),
                $c->get('code_generator'),
                $c->get('util.method_analyser')
            );
<<<<<<< HEAD
        });
        $container->setShared('util.method_analyser', function () {
            return new MethodAnalyser();
        });
        $container->setShared('util.reserved_words_checker', function () {
            return new ReservedWordsMethodNameChecker();
        });
        $container->setShared('event_dispatcher.listeners.bootstrap', function (ServiceContainer $c) {
            return new Listener\BootstrapListener(
                $c->get('console.io')
            );
        });
        $container->setShared('event_dispatcher.listeners.current_example_listener', function (ServiceContainer $c) {
            return new Listener\CurrentExampleListener(
                $c->get('current_example')
            );
        });
    }

    /**
     * @param ServiceContainer $container
     */
    private function setupGenerators(ServiceContainer $container)
    {
        $container->setShared('code_generator', function (ServiceContainer $c) {
=======
        }, ['event_dispatcher.listeners']);
        $container->define('util.method_analyser', function () {
            return new MethodAnalyser();
        });
        $container->define('util.reserved_words_checker', function () {
            return new ReservedWordsMethodNameChecker();
        });
        $container->define('util.class_name_checker', function () {
            return new ClassNameChecker();
        });
        $container->define('event_dispatcher.listeners.bootstrap', function (IndexedServiceContainer $c) {
            return new Listener\BootstrapListener(
                $c->get('console.io')
            );
        }, ['event_dispatcher.listeners']);
        $container->define('event_dispatcher.listeners.current_example_listener', function (IndexedServiceContainer $c) {
            return new Listener\CurrentExampleListener(
                $c->get('current_example')
            );
        }, ['event_dispatcher.listeners']);
    }

    /**
     * @param IndexedServiceContainer $container
     */
    private function setupGenerators(IndexedServiceContainer $container): void
    {
        $container->define('code_generator', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            $generator = new CodeGenerator\GeneratorManager();

            array_map(
                array($generator, 'registerGenerator'),
<<<<<<< HEAD
                $c->getByPrefix('code_generator.generators')
=======
                $c->getByTag('code_generator.generators')
>>>>>>> v2-test
            );

            return $generator;
        });

<<<<<<< HEAD
        $container->set('code_generator.generators.specification', function (ServiceContainer $c) {
            $specificationGenerator =  new CodeGenerator\Generator\SpecificationGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates')
            );

            return new CodeGenerator\Generator\NewFileNotifyingGenerator(
                $specificationGenerator,
                $c->get('event_dispatcher')
            );
        });
        $container->set('code_generator.generators.class', function (ServiceContainer $c) {
            $classGenerator = new CodeGenerator\Generator\ClassGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates'),
                null,
=======
        $container->define('code_generator.generators.specification', function (IndexedServiceContainer $c) {
            $io = $c->get('console.io');
            $specificationGenerator = new CodeGenerator\Generator\SpecificationGenerator(
                $io,
                $c->get('code_generator.templates'),
                $c->get('util.filesystem'),
                $c->get('process.executioncontext')
            );

            $classNameCheckGenerator = new CodeGenerator\Generator\ValidateClassNameSpecificationGenerator(
                $c->get('util.class_name_checker'),
                $io,
                $specificationGenerator
            );

            return new CodeGenerator\Generator\NewFileNotifyingGenerator(
                $classNameCheckGenerator,
                $c->get('event_dispatcher'),
                $c->get('util.filesystem')
            );
        }, ['code_generator.generators']);
        $container->define('code_generator.generators.class', function (IndexedServiceContainer $c) {
            $classGenerator = new CodeGenerator\Generator\ClassGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates'),
                $c->get('util.filesystem'),
>>>>>>> v2-test
                $c->get('process.executioncontext')
            );

            return new CodeGenerator\Generator\NewFileNotifyingGenerator(
                $classGenerator,
<<<<<<< HEAD
                $c->get('event_dispatcher')
            );
        });
        $container->set('code_generator.generators.interface', function (ServiceContainer $c) {
            $interfaceGenerator = new CodeGenerator\Generator\InterfaceGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates'),
                null,
=======
                $c->get('event_dispatcher'),
                $c->get('util.filesystem')
            );
        }, ['code_generator.generators']);
        $container->define('code_generator.generators.interface', function (IndexedServiceContainer $c) {
            $interfaceGenerator = new CodeGenerator\Generator\InterfaceGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates'),
                $c->get('util.filesystem'),
>>>>>>> v2-test
                $c->get('process.executioncontext')
            );

            return new CodeGenerator\Generator\NewFileNotifyingGenerator(
                $interfaceGenerator,
<<<<<<< HEAD
                $c->get('event_dispatcher')
            );
        });
        $container->set('code_generator.generators.method', function (ServiceContainer $c) {
            return new CodeGenerator\Generator\MethodGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates')
            );
        });
        $container->set('code_generator.generators.methodSignature', function (ServiceContainer $c) {
            return new CodeGenerator\Generator\MethodSignatureGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates')
            );
        });
        $container->set('code_generator.generators.returnConstant', function (ServiceContainer $c) {
            return new CodeGenerator\Generator\ReturnConstantGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates')
            );
        });

        $container->set('code_generator.generators.named_constructor', function (ServiceContainer $c) {
            return new CodeGenerator\Generator\NamedConstructorGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates')
            );
        });

        $container->set('code_generator.generators.private_constructor', function (ServiceContainer $c) {
            return new CodeGenerator\Generator\PrivateConstructorGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates')
            );
        });

        $container->setShared('code_generator.templates', function (ServiceContainer $c) {
            $renderer = new CodeGenerator\TemplateRenderer();
=======
                $c->get('event_dispatcher'),
                $c->get('util.filesystem')
            );
        }, ['code_generator.generators']);
        $container->define('code_generator.writers.tokenized', function () {
            return new CodeGenerator\Writer\TokenizedCodeWriter(new ClassFileAnalyser());
        });
        $container->define('code_generator.generators.method', function (IndexedServiceContainer $c) {
            return new CodeGenerator\Generator\MethodGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates'),
                $c->get('util.filesystem'),
                $c->get('code_generator.writers.tokenized')
            );
        }, ['code_generator.generators']);
        $container->define('code_generator.generators.methodSignature', function (IndexedServiceContainer $c) {
            return new CodeGenerator\Generator\MethodSignatureGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates'),
                $c->get('util.filesystem')
            );
        }, ['code_generator.generators']);
        $container->define('code_generator.generators.returnConstant', function (IndexedServiceContainer $c) {
            return new CodeGenerator\Generator\ReturnConstantGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates'),
                $c->get('util.filesystem')
            );
        }, ['code_generator.generators']);

        $container->define('code_generator.generators.named_constructor', function (IndexedServiceContainer $c) {
            return new CodeGenerator\Generator\NamedConstructorGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates'),
                $c->get('util.filesystem'),
                $c->get('code_generator.writers.tokenized')
            );
        }, ['code_generator.generators']);

        $container->define('code_generator.generators.private_constructor', function (IndexedServiceContainer $c) {
            return new CodeGenerator\Generator\OneTimeGenerator(
                new CodeGenerator\Generator\ConfirmingGenerator(
                    $c->get('console.io'),
                    $c->getParam('generator.private-constructor.message'),
                    new CodeGenerator\Generator\PrivateConstructorGenerator(
                        $c->get('console.io'),
                        $c->get('code_generator.templates'),
                        $c->get('util.filesystem'),
                        $c->get('code_generator.writers.tokenized')
                    )
                )
            );
        }, ['code_generator.generators']);

        $container->define('code_generator.templates', function (IndexedServiceContainer $c) {
            $renderer = new CodeGenerator\TemplateRenderer(
                $c->get('util.filesystem')
            );
>>>>>>> v2-test
            $renderer->setLocations($c->getParam('code_generator.templates.paths', array()));

            return $renderer;
        });

        if (!empty($_SERVER['HOMEDRIVE']) && !empty($_SERVER['HOMEPATH'])) {
            $home = $_SERVER['HOMEDRIVE'].$_SERVER['HOMEPATH'];
        } else {
            $home = getenv('HOME');
        }

        $container->setParam('code_generator.templates.paths', array(
            rtrim(getcwd(), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'.phpspec',
            rtrim($home, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'.phpspec',
        ));
    }

    /**
<<<<<<< HEAD
     * @param ServiceContainer $container
     */
    private function setupPresenter(ServiceContainer $container)
=======
     * @param IndexedServiceContainer $container
     */
    private function setupPresenter(IndexedServiceContainer $container): void
>>>>>>> v2-test
    {
        $presenterAssembler = new PresenterAssembler();
        $presenterAssembler->assemble($container);
    }

    /**
<<<<<<< HEAD
     * @param ServiceContainer $container
     */
    private function setupLocator(ServiceContainer $container)
    {
        $container->setShared('locator.resource_manager', function (ServiceContainer $c) {
            $manager = new Locator\ResourceManager();

            array_map(
                array($manager, 'registerLocator'),
                $c->getByPrefix('locator.locators')
=======
     * @param IndexedServiceContainer $container
     */
    private function setupLocator(IndexedServiceContainer $container): void
    {
        $container->define('locator.resource_manager', function (IndexedServiceContainer $c) {
            $manager = new Locator\PrioritizedResourceManager();

            array_map(
                array($manager, 'registerLocator'),
                $c->getByTag('locator.locators')
>>>>>>> v2-test
            );

            return $manager;
        });

<<<<<<< HEAD
        $container->addConfigurator(function (ServiceContainer $c) {
            $suites = $c->getParam('suites', array('main' => ''));

            foreach ($suites as $name => $suite) {
                $suite      = is_array($suite) ? $suite : array('namespace' => $suite);
=======
        $container->addConfigurator(function (IndexedServiceContainer $c) {
            $suites = [];
            $arguments = $c->getParam('composer_suite_detection', false);
            if ($arguments !== false) {
                if ($arguments === true) {
                    $arguments = [];
                }
                $arguments = array_merge(array(
                    'root_directory' => '.',
                    'spec_prefix' => 'spec',
                ), (array) $arguments);
                $namespaceProvider = new ComposerPsrNamespaceProvider(
                    $arguments['root_directory'],
                    $arguments['spec_prefix']
                );
                foreach ($namespaceProvider->getNamespaces() as $namespace => $namespaceLocation) {
                    $psr4Prefix = null;
                    if ($namespaceLocation->getAutoloadingStandard() === NamespaceProvider::AUTOLOADING_STANDARD_PSR4) {
                        $psr4Prefix = $namespace;
                    }

                    $location = $namespaceLocation->getLocation();
                    if (!empty($location) && !is_dir($location)) {
                        mkdir($location, 0777, true);
                    }

                    $suites[str_replace('\\', '_', strtolower($namespace)).'suite'] =  [
                        'namespace' => $namespace,
                        'src_path' => $location,
                        'psr4_prefix' => $psr4Prefix,
                    ];
                }
            }

            $suites += $c->getParam('suites', array());

            if (count($suites) === 0) {
                $suites = array('main' => '');
            }
            foreach ($suites as $name => $suite) {
                $suite      = \is_array($suite) ? $suite : array('namespace' => $suite);
>>>>>>> v2-test
                $defaults = array(
                    'namespace'     => '',
                    'spec_prefix'   => 'spec',
                    'src_path'      => 'src',
                    'spec_path'     => '.',
                    'psr4_prefix'   => null
                );

                $config = array_merge($defaults, $suite);

<<<<<<< HEAD
                if (!is_dir($config['src_path'])) {
=======
                if (!empty($config['src_path']) && !is_dir($config['src_path'])) {
>>>>>>> v2-test
                    mkdir($config['src_path'], 0777, true);
                }
                if (!is_dir($config['spec_path'])) {
                    mkdir($config['spec_path'], 0777, true);
                }

<<<<<<< HEAD
                $c->set(
                    sprintf('locator.locators.%s_suite', $name),
                    function () use ($config) {
                        return new Locator\PSR0\PSR0Locator(
=======
                $c->define(
                    sprintf('locator.locators.%s_suite', $name),
                    function (IndexedServiceContainer $c) use ($config) {
                        return new Locator\PSR0\PSR0Locator(
                            $c->get('util.filesystem'),
>>>>>>> v2-test
                            $config['namespace'],
                            $config['spec_prefix'],
                            $config['src_path'],
                            $config['spec_path'],
<<<<<<< HEAD
                            null,
                            $config['psr4_prefix']
                        );
                    }
=======
                            $config['psr4_prefix']
                        );
                    },
                    ['locator.locators']
>>>>>>> v2-test
                );
            }
        });
    }

    /**
<<<<<<< HEAD
     * @param ServiceContainer $container
     */
    private function setupLoader(ServiceContainer $container)
    {
        $container->setShared('loader.resource_loader', function (ServiceContainer $c) {
            return new Loader\ResourceLoader($c->get('locator.resource_manager'));
        });
        if (PHP_VERSION >= 7) {
            $container->setShared('loader.resource_loader.spec_transformer.typehint_rewriter', function (ServiceContainer $c) {
                return new Loader\Transformer\TypeHintRewriter($c->get('analysis.typehintrewriter'));
            });
        }
        $container->setShared('analysis.typehintrewriter', function($c) {
=======
     * @param IndexedServiceContainer $container
     */
    private function setupLoader(IndexedServiceContainer $container): void
    {
        $container->define('loader.resource_loader', function (IndexedServiceContainer $c) {
            return new Loader\ResourceLoader(
                $c->get('locator.resource_manager'),
                $c->get('util.method_analyser')
            );
        });

        $container->define('loader.resource_loader.spec_transformer.typehint_rewriter', function (IndexedServiceContainer $c) {
            return new Loader\Transformer\TypeHintRewriter($c->get('analysis.typehintrewriter'));
        }, ['loader.resource_loader.spec_transformer']);

        $container->define('analysis.typehintrewriter', function ($c) {
>>>>>>> v2-test
            return new TokenizedTypeHintRewriter(
                $c->get('loader.transformer.typehintindex'),
                $c->get('analysis.namespaceresolver')
            );
        });
<<<<<<< HEAD
        $container->setShared('loader.transformer.typehintindex', function() {
            return new Loader\Transformer\InMemoryTypeHintIndex();
        });
        $container->setShared('analysis.namespaceresolver.tokenized', function() {
            return new TokenizedNamespaceResolver();
        });
        $container->setShared('analysis.namespaceresolver', function ($c) {
            if (PHP_VERSION >= 7) {
                return new StaticRejectingNamespaceResolver($c->get('analysis.namespaceresolver.tokenized'));
            }
            return $c->get('analysis.namespaceresolver.tokenized');
=======
        $container->define('loader.transformer.typehintindex', function () {
            return new Loader\Transformer\InMemoryTypeHintIndex();
        });
        $container->define('analysis.namespaceresolver.tokenized', function () {
            return new TokenizedNamespaceResolver();
        });
        $container->define('analysis.namespaceresolver', function ($c) {
            return new StaticRejectingNamespaceResolver($c->get('analysis.namespaceresolver.tokenized'));
>>>>>>> v2-test
        });
    }

    /**
<<<<<<< HEAD
     * @param ServiceContainer $container
     *
     * @throws \RuntimeException
     */
    protected function setupFormatter(ServiceContainer $container)
    {
        $container->set(
            'formatter.formatters.progress',
            function (ServiceContainer $c) {
=======
     * @param IndexedServiceContainer $container
     *
     * @throws \RuntimeException
     */
    protected function setupFormatter(IndexedServiceContainer $container): void
    {
        $container->define(
            'formatter.formatters.progress',
            function (IndexedServiceContainer $c) {
>>>>>>> v2-test
                return new SpecFormatter\ProgressFormatter(
                    $c->get('formatter.presenter'),
                    $c->get('console.io'),
                    $c->get('event_dispatcher.listeners.stats')
                );
            }
        );
<<<<<<< HEAD
        $container->set(
            'formatter.formatters.pretty',
            function (ServiceContainer $c) {
=======
        $container->define(
            'formatter.formatters.pretty',
            function (IndexedServiceContainer $c) {
>>>>>>> v2-test
                return new SpecFormatter\PrettyFormatter(
                    $c->get('formatter.presenter'),
                    $c->get('console.io'),
                    $c->get('event_dispatcher.listeners.stats')
                );
            }
        );
<<<<<<< HEAD
        $container->set(
            'formatter.formatters.junit',
            function (ServiceContainer $c) {
=======
        $container->define(
            'formatter.formatters.junit',
            function (IndexedServiceContainer $c) {
>>>>>>> v2-test
                return new SpecFormatter\JUnitFormatter(
                    $c->get('formatter.presenter'),
                    $c->get('console.io'),
                    $c->get('event_dispatcher.listeners.stats')
                );
            }
        );
<<<<<<< HEAD
        $container->set(
            'formatter.formatters.dot',
            function (ServiceContainer $c) {
=======
        $container->define(
            'formatter.formatters.json',
            function (IndexedServiceContainer $c) {
                return new SpecFormatter\JsonFormatter(
                    $c->get('formatter.presenter'),
                    $c->get('console.io'),
                    $c->get('event_dispatcher.listeners.stats')
                );
            }
        );
        $container->define(
            'formatter.formatters.dot',
            function (IndexedServiceContainer $c) {
>>>>>>> v2-test
                return new SpecFormatter\DotFormatter(
                    $c->get('formatter.presenter'),
                    $c->get('console.io'),
                    $c->get('event_dispatcher.listeners.stats')
                );
            }
        );
<<<<<<< HEAD
        $container->set(
            'formatter.formatters.tap',
            function (ServiceContainer $c) {
=======
        $container->define(
            'formatter.formatters.tap',
            function (IndexedServiceContainer $c) {
>>>>>>> v2-test
                return new SpecFormatter\TapFormatter(
                    $c->get('formatter.presenter'),
                    $c->get('console.io'),
                    $c->get('event_dispatcher.listeners.stats')
                );
            }
        );
<<<<<<< HEAD
        $container->set(
            'formatter.formatters.html',
            function (ServiceContainer $c) {
                $io = new SpecFormatter\Html\IO();
=======
        $container->define(
            'formatter.formatters.html',
            function (IndexedServiceContainer $c) {
                $io = new SpecFormatter\Html\HtmlIO();
>>>>>>> v2-test
                $template = new SpecFormatter\Html\Template($io);
                $factory = new SpecFormatter\Html\ReportItemFactory($template);
                $presenter = $c->get('formatter.presenter.html');

                return new SpecFormatter\HtmlFormatter(
                    $factory,
                    $presenter,
                    $io,
                    $c->get('event_dispatcher.listeners.stats')
                );
            }
        );
<<<<<<< HEAD
        $container->set(
            'formatter.formatters.h',
            function (ServiceContainer $c) {
=======
        $container->define(
            'formatter.formatters.h',
            function (IndexedServiceContainer $c) {
>>>>>>> v2-test
                return $c->get('formatter.formatters.html');
            }
        );

<<<<<<< HEAD
        $container->addConfigurator(function (ServiceContainer $c) {
=======
        $container->addConfigurator(function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            $formatterName = $c->getParam('formatter.name', 'progress');

            $c->get('console.output')->setFormatter(new Formatter(
                $c->get('console.output')->isDecorated()
            ));

            try {
                $formatter = $c->get('formatter.formatters.'.$formatterName);
            } catch (\InvalidArgumentException $e) {
                throw new \RuntimeException(sprintf('Formatter not recognised: "%s"', $formatterName));
            }
<<<<<<< HEAD
            $c->set('event_dispatcher.listeners.formatter', $formatter);
=======
            $c->set('event_dispatcher.listeners.formatter', $formatter, ['event_dispatcher.listeners']);
>>>>>>> v2-test
        });
    }

    /**
<<<<<<< HEAD
     * @param ServiceContainer $container
     */
    private function setupRunner(ServiceContainer $container)
    {
        $container->setShared('runner.suite', function (ServiceContainer $c) {
=======
     * @param IndexedServiceContainer $container
     */
    private function setupRunner(IndexedServiceContainer $container): void
    {
        $container->define('runner.suite', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Runner\SuiteRunner(
                $c->get('event_dispatcher'),
                $c->get('runner.specification')
            );
        });

<<<<<<< HEAD
        $container->setShared('runner.specification', function (ServiceContainer $c) {
=======
        $container->define('runner.specification', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Runner\SpecificationRunner(
                $c->get('event_dispatcher'),
                $c->get('runner.example')
            );
        });

<<<<<<< HEAD
        $container->setShared('runner.example', function (ServiceContainer $c) {
=======
        $container->define('runner.example', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            $runner = new Runner\ExampleRunner(
                $c->get('event_dispatcher'),
                $c->get('formatter.presenter')
            );

            array_map(
                array($runner, 'registerMaintainer'),
<<<<<<< HEAD
                $c->getByPrefix('runner.maintainers')
=======
                $c->getByTag('runner.maintainers')
>>>>>>> v2-test
            );

            return $runner;
        });

<<<<<<< HEAD
        $container->set('runner.maintainers.errors', function (ServiceContainer $c) {
            return new Runner\Maintainer\ErrorMaintainer(
                $c->getParam('runner.maintainers.errors.level', E_ALL ^ E_STRICT)
            );
        });
        $container->set('runner.maintainers.collaborators', function (ServiceContainer $c) {
=======
        $container->define('runner.maintainers.errors', function (IndexedServiceContainer $c) {
            return new Runner\Maintainer\ErrorMaintainer(
                $c->getParam('runner.maintainers.errors.level', E_ALL ^ E_STRICT)
            );
        }, ['runner.maintainers']);
        $container->define('runner.maintainers.collaborators', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Runner\Maintainer\CollaboratorsMaintainer(
                $c->get('unwrapper'),
                $c->get('loader.transformer.typehintindex')
            );
<<<<<<< HEAD
        });
        $container->set('runner.maintainers.let_letgo', function () {
            return new Runner\Maintainer\LetAndLetgoMaintainer();
        });

        $container->set('runner.maintainers.matchers', function (ServiceContainer $c) {
            $matchers = $c->getByPrefix('matchers');
=======
        }, ['runner.maintainers']);
        $container->define('runner.maintainers.let_letgo', function () {
            return new Runner\Maintainer\LetAndLetgoMaintainer();
        }, ['runner.maintainers']);

        $container->define('runner.maintainers.matchers', function (IndexedServiceContainer $c) {
            $matchers = $c->getByTag('matchers');
>>>>>>> v2-test
            return new Runner\Maintainer\MatchersMaintainer(
                $c->get('formatter.presenter'),
                $matchers
            );
<<<<<<< HEAD
        });

        $container->set('runner.maintainers.subject', function (ServiceContainer $c) {
=======
        }, ['runner.maintainers']);

        $container->define('runner.maintainers.subject', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new Runner\Maintainer\SubjectMaintainer(
                $c->get('formatter.presenter'),
                $c->get('unwrapper'),
                $c->get('event_dispatcher'),
                $c->get('access_inspector')
            );
<<<<<<< HEAD
        });

        $container->setShared('unwrapper', function () {
            return new Wrapper\Unwrapper();
        });

        $container->setShared('access_inspector', function($c) {
            return $c->get('access_inspector.magic');
        });

        $container->setShared('access_inspector.magic', function($c) {
            return new MagicAwareAccessInspector($c->get('access_inspector.visibility'));
        });

        $container->setShared('access_inspector.visibility', function() {
=======
        }, ['runner.maintainers']);

        $container->define('unwrapper', function () {
            return new Wrapper\Unwrapper();
        });

        $container->define('access_inspector', function ($c) {
            return $c->get('access_inspector.magic');
        });

        $container->define('access_inspector.magic', function ($c) {
            return new MagicAwareAccessInspector($c->get('access_inspector.visibility'));
        });

        $container->define('access_inspector.visibility', function () {
>>>>>>> v2-test
            return new VisibilityAccessInspector();
        });
    }

    /**
<<<<<<< HEAD
     * @param ServiceContainer $container
     */
    private function setupMatchers(ServiceContainer $container)
    {
        $container->set('matchers.identity', function (ServiceContainer $c) {
            return new Matcher\IdentityMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.comparison', function (ServiceContainer $c) {
            return new Matcher\ComparisonMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.throwm', function (ServiceContainer $c) {
            return new Matcher\ThrowMatcher($c->get('unwrapper'), $c->get('formatter.presenter'));
        });
        $container->set('matchers.type', function (ServiceContainer $c) {
            return new Matcher\TypeMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.object_state', function (ServiceContainer $c) {
            return new Matcher\ObjectStateMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.scalar', function (ServiceContainer $c) {
            return new Matcher\ScalarMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.array_count', function (ServiceContainer $c) {
            return new Matcher\ArrayCountMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.array_key', function (ServiceContainer $c) {
            return new Matcher\ArrayKeyMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.array_key_with_value', function (ServiceContainer $c) {
            return new Matcher\ArrayKeyValueMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.array_contain', function (ServiceContainer $c) {
            return new Matcher\ArrayContainMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.string_start', function (ServiceContainer $c) {
            return new Matcher\StringStartMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.string_end', function (ServiceContainer $c) {
            return new Matcher\StringEndMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.string_regex', function (ServiceContainer $c) {
            return new Matcher\StringRegexMatcher($c->get('formatter.presenter'));
        });
        $container->set('matchers.string_contain', function (ServiceContainer $c) {
            return new Matcher\StringContainMatcher($c->get('formatter.presenter'));
        });
    }

    /**
     * @param ServiceContainer $container
     */
    private function setupRerunner(ServiceContainer $container)
    {
        $container->setShared('process.rerunner', function (ServiceContainer $c) {
=======
     * @param IndexedServiceContainer $container
     */
    private function setupMatchers(IndexedServiceContainer $container): void
    {
        $container->define('matchers.identity', function (IndexedServiceContainer $c) {
            return new Matcher\IdentityMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.comparison', function (IndexedServiceContainer $c) {
            return new Matcher\ComparisonMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.throwm', function (IndexedServiceContainer $c) {
            return new Matcher\ThrowMatcher($c->get('unwrapper'), $c->get('formatter.presenter'), new ReflectionFactory());
        }, ['matchers']);
        $container->define('matchers.trigger', function (IndexedServiceContainer $c) {
            return new Matcher\TriggerMatcher($c->get('unwrapper'));
        }, ['matchers']);
        $container->define('matchers.type', function (IndexedServiceContainer $c) {
            return new Matcher\TypeMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.object_state', function (IndexedServiceContainer $c) {
            return new Matcher\ObjectStateMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.scalar', function (IndexedServiceContainer $c) {
            return new Matcher\ScalarMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.array_count', function (IndexedServiceContainer $c) {
            return new Matcher\ArrayCountMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.array_key', function (IndexedServiceContainer $c) {
            return new Matcher\ArrayKeyMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.array_key_with_value', function (IndexedServiceContainer $c) {
            return new Matcher\ArrayKeyValueMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.array_contain', function (IndexedServiceContainer $c) {
            return new Matcher\ArrayContainMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.string_start', function (IndexedServiceContainer $c) {
            return new Matcher\StringStartMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.string_end', function (IndexedServiceContainer $c) {
            return new Matcher\StringEndMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.string_regex', function (IndexedServiceContainer $c) {
            return new Matcher\StringRegexMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.string_contain', function (IndexedServiceContainer $c) {
            return new Matcher\StringContainMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.traversable_count', function (IndexedServiceContainer $c) {
            return new Matcher\TraversableCountMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.traversable_key', function (IndexedServiceContainer $c) {
            return new Matcher\TraversableKeyMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.traversable_key_with_value', function (IndexedServiceContainer $c) {
            return new Matcher\TraversableKeyValueMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.traversable_contain', function (IndexedServiceContainer $c) {
            return new Matcher\TraversableContainMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.iterate', function (IndexedServiceContainer $c) {
            return new Matcher\IterateAsMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.iterate_like', function (IndexedServiceContainer $c) {
            return new Matcher\IterateLikeMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.start_iterating', function (IndexedServiceContainer $c) {
            return new Matcher\StartIteratingAsMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.approximately', function (IndexedServiceContainer $c) {
            return new Matcher\ApproximatelyMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
    }

    /**
     * @param IndexedServiceContainer $container
     */
    private function setupRerunner(IndexedServiceContainer $container): void
    {
        $container->define('process.rerunner', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return new ReRunner\OptionalReRunner(
                $c->get('process.rerunner.platformspecific'),
                $c->get('console.io')
            );
        });

<<<<<<< HEAD
        if ($container->isDefined('process.rerunner.platformspecific')) {
            return;
        }

        $container->setShared('process.rerunner.platformspecific', function (ServiceContainer $c) {
            return new ReRunner\CompositeReRunner(
                $c->getByPrefix('process.rerunner.platformspecific')
            );
        });
        $container->setShared('process.rerunner.platformspecific.pcntl', function (ServiceContainer $c) {
=======
        if ($container->has('process.rerunner.platformspecific')) {
            return;
        }

        $container->define('process.rerunner.platformspecific', function (IndexedServiceContainer $c) {
            return new ReRunner\CompositeReRunner(
                $c->getByTag('process.rerunner.platformspecific')
            );
        });
        $container->define('process.rerunner.platformspecific.pcntl', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return ReRunner\PcntlReRunner::withExecutionContext(
                $c->get('process.phpexecutablefinder'),
                $c->get('process.executioncontext')
            );
<<<<<<< HEAD
        });
        $container->setShared('process.rerunner.platformspecific.passthru', function (ServiceContainer $c) {
=======
        }, ['process.rerunner.platformspecific']);
        $container->define('process.rerunner.platformspecific.passthru', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return ReRunner\ProcOpenReRunner::withExecutionContext(
                $c->get('process.phpexecutablefinder'),
                $c->get('process.executioncontext')
            );
<<<<<<< HEAD
        });
        $container->setShared('process.rerunner.platformspecific.windowspassthru', function (ServiceContainer $c) {
=======
        }, ['process.rerunner.platformspecific']);
        $container->define('process.rerunner.platformspecific.windowspassthru', function (IndexedServiceContainer $c) {
>>>>>>> v2-test
            return ReRunner\WindowsPassthruReRunner::withExecutionContext(
                $c->get('process.phpexecutablefinder'),
                $c->get('process.executioncontext')
            );
<<<<<<< HEAD
        });
        $container->setShared('process.phpexecutablefinder', function () {
=======
        }, ['process.rerunner.platformspecific']);
        $container->define('process.phpexecutablefinder', function () {
>>>>>>> v2-test
            return new PhpExecutableFinder();
        });
    }

    /**
<<<<<<< HEAD
     * @param ServiceContainer $container
     */
    private function setupSubscribers(ServiceContainer $container)
    {
        $container->addConfigurator(function (ServiceContainer $c) {
            array_map(
                array($c->get('event_dispatcher'), 'addSubscriber'),
                $c->getByPrefix('event_dispatcher.listeners')
=======
     * @param IndexedServiceContainer $container
     */
    private function setupSubscribers(IndexedServiceContainer $container): void
    {
        $container->addConfigurator(function (IndexedServiceContainer $c) {
            array_map(
                array($c->get('event_dispatcher'), 'addSubscriber'),
                $c->getByTag('event_dispatcher.listeners')
>>>>>>> v2-test
            );
        });
    }

    /**
<<<<<<< HEAD
     * @param ServiceContainer $container
     */
    private function setupCurrentExample(ServiceContainer $container)
    {
        $container->setShared('current_example', function () {
=======
     * @param IndexedServiceContainer $container
     */
    private function setupCurrentExample(IndexedServiceContainer $container): void
    {
        $container->define('current_example', function () {
>>>>>>> v2-test
            return new CurrentExampleTracker();
        });
    }

  /**
<<<<<<< HEAD
   * @param ServiceContainer $container
   */
    private function setupShutdown(ServiceContainer $container)
    {
        $container->setShared('process.shutdown', function() {
=======
   * @param IndexedServiceContainer $container
   */
    private function setupShutdown(IndexedServiceContainer $container): void
    {
        $container->define('process.shutdown', function () {
>>>>>>> v2-test
            return new Shutdown();
        });
    }
}
