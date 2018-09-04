<?php namespace Royalcms\Component\DbExporter\Commands;

use Royalcms\Component\Console\Command;
use Royalcms\Component\Support\Facades\Config;

class GeneratorCommand extends Command
{
    /**
     * Get the database name from the app/config/database.php file
     * @return String
     */
    protected function getDatabaseName()
    {
        $connType = Config::get('database.default');
        $database = Config::get('database.connections.' .$connType );

        return $database['database'];
    }

    protected function blockMessage($title, $message, $style = 'info')
    {
        // Symfony style block messages
        $formatter = $this->getHelperSet()->get('formatter');
        $errorMessages = array($title, $message);
        $formattedBlock = $formatter->formatBlock($errorMessages, $style, true);
        $this->line($formattedBlock);
    }

    protected function sectionMessage($title, $message)
    {
        $formatter = $this->getHelperSet()->get('formatter');
        $formattedLine = $formatter->formatSection(
            $title,
            $message
        );
        $this->line($formattedLine);
    }
}