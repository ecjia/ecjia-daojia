<?php

namespace Royalcms\Component\Api;

class ApiMain extends ApiBase
{
    
    /**
     * Constructs an instance of ApiMain that utilizes the module and format specified by $request.
     *
     * @param IContextSource|WebRequest $context If this is an instance of
     *    FauxRequest, errors are thrown and no printing occurs
     * @param bool $enableWrite Should be set to true if the api may modify data
     */
    public function __construct( $context = null, $enableWrite = false ) {
        
        
    }
    
    
    /**
     * Execute api request. Any errors will be handled if the API was called by the remote client.
     */
    public function execute() {
        if ( $this->mInternalMode ) {
            $this->executeAction();
        } else {
            $this->executeActionWithErrorHandling();
        }
    }
    
    
    
    /**
     * Execute an action, and in case of an error, erase whatever partial results
     * have been accumulated, and replace it with an error message and a help screen.
     */
    protected function executeActionWithErrorHandling() {
        
    }
    
    
    /**
     * Execute the actual module, without any error handling
     */
    protected function executeAction() {
        
    }
    
}