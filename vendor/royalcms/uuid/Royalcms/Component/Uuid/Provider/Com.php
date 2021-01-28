<?php namespace Royalcms\Component\Uuid\Provider;

use Royalcms\Component\Uuid\UuidInterface;

class Com implements UuidInterface
{

    public function generate() {
        return strtolower(trim(com_create_guid(), '{}'));
    }
}
