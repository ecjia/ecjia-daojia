<?php

namespace Ecjia\App\Platform\Frameworks;

class AliasManage
{
    
    protected $alias = [
        'ecjia_platform'            => 'Ecjia\App\Platform\Frameworks\EcjiaPlatform',
        'ecjia_platform_controller' => 'Ecjia\App\Platform\Frameworks\Controller\DefaultPlatformController',
        'ecjia_platform_menu'       => 'Ecjia\App\Platform\Frameworks\Component\Menu',
        'ecjia_platform_screen'     => 'Ecjia\App\Platform\Frameworks\Component\Screen',
        'ecjia_platform_loader'     => 'Ecjia\App\Platform\Frameworks\Component\Loader',
        'ecjia_platform_page'       => 'Ecjia\App\Platform\Frameworks\Component\Page',
        'ecjia_platform_purview'    => 'Ecjia\App\Platform\Frameworks\Component\Purview',
    ];
    
    
    public function aliasLoader()
    {
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
        
        foreach ($this->alias as $key => $value) {
            $loader->alias($key, $value);
        }
    }
    
}