<?php

namespace Royalcms\Component\Api;

use Royalcms\Component\Api\Contracts\IContextSource;

abstract class ContextSource
{
    
    /**
     * @var IContextSource
     */
    private $context;
    
    
    /**
     * Get the base IContextSource object
     * @return IContextSource
     */
    public function getContext() {
        
        return $this->context;
    }
    
    /**
     * Set the IContextSource object
     *
     * @since 1.18
     * @param IContextSource $context
     */
    public function setContext( IContextSource $context ) {
        $this->context = $context;
    }
    
}