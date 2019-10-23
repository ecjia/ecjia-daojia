<?php namespace Royalcms\Component\WeChat\Message;

/**
 * Class Transfer.
 *
 * @property string $to
 * @property string $account
 */
class Transfer extends AbstractMessage
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'transfer_customer_service';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = [
                             'account',
                            ];
}
