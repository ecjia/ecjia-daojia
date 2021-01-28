<?php


namespace Ecjia\System\Providers;


use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Support\Facades\Schema;
use Royalcms\Component\Support\Fluent;
use Royalcms\Component\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerSchemaMacros();
    }

    /**
     * Register the schema macros.
     */
    protected function registerSchemaMacros()
    {
        Blueprint::macro('dropIndexIfExists', function(string $index): Fluent {
            if ($this->hasIndex($index)) {
                return $this->dropIndex($index);
            }

            return new Fluent();
        });

        Blueprint::macro('hasIndex', function(string $index): bool {
            $conn = Schema::getConnection();
            if ($conn->pretending()) {
                return true;
            }

            $dbSchemaManager = $conn->getDoctrineSchemaManager();
            $table = $conn->getTablePrefix().$this->getTable();
            $doctrineTable = $dbSchemaManager->listTableDetails($table);

            return $doctrineTable->hasIndex($index);
        });

        Blueprint::macro('hasPrimaryKey', function(string $index): bool {
            $conn = Schema::getConnection();
            if ($conn->pretending()) {
                return true;
            }

            $dbSchemaManager = $conn->getDoctrineSchemaManager();
            $table = $conn->getTablePrefix().$this->getTable();
            $doctrineTable = $dbSchemaManager->listTableDetails($table);

            return $doctrineTable->hasPrimaryKey($index);
        });
    }

}