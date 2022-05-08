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

use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
class TableCell
{
    private $value;
<<<<<<< HEAD
    private $options = array(
        'rowspan' => 1,
        'colspan' => 1,
    );

    /**
     * @param string $value
     * @param array  $options
     */
    public function __construct($value = '', array $options = array())
    {
        if (is_numeric($value) && !\is_string($value)) {
            $value = (string) $value;
        }

=======
    private $options = [
        'rowspan' => 1,
        'colspan' => 1,
        'style' => null,
    ];

    public function __construct(string $value = '', array $options = [])
    {
>>>>>>> v2-test
        $this->value = $value;

        // check option names
        if ($diff = array_diff(array_keys($options), array_keys($this->options))) {
            throw new InvalidArgumentException(sprintf('The TableCell does not support the following options: \'%s\'.', implode('\', \'', $diff)));
        }

<<<<<<< HEAD
=======
        if (isset($options['style']) && !$options['style'] instanceof TableCellStyle) {
            throw new InvalidArgumentException('The style option must be an instance of "TableCellStyle".');
        }

>>>>>>> v2-test
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Returns the cell value.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * Gets number of colspan.
     *
     * @return int
     */
    public function getColspan()
    {
        return (int) $this->options['colspan'];
    }

    /**
     * Gets number of rowspan.
     *
     * @return int
     */
    public function getRowspan()
    {
        return (int) $this->options['rowspan'];
    }
<<<<<<< HEAD
=======

    public function getStyle(): ?TableCellStyle
    {
        return $this->options['style'];
    }
>>>>>>> v2-test
}
