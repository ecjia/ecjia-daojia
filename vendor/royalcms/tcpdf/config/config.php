<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Page format
    |--------------------------------------------------------------------------
    | Default Page format. Supported formats include:
    | 4A0, 2A0, A0, A1, A2, A3, A4, A5, A6, A7, A8, A9, A10, B0,
    | B1, B2, B3, B4, B5, B6, B7, B8, B9, B10, C0, C1, C2, C3, 
    | C4, C5, C6, C7, C8, C9, C10, RA0, RA1, RA2, RA3, RA4, 
    | SRA0, SRA1, SRA2, SRA3, SRA4, LETTER, LEGAL, EXECUTIVE, 
    | FOLIO
    |
    | Or, you can optionally specify a custom format in the form
    | of a two-element array containing the width and the height.
    */

    'page_format'                 => 'A4',

    /*
    |--------------------------------------------------------------------------
    | Page Orientation
    |--------------------------------------------------------------------------
    | Default page orientation
    | P = portrait, L = landscape
    |
    */

    'page_orientation'            => 'P',

    /*
    |--------------------------------------------------------------------------
    | Page Unit
    |--------------------------------------------------------------------------
    | Default unit of measure
    | mm = millimeters, cm = centimeters, pt = points, in = inches
    | 1 point = 1/72 in = ~0.35 mm
    | 1 inch = 2.54 cm
    |
    */

    'page_unit'                   => 'mm',

    /*
    |--------------------------------------------------------------------------
    | Auto page break
    |--------------------------------------------------------------------------
    | Enables automatic flowing of content to the next page if you
    | run out of room on the current page.
    | 
    */

    'page_break_auto'             => true,

    /*
    |--------------------------------------------------------------------------
    | Default font settings
    |--------------------------------------------------------------------------
    | Page font, font size, HTML <small> font size ratio
    |
    */

    'page_font'                   => 'helvetica',
    'page_font_size'              => 10,
    'small_font_ratio'            => 2 / 3,
    'font_monospaced'             => 'courier',

    /*
    |--------------------------------------------------------------------------
    | Default document creator and author settings
    |--------------------------------------------------------------------------
    */

    'creator'                     => 'Royalcms-TCPDF by Royal Wang',
    'author'                      => 'Royalcms-TCPDF by Royal Wang',

    /*
    |--------------------------------------------------------------------------
    | Default page margin
    |--------------------------------------------------------------------------
    | Top, bottom, left, right margin settings
    | in the default unit of measure.
    */

    'margin_top'                  => 30,
    'margin_bottom'               => 30, // currently not used
    'margin_left'                 => 20,
    'margin_right'                => 20,

    /*
    |--------------------------------------------------------------------------
    | Header settings
    |--------------------------------------------------------------------------
    | Enable the header, set the font, default text, margin, description string
    | and logo
    |
    */

    'header_on'                   => true,
    'header_title'                => 'Royalcms-TCPDF',
    'header_string'               => 'by Royal Wang',
    'header_font'                 => 'helvetica',
    'header_font_size'            => 10,
    'header_logo'                 => '',
    'header_logo_width'           => 30,
    'header_margin'               => 5,
    'head_magnification'          => 1.1,
    'title_magnification'         => 1.3,

    /*
    |--------------------------------------------------------------------------
    | Footer settings
    |--------------------------------------------------------------------------
    | Enable the footer, set the font and default margin
    |
    */

    'footer_on'                   => true,
    'footer_font'                 => 'helvetica',
    'footer_font_size'            => 8,
    'footer_margin'               => 10,

    /*
    |--------------------------------------------------------------------------
    | Text encoding
    |--------------------------------------------------------------------------
    | Specify TRUE if the input text you will be using is unicode, and
    | specify the default encoding.
    |
    */

    'unicode'                     => true,
    'encoding'                    => 'UTF-8',

    /*
    |--------------------------------------------------------------------------
    | TCPDF default image directory
    |--------------------------------------------------------------------------
    | This is the image directory for TCPDF. This is where you can store
    | images to use in your PDF files.
    | Relative path from the 'public' directory
    |
    */

    'image_directory'             => 'packages/royalcms/tcpdf/images/',

    /*
    |--------------------------------------------------------------------------
    | TCPDF default (blank) image
    |--------------------------------------------------------------------------
    | This is the path and filename to the default (blank) image,
    | relative to the image directory, set above.
    | Publish the assets of this package and you're good to go
    | $ php artisan asset:publish maxxscho/laravel-tcpdf
    |
    */

    'blank_image'                 => '_blank.png',

    /*
    |--------------------------------------------------------------------------
    | TCPDF Fonts directory
    |--------------------------------------------------------------------------
    | This is the fonts directory for TCPDF relative to the public directory.
    | Leave it blank to use the default fonts of TCPDF.
    */

    'fonts_directory'             => '',

    /*
    |--------------------------------------------------------------------------
    | TCPDF image scale ratio
    |--------------------------------------------------------------------------
    | Image scale ratio (decimal format) used to adjust
    | the conversion of pixels to user units
    |
    */

    'image_scale'                 => 4,

    /*
    |--------------------------------------------------------------------------
    | TCPDF cell settings
    |--------------------------------------------------------------------------
    | Fontsize-to-height ratio, cell padding
    |
    */

    'cell_height_ratio'           => 1.25,
    'cell_padding'                => 0,

    /*
    |--------------------------------------------------------------------------
    | TCPDF disk cache settings
    |--------------------------------------------------------------------------
    | Enable caching
    | If you enable caching, you have to define a cache directory for TCPDF
    | (make sure that it is writable by the webserver)
    |
    | ADD TRAILING SLASH!
    |
    */

    'enable_disk_cache'           => false,
    'cache_directory'             => '',

    /*
    |--------------------------------------------------------------------------
    | Thai Chars setting
    |--------------------------------------------------------------------------
    | Set to true to enable the special procedure used to avoid
    | the overlappind of symbols on Thai language.
    |
    */

    'thai_topchars'               => true,

    /*
    |--------------------------------------------------------------------------
    | Calls for methods in HTML Syntax
    |--------------------------------------------------------------------------
    | If true allows to call TCPDF methods using HTML syntax
    | IMPORTANT: For security reason, disable this feature if you are printing user HTML content.
    |
    */

    'tcpdf_calls_in_html'         => true,

    /*
    |--------------------------------------------------------------------------
    | Error settings
    |--------------------------------------------------------------------------
    | If true and PHP version is greater than 5, then the Error() method
    | throw new exception instead of terminating the execution.
    |
    */

    'tcpdf_throw_exception_error' => false,
];
