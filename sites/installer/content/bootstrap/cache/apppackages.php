<?php return array (
  'ecjia.installer' => 
  array (
    'providers' => 
    array (
      0 => 'Ecjia\\App\\Installer\\InstallerServiceProvider',
    ),
    'aliases' => 
    array (
    ),
    'autoload_psr4' => 
    array (
      'Ecjia\\App\\Installer\\' => '/sites/installer/../../sites/installer/content/apps/installer/classes/',
    ),
  ),
  'ecjia.logviewer' => 
  array (
    'providers' => 
    array (
      0 => 'Ecjia\\App\\Logviewer\\LogviewerServiceProvider',
    ),
    'aliases' => 
    array (
    ),
    'autoload_psr4' => 
    array (
      'Ecjia\\App\\Logviewer\\' => '/sites/installer/../../content/apps/logviewer/classes/',
    ),
  ),
  'ecjia.upgrade' => 
  array (
    'providers' => 
    array (
      0 => 'Ecjia\\App\\Upgrade\\UpgradeServiceProvider',
    ),
    'aliases' => 
    array (
    ),
    'autoload_psr4' => 
    array (
      'Ecjia\\App\\Upgrade\\' => '/sites/installer/../../sites/installer/content/apps/upgrade/classes/',
    ),
  ),
);