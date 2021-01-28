<?php


namespace Ecjia\App\Installer\Subscribers;


use Royalcms\Component\Hook\Dispatcher;

class FrontHookSubscriber
{

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Royalcms\Component\Hook\Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->addAction(
            'ecjia_installer_finished_after',
            'Ecjia\App\Installer\Hookers\ResetDatabaseConfigAction',
            8
        );

        $events->addAction(
            'ecjia_installer_finished_after',
            'Ecjia\App\Installer\Hookers\UpdateEcjiaInstallDateAction',
            10
        );

        $events->addAction(
            'ecjia_installer_finished_after',
            'Ecjia\App\Installer\Hookers\UpdateEcjiaVersionAction',
            12
        );

        $events->addAction(
            'ecjia_installer_finished_after',
            'Ecjia\App\Installer\Hookers\UpdateHashCodeAction',
            14
        );

        $events->addAction(
            'ecjia_installer_finished_after',
            'Ecjia\App\Installer\Hookers\SaveInstallLockFileAction',
            18
        );

        $events->addAction(
            'ecjia_installer_finished_after',
            'Ecjia\App\Installer\Hookers\CreateStorageDirectoryAction',
            20
        );

    }

}