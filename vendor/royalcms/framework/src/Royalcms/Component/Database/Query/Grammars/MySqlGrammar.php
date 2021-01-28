<?php

namespace Royalcms\Component\Database\Query\Grammars;

use Royalcms\Component\Database\Query\Expression;

class MySqlGrammar extends \Illuminate\Database\Query\Grammars\MySqlGrammar
{


    /**
     * Wrap a table in keyword identifiers.
     *
     * @param  \Royalcms\Component\Database\Query\Expression|string  $table
     * @return string
     */
    public function wrapTable($table)
    {
        if ($this->isExpression($table)) {
            return $this->getValue($table);
        }

        /**
         * @todo royalcms
         * ver4.1 used $prefixAlias is false, since 5.0 used $prefixAlias is true.
         * This is reset $prefixAlias is fasle.
         */
        return $this->wrap($this->tablePrefix.$table, false);
    }


}
