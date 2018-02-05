<?php 

namespace Royalcms\Component\Gearman;

use Royalcms\Component\Queue\QueueServiceProvider as ServiceProvider;
use Royalcms\Component\Gearman\Connectors\GearmanConnector;

class GearmanServiceProvider extends ServiceProvider 
{
    /**
     * Register the connectors on the queue manager.
     *
     * @param  \Royalcms\Component\Queue\QueueManager  $manager
     * @return void
     */
    public function registerConnectors($manager)
    {
        parent::registerConnectors($manager);
        
        $this->registerGearmanConnector($manager);
    }

    /**
     * Register the Gearman queue connector.
     *
     * @param  \Royalcms\Component\Queue\QueueManager  $manager
     * @return void
     */
    public function registerGearmanConnector($manager)
    {
        $manager->addConnector('gearman', function() {
            return new GearmanConnector();
        });
    }
}
