<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Helper;

/**
 * Marks a row as being a separator.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TableSeparator extends TableCell
{
<<<<<<< HEAD
    public function __construct(array $options = array())
=======
    public function __construct(array $options = [])
>>>>>>> v2-test
    {
        parent::__construct('', $options);
    }
}
