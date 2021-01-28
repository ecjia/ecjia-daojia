<?php


namespace Royalcms\Component\Rewrite;


class EndpointMaskEnum
{

    /**
     * Endpoint Mask for default, which is nothing.
     *
     * @since 3.10.0
     */
    const EP_NONE = 0;

    /**
     * Endpoint Mask for Permalink.
     *
     * @since 3.10.0
     */
    const EP_PERMALINK = 1;

    /**
     * Endpoint Mask for root.
     *
     * @since 3.10.0
     */
    const EP_ROOT = 64;

}