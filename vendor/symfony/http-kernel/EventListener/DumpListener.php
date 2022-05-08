<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\EventListener;

use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\VarDumper\Cloner\ClonerInterface;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
<<<<<<< HEAD
=======
use Symfony\Component\VarDumper\Server\Connection;
>>>>>>> v2-test
use Symfony\Component\VarDumper\VarDumper;

/**
 * Configures dump() handler.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DumpListener implements EventSubscriberInterface
{
    private $cloner;
    private $dumper;
<<<<<<< HEAD

    /**
     * @param ClonerInterface     $cloner Cloner service
     * @param DataDumperInterface $dumper Dumper service
     */
    public function __construct(ClonerInterface $cloner, DataDumperInterface $dumper)
    {
        $this->cloner = $cloner;
        $this->dumper = $dumper;
=======
    private $connection;

    public function __construct(ClonerInterface $cloner, DataDumperInterface $dumper, Connection $connection = null)
    {
        $this->cloner = $cloner;
        $this->dumper = $dumper;
        $this->connection = $connection;
>>>>>>> v2-test
    }

    public function configure()
    {
        $cloner = $this->cloner;
        $dumper = $this->dumper;
<<<<<<< HEAD

        VarDumper::setHandler(function ($var) use ($cloner, $dumper) {
            $dumper->dump($cloner->cloneVar($var));
=======
        $connection = $this->connection;

        VarDumper::setHandler(static function ($var) use ($cloner, $dumper, $connection) {
            $data = $cloner->cloneVar($var);

            if (!$connection || !$connection->write($data)) {
                $dumper->dump($data);
            }
>>>>>>> v2-test
        });
    }

    public static function getSubscribedEvents()
    {
<<<<<<< HEAD
        // Register early to have a working dump() as early as possible
        return array(ConsoleEvents::COMMAND => array('configure', 1024));
=======
        if (!class_exists(ConsoleEvents::class)) {
            return [];
        }

        // Register early to have a working dump() as early as possible
        return [ConsoleEvents::COMMAND => ['configure', 1024]];
>>>>>>> v2-test
    }
}
