<?php namespace Royalcms\Component\Uuid\Provider;

use Royalcms\Component\Uuid\UuidInterface;

class Pecl implements UuidInterface
{
    
    public function generate() {
        return uuid_create(UUID_TYPE_DEFAULT);
    }
}
