<?php
/**
 * Part of the Royalcms-Excel package
 */

return array(

    /*
    |--------------------------------------------------------------------------
    | Default properties
    |--------------------------------------------------------------------------
    |
    | The default properties when creating a new Excel file
    |
    */
    'properties' => array(
        'creator'        => 'Maatwebsite',
        'lastModifiedBy' => 'Maatwebsite',
        'title'          => 'Spreadsheet',
        'description'    => 'Default spreadsheet export',
        'subject'        => 'Spreadsheet export',
        'keywords'       => 'maatwebsite, excel, export',
        'category'       => 'Excel',
        'manager'        => 'Maatwebsite',
        'company'        => 'Maatwebsite',
    ),

    /*
    |--------------------------------------------------------------------------
    | Sheets settings
    |--------------------------------------------------------------------------
    */
    'sheets'     => array(

        /*
        |--------------------------------------------------------------------------
        | Default page setup
        |--------------------------------------------------------------------------
        */
        'pageSetup' => array(
            'orientation'           => 'portrait',
            'paperSize'             => '9',
            'scale'                 => '100',
            'fitToPage'             => false,
            'fitToHeight'           => true,
            'fitToWidth'            => true,
            'columnsToRepeatAtLeft' => array('', ''),
            'rowsToRepeatAtTop'     => array(0, 0),
            'horizontalCentered'    => false,
            'verticalCentered'      => false,
            'printArea'             => null,
            'firstPageNumber'       => null,
        ),
    ),

    /*
    |--------------------------------------------------------------------------
    | Creator
    |--------------------------------------------------------------------------
    |
    | The default creator of a new Excel file
    |
    */

    'creator'    => 'Maatwebsite',

);
