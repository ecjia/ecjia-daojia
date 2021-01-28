<?php

namespace Royalcms\Component\App;

class Helper
{
    
    /**
     * Callback to sort array by a 'Name' key.
     *
     * @since 3.2.0
     * @access private
     */
    public static function sort_uname_callback($a, $b) {
        return strnatcasecmp( $a->getAlias(), $b->getAlias() );
    }
    
}