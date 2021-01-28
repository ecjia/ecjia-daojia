<?php

namespace Royalcms\Component\NativeSession;

trait CompatibleTrait
{
    
    /**
     * Get the session handler.
     *
     * @return void
     * @todo $_SESSION
     */
    public function session()
    {
        return $this->getHandler();
    }
    
    /**
     * Get the session id.
     *
     * @return string
     * @todo $_SESSION
     */
    public function session_id()
    {
        return $this->getId();
    }
    
    /**
     * Destroy the session data from the handler.
     *
     * @return void
     * @todo $_SESSION
     */
    public function destroy()
    {
        return $this->flush();
    }
    
    /**
     * Delete the session data from the handler.
     *
     * @return void
     * @todo $_SESSION
     */
    public function delete($name)
    {
        $this->remove($name);
    }
}

// end