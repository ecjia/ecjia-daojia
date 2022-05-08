<?php


namespace Royalcms\Component\Database\Schema\Grammars;

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Support\Fluent;

class MySqlGrammar extends \Illuminate\Database\Schema\Grammars\MySqlGrammar
{
    /**
     * Compile a convert table charset and collation command.
     *
     * @param  \Royalcms\Component\Database\Schema\Blueprint  $blueprint
     * @param  \Royalcms\Component\Support\Fluent  $command
     * @return string
     */
    public function compileConvertEncoding(Blueprint $blueprint, Fluent $command)
    {
        $from = $this->wrapTable($blueprint);

        return "alter table {$from} convert to character set {$command->charset} collate {$command->collation}";
    }

    /**
     * Compile a convert table engine command.
     *
     * @param  \Royalcms\Component\Database\Schema\Blueprint  $blueprint
     * @param  \Royalcms\Component\Support\Fluent  $command
     * @return string
     */
    public function compileConvertEngine(Blueprint $blueprint, Fluent $command)
    {
        $from = $this->wrapTable($blueprint);

        return "alter table {$from} engine = ".$command->to;
    }

    /**
     * Compile a add table comment command.
     *
     * @param  \Royalcms\Component\Database\Schema\Blueprint  $blueprint
     * @param  \Royalcms\Component\Support\Fluent  $command
     * @return string
     */
    public function compileTableComment(Blueprint $blueprint, Fluent $command)
    {
        $from = $this->wrapTable($blueprint);

        return "alter table {$from} comment ". "'{$command->comment}'";
    }

}