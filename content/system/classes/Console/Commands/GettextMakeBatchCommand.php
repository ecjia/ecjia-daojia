<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 15:34
 */

namespace Ecjia\System\Console\Commands;

use Royalcms\Component\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

// run the CLI only if the file
// wasn't included
class GettextMakeBatchCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ecjia:gettext-makeall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generate All POT file from the files in all directories";


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $type = $this->argument('type');

        if ($type == 'system') {
            $commands = [
                'ecjia:gettext-makepot ecjia-system content/system/',
            ];
        }
        elseif ($type == 'app') {
            $commands = $this->fetchAppDirs();
        }
        elseif ($type == 'plugin') {
            $commands = $this->fetchPluginDirs();
        }
        elseif ($type == 'theme') {
            $commands = $this->fetchThemeDirs();
        }
        else {
            $apps = $this->fetchAppDirs();
            $plugins = $this->fetchPluginDirs();
            $themes = $this->fetchThemeDirs();

            $commands = [
                'ecjia:gettext-makepot ecjia-system content/system/',
            ];

            $commands = array_merge($commands, $apps);
            $commands = array_merge($commands, $plugins);
            $commands = array_merge($commands, $themes);
        }

        collect($commands)->each(function($item) {
            list($cmd, $project, $directory) = explode(' ', $item);
            $this->call($cmd, ['project' => $project, 'directory' => base_path($directory)]);
        });

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['type', InputArgument::OPTIONAL, 'Available types: all, system, app, theme, plugin', 'all'],
        ];
    }

    /**
     * 获取所有的应用目录
     * @return mixed
     */
    protected function fetchAppDirs()
    {
        $dirs = [
            'content/apps',
        ];

        $items = collect($dirs)->map(function($item) {
            $items = \RC_File::directories($item);
            return $items;
        })
            ->collapse()
            ->map(function($item) {
                return 'ecjia:gettext-makepot ecjia-app ' . $item;
            })
            ->all();

        return $items;
    }

    /**
     * 获取所有的插件目录
     * @return mixed
     */
    protected function fetchPluginDirs()
    {
        $dirs = [
            'content/plugins',
        ];

        $items = collect($dirs)->map(function($item) {
            $items = \RC_File::directories($item);
            return $items;
        })
            ->collapse()
            ->map(function($item) {
            return 'ecjia:gettext-makepot ecjia-plugin ' . $item;
        })
            ->all();

        return $items;
    }

    /**
     * 获取所有的插件目录
     * @return mixed
     */
    protected function fetchThemeDirs()
    {
        $dirs = [
            'content/themes',
            'sites/m/content/themes',
            'sites/member/content/themes',
            'sites/help/content/themes',
            'sites/cityadmin/content/themes',
            'sites/app/content/themes',
        ];

        $items = collect($dirs)->map(function($item) {
            $items = \RC_File::directories($item);
            return $items;
        })
            ->collapse()
            ->map(function($item) {
                return 'ecjia:gettext-makepot ecjia-theme ' . $item;
            })
            ->all();

        return $items;
    }


}