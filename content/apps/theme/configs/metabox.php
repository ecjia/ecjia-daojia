<?php

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// METABOX OPTIONS
// $options
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
return array(

    // -----------------------------------------
    // Page Metabox Options                    -
    // -----------------------------------------
    array(
        'id'        => '_custom_page_options',
        'title'     => 'Custom Page Options',
        'post_type' => 'page',
        'context'   => 'normal',
        'priority'  => 'default',
        'sections'  => array(

            // begin: a section
            array(
                'name'  => 'section_1',
                'title' => 'Section 1',
                'icon'  => 'fa fa-cog',

                // begin: fields
                'fields' => array(

                    // begin: a field
                    array(
                        'id'    => 'section_1_text',
                        'type'  => 'text',
                        'title' => 'Text Field',
                    ),
                    // end: a field

                    array(
                        'id'    => 'section_1_textarea',
                        'type'  => 'textarea',
                        'title' => 'Textarea Field',
                    ),

                    array(
                        'id'    => 'section_1_upload',
                        'type'  => 'upload',
                        'title' => 'Upload Field',
                    ),

                    array(
                        'id'    => 'section_1_switcher',
                        'type'  => 'switcher',
                        'title' => 'Switcher Field',
                        'label' => 'Yes, Please do it.',
                    ),

                ), // end: fields
            ), // end: a section

            // begin: a section
            array(
                'name'  => 'section_2',
                'title' => 'Section 2',
                'icon'  => 'fa fa-tint',
                'fields' => array(

                    array(
                        'id'      => 'section_2_color_picker_1',
                        'type'    => 'color_picker',
                        'title'   => 'Color Picker 1',
                        'default' => '#2ecc71',
                    ),

                    array(
                        'id'      => 'section_2_color_picker_2',
                        'type'    => 'color_picker',
                        'title'   => 'Color Picker 2',
                        'default' => '#3498db',
                    ),

                    array(
                        'id'      => 'section_2_color_picker_3',
                        'type'    => 'color_picker',
                        'title'   => 'Color Picker 3',
                        'default' => '#9b59b6',
                    ),

                    array(
                        'id'      => 'section_2_color_picker_4',
                        'type'    => 'color_picker',
                        'title'   => 'Color Picker 4',
                        'default' => '#34495e',
                    ),

                    array(
                        'id'      => 'section_2_color_picker_5',
                        'type'    => 'color_picker',
                        'title'   => 'Color Picker 5',
                        'default' => '#e67e22',
                    ),

                ),
            ),
            // end: a section

        ),
    ),

    // -----------------------------------------
    // Page Side Metabox Options               -
    // -----------------------------------------
    array(
        'id'        => '_custom_page_side_options',
        'title'     => 'Custom Page Side Options',
        'post_type' => 'page',
        'context'   => 'side',
        'priority'  => 'default',
        'sections'  => array(

            array(
                'name'   => 'section_3',
                'fields' => array(

                    array(
                        'id'        => 'section_3_image_select',
                        'type'      => 'image_select',
                        'options'   => array(
                            'value-1' => 'http://codestarframework.com/assets/images/placeholder/65x65-2ecc71.gif',
                            'value-2' => 'http://codestarframework.com/assets/images/placeholder/65x65-e74c3c.gif',
                            'value-3' => 'http://codestarframework.com/assets/images/placeholder/65x65-3498db.gif',
                        ),
                        'default'   => 'value-2',
                    ),

                    array(
                        'id'            => 'section_3_text',
                        'type'          => 'text',
                        'attributes'    => array(
                            'placeholder' => 'do stuff'
                        )
                    ),

                    array(
                        'id'      => 'section_3_switcher',
                        'type'    => 'switcher',
                        'label'   => 'Are you sure ?',
                        'default' => true
                    ),

                ),
            ),

        ),
    ),

    // -----------------------------------------
    // Post Metabox Options                    -
    // -----------------------------------------
    array(
        'id'        => '_custom_post_options',
        'title'     => 'Custom Post Options',
        'post_type' => 'post',
        'context'   => 'normal',
        'priority'  => 'default',
        'sections'  => array(

            array(
                'name'   => 'section_4',
                'fields' => array(

                    array(
                        'id'    => 'section_4_text',
                        'type'  => 'text',
                        'title' => 'Text Field',
                    ),

                    array(
                        'id'    => 'section_4_textarea',
                        'type'  => 'textarea',
                        'title' => 'Textarea Field',
                    ),

                    array(
                        'id'    => 'section_4_upload',
                        'type'  => 'upload',
                        'title' => 'Upload Field',
                    ),

                    array(
                        'id'    => 'section_4_switcher',
                        'type'  => 'switcher',
                        'title' => 'Switcher Field',
                        'label' => 'Yes, Please do it.',
                    ),

                ),
            ),

        ),
    ),


);

