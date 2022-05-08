<?php

return [
    Illuminate\Foundation\Console\DownCommand::class,
    Illuminate\Foundation\Console\UpCommand::class,
    Illuminate\Foundation\Console\VendorPublishCommand::class,

    Royalcms\Component\Foundation\Console\ClearCompiledCommand::class,
    Royalcms\Component\Foundation\Console\EnvironmentCommand::class,
    Royalcms\Component\Foundation\Console\KeyGenerateCommand::class,

    Royalcms\Component\Foundation\Console\PackageDiscoverCommand::class,
    Royalcms\Component\Foundation\Console\OptimizeCommand::class,
    Royalcms\Component\Foundation\Console\OptimizeClearCommand::class,
    Royalcms\Component\Foundation\Console\OptimizeCompileCommand::class,
    Royalcms\Component\Foundation\Console\OptimizeAliasCommand::class,

];