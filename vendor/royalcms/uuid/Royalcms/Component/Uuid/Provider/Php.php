<?php namespace Royalcms\Component\Uuid\Provider;

use Royalcms\Component\Uuid\UuidInterface;

class Php implements UuidInterface 
{
    
    public function generate() {
        $salt = substr(hash('sha256', microtime(true) . mt_rand()), 0, 64);
        $hex  = substr(hash('sha256', $salt), 0, 32);
        $time_low = substr($hex, 0, 8);
        $time_mid = substr($hex, 8, 4);
        $time_hi_and_version = base_convert(substr($hex, 12, 4), 16, 10);
        $time_hi_and_version &= 0x0FFF;
        $time_hi_and_version |= (4 << 12);
        $clock_seq_hi_and_reserved = base_convert(substr($hex, 16, 4), 16, 10);
        $clock_seq_hi_and_reserved &= 0x3F;
        $clock_seq_hi_and_reserved |= 0x80;
        $clock_seq_low = substr($hex, 20, 2);
        $nodes = substr($hex, 20);
        $uuid  = sprintf('%s-%s-%04x-%02x%02x-%s',
                    $time_low, $time_mid,
                    $time_hi_and_version, $clock_seq_hi_and_reserved,
                    $clock_seq_low, $nodes
                );

        return $uuid;
    }
}
