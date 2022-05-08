<?php

Swift_DependencyContainer::getInstance()
    ->register('cache')
    ->asAliasOf('cache.array')

    ->register('tempdir')
    ->asValue('/tmp')

    ->register('cache.null')
    ->asSharedInstanceOf('Swift_KeyCache_NullKeyCache')

    ->register('cache.array')
    ->asSharedInstanceOf('Swift_KeyCache_ArrayKeyCache')
<<<<<<< HEAD
    ->withDependencies(array('cache.inputstream'))

    ->register('cache.disk')
    ->asSharedInstanceOf('Swift_KeyCache_DiskKeyCache')
    ->withDependencies(array('cache.inputstream', 'tempdir'))
=======
    ->withDependencies(['cache.inputstream'])

    ->register('cache.disk')
    ->asSharedInstanceOf('Swift_KeyCache_DiskKeyCache')
    ->withDependencies(['cache.inputstream', 'tempdir'])
>>>>>>> v2-test

    ->register('cache.inputstream')
    ->asNewInstanceOf('Swift_KeyCache_SimpleKeyCacheInputStream')
;
