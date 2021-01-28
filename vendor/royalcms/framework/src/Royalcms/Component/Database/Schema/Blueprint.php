<?php


namespace Royalcms\Component\Database\Schema;


use Royalcms\Component\Support\Fluent;

class Blueprint extends \Illuminate\Database\Schema\Blueprint
{

    /**
     * Create a new Fluent command.
     *
     * @param  string  $name
     * @param  array  $parameters
     * @return \Royalcms\Component\Support\Fluent
     */
    protected function createCommand($name, array $parameters = [])
    {
        return new Fluent(array_merge(compact('name'), $parameters));
    }

    /**
     * Convert the table to a given engine.
     *
     * @param  string  $to
     * @return \Royalcms\Component\Support\Fluent
     */
    public function convertEngine($to)
    {
        return $this->addCommand('convertEngine', compact('to'));
    }

    /**
     * Convert the table to a given encoding.
     *
     * @param  string  $charset
     * @param  string  $collation
     * @return \Royalcms\Component\Support\Fluent
     */
    public function convertEncoding($charset, $collation)
    {
        return $this->addCommand('convertEncoding', compact('charset', 'collation'));
    }

    /**
     * Add the table to a given comment.
     *
     * @param  string  $comment
     * @return \Royalcms\Component\Support\Fluent
     */
    public function tableComment($comment)
    {
        return $this->addCommand('tableComment', compact('comment'));
    }

}