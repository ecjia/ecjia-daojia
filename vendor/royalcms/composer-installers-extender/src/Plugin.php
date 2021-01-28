<?php

declare(strict_types = 1);

namespace Royalcms\Composer\ComposerInstallersExtender;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
    /**
     * {@inheritDoc}
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        $installer = new Installers\Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
        
        $custom_installer = new CustomInstallers\Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($custom_installer);
    }

    /**
     * {@inheritDoc}
     */
    public function deactivate(Composer $composer, IOInterface $io): void
    {
    }

    /**
     * {@inheritDoc}
     */
    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }
}
