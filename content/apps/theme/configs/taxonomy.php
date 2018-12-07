<?php

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// TAXONOMY OPTIONS
// $options
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
return array(

    // -----------------------------------------
    // Taxonomy Options                        -
    // -----------------------------------------
    array(
        'id'       => '_custom_taxonomy_options',
        'taxonomy' => 'taxonomy_name', // category, post_tag or your custom taxonomy name
        'fields'   => array(

            array(
                'id'    => 'section_1_text',
                'type'  => 'text',
                'title' => 'Text Field',
            ),

            array(
                'id'    => 'section_1_textarea',
                'type'  => 'textarea',
                'title' => 'Textarea Field',
            ),

        ),
    ),


    array(
        'id'       => '_custom_taxonomy_options',
        'taxonomy' => 'another_taxonomy_name', // category, post_tag or your custom taxonomy name
        'fields'   => array(

            array(
                'id'    => 'section_1_text',
                'type'  => 'text',
                'title' => 'Text Field',
            ),

        ),
    ),
);

