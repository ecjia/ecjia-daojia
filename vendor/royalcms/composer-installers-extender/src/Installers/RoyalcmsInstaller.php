<?php


namespace Royalcms\Composer\ComposerInstallersExtender\Installers;

use Composer\Installers\BaseInstaller;

class RoyalcmsInstaller extends BaseInstaller
{

    protected $locations = array(
        'app'    => 'content/apps/{$name}/',
        'plugin' => 'content/plugins/{$name}/',
        'theme'  => 'content/themes/{$name}/',
        'system' => 'content/{$name}/',
    );

    /**
     * Format package name.
     *
     * For package type app-xxx, cut off a trailing '-app' if present.
     *
     * For package type plugin-xxx, cut off a trailing '-plugin' if present.
     *
     * For package type theme-xx, cut off a trailing '-theme' if present.
     *
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === 'royalcms-app') {
            return $this->inflectAppVars($vars);
        }
        elseif ($vars['type'] === 'royalcms-plugin') {
            return $this->inflectPluginVars($vars);
        }
        elseif ($vars['type'] === 'royalcms-theme') {
            return $this->inflectThemeVars($vars);
        }
        elseif ($vars['type'] === 'royalcms-system') {
            return $this->inflectSystemVars($vars);
        }

        return $vars;
    }

    protected function inflectAppVars($vars)
    {
        $vars['name'] = preg_replace('/^app-|-app$/', '', $vars['name']);

        return $vars;
    }

    protected function inflectPluginVars($vars)
    {
        $vars['name'] = preg_replace('/^plugin-|-plugin$/', '', $vars['name']);

        return $vars;
    }

    protected function inflectThemeVars($vars)
    {
        $vars['name'] = preg_replace('/^theme-|-theme$/', '', $vars['name']);

        return $vars;
    }

    protected function inflectSystemVars($vars)
    {
        $vars['name'] = preg_replace('/^system-|-system/', '', $vars['name']);
        
        return $vars;
    }

}
