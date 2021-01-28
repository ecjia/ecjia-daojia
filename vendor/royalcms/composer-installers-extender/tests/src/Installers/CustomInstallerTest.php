<?php

declare(strict_types = 1);

namespace Royalcms\Composer\ComposerInstallersExtender\Tests\Installers;

use PHPUnit\Framework\TestCase;
use Royalcms\Composer\ComposerInstallersExtender\Installers\CustomInstaller;

class CustomInstallerTest extends TestCase
{
    public function testLocations(): void
    {
        $installer = (new \ReflectionClass(CustomInstaller::class))
            ->newInstanceWithoutConstructor();
        $this->assertEmpty($installer->getLocations());
    }
}
