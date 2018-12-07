<?php

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// SHORTCODE GENERATOR OPTIONS
// $options
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
return array(
    // -----------------------------------------
    // Basic Shortcode Examples                -
    // -----------------------------------------
    array(
        'title'      => 'Basic Shortcode Examples',
        'shortcodes' => array(

            // begin: shortcode
            array(
                'name'      => 'cs_shortcode_1',
                'title'     => 'Basic Shortcode 1',
                'fields'    => array(

                    // shortcode option field
                    array(
                        'id'    => 'icon',
                        'type'  => 'icon',
                        'title' => 'Icon',
                    ),

                    array(
                        'id'    => 'image',
                        'type'  => 'image',
                        'title' => 'Image',
                    ),

                    // shortcode option field
                    array(
                        'id'    => 'gallery',
                        'type'  => 'gallery',
                        'title' => 'Gallery',
                    ),

                    // shortcode option field
                    array(
                        'id'    => 'title',
                        'type'  => 'text',
                        'title' => 'Title',
                    ),


                    // shortcode option field
                    array(
                        'id'    => 'title',
                        'type'  => 'text',
                        'title' => 'Title',
                    ),

                    // shortcode content
                    array(
                        'id'    => 'content',
                        'type'  => 'textarea',
                        'title' => 'Content',
                        'help'  => 'Lorem Ipsum Dollar.',
                    )

                ),
            ),
            // end: shortcode

            // begin: shortcode
            array(
                'name'      => 'cs_shortcode_2',
                'title'     => 'Basic Shortcode 2',
                'fields'    => array(

                    array(
                        'id'    => 'option_1',
                        'type'  => 'text',
                        'title' => 'Option 1',
                        'help'  => 'Lorem Ipsum Dollar.',
                    ),

                    array(
                        'id'    => 'option_2',
                        'type'  => 'text',
                        'title' => 'Option 2',
                    ),

                    array(
                        'id'    => 'option_3',
                        'type'  => 'text',
                        'title' => 'Option 3',
                    ),

                    array(
                        'id'    => 'content',
                        'type'  => 'textarea',
                        'title' => 'Content',
                    )

                ),
            ),
            // end: shortcode

            // begin: shortcode
            array(
                'name'      => 'cs_shortcode_3',
                'title'     => 'Basic Shortcode 3',
                'fields'    => array(

                    array(
                        'id'         => 'title',
                        'type'       => 'text',
                        'title'      => 'Title',
                    ),

                    array(
                        'id'         => 'active',
                        'type'       => 'switcher',
                        'title'      => 'Active',
                        'label'      => 'You you want to it ?',
                    ),

                    array(
                        'id'         => 'car',
                        'type'       => 'select',
                        'title'      => 'Your car',
                        'options'    => array(
                            'bmw'      => 'BMW',
                            'mercedes' => 'Mercedes',
                            'opel'     => 'Opel',
                            'ferrari'  => 'Ferrari'
                        )
                    ),

                    array(
                        'id'         => 'content',
                        'type'       => 'textarea',
                        'title'      => 'Content',
                    )

                ),
            ),
            // end: shortcode

            // begin: shortcode
            array(
                'name'      => 'cs_shortcode_4',
                'title'     => 'Basic Shortcode 4',
                'fields'    => array(

                    array(
                        'id'         => 'title',
                        'type'       => 'text',
                        'title'      => 'Title',
                    ),

                    array(
                        'id'         => 'active',
                        'type'       => 'radio',
                        'title'      => 'Active',
                        'options'    => array(
                            'yes'      => 'Yes, Please.',
                            'no'       => 'No, Thank you.',
                        )
                    ),

                    array(
                        'id'         => 'cars',
                        'type'       => 'checkbox',
                        'title'      => 'Select your cars',
                        'options'    => array(
                            'bmw'      => 'BMW',
                            'mercedes' => 'Mercedes',
                            'open'     => 'Opel',
                            'ferrari'  => 'Ferrari'
                        )
                    ),

                    array(
                        'id'         => 'avatar',
                        'type'       => 'upload',
                        'title'      => 'Avatar',
                    ),

                    array(
                        'id'         => 'content',
                        'type'       => 'textarea',
                        'title'      => 'Content',
                    )

                ),
            ),
            // end: shortcode

            // begin: shortcode
            array(
                'name'      => 'cs_shortcode_5',
                'title'     => 'Basic Shortcode 5',
                'fields'    => array(

                    array(
                        'id'         => 'layout',
                        'title'      => 'Layout',
                        'type'       => 'image_select',
                        'options'    => array(
                            'layout-1' => 'http://codestarframework.com/assets/images/placeholder/65x65-2ecc71.gif',
                            'layout-2' => 'http://codestarframework.com/assets/images/placeholder/65x65-e74c3c.gif',
                            'layout-3' => 'http://codestarframework.com/assets/images/placeholder/65x65-3498db.gif',
                        ),
                    ),

                    array(
                        'id'         => 'cars',
                        'type'       => 'select',
                        'title'      => 'Select your cars',
                        'options'    => array(
                            'bmw'      => 'BMW',
                            'mercedes' => 'Mercedes',
                            'open'     => 'Opel',
                            'ferrari'  => 'Ferrari',
                            'jaguar'   => 'Jaguar',
                            'seat'     => 'Seat',
                        ),
                        'attributes' => array(
                            'multiple' => 'only-key',
                            'style'    => 'width: 125px; height: 100px;',
                        )
                    ),

                    array(
                        'id'    => 'content',
                        'type'  => 'textarea',
                        'title' => 'Content',
                    )

                ),
            ),
            // end: shortcode

        ),
    ),

    // -----------------------------------------
    // Simple Shortcode Examples               -
    // -----------------------------------------
    array(
        'title'      => 'Simple Shortcode Examples',
        'shortcodes' => array(

            // begin: shortcode
            array(
                'name'      => 'cs_simple_1',
                'title'     => 'Simple Shortcode 1',
                'fields'    => array(

                    array(
                        'id'    => 'title',
                        'type'  => 'text',
                        'title' => 'Title',
                    ),

                ),
            ),
            // end: shortcode

            // begin: shortcode
            array(
                'name'      => 'cs_simple_2',
                'title'     => 'Simple Shortcode 2',
                'fields'    => array(

                    array(
                        'id'    => 'option_1',
                        'type'  => 'text',
                        'title' => 'Option 1',
                    ),

                    array(
                        'id'    => 'option_2',
                        'type'  => 'text',
                        'title' => 'Option 2',
                    ),

                    array(
                        'id'    => 'option_3',
                        'type'  => 'text',
                        'title' => 'Option 3',
                    ),

                ),
            ),
            // end: shortcode

            // begin: shortcode
            array(
                'name'      => 'cs_simple_3',
                'title'     => 'Simple Shortcode 3',
                'fields'    => array(

                    array(
                        'id'         => 'title',
                        'type'       => 'text',
                        'title'      => 'Title',
                    ),

                    array(
                        'id'         => 'active',
                        'type'       => 'switcher',
                        'title'      => 'Active',
                        'label'      => 'You you want to it ?',
                    ),

                    array(
                        'id'         => 'car',
                        'type'       => 'select',
                        'title'      => 'Your car',
                        'options'    => array(
                            'bmw'      => 'BMW',
                            'mercedes' => 'Mercedes',
                            'opel'     => 'Opel',
                            'ferrari'  => 'Ferrari'
                        )
                    ),

                ),
            ),
            // end: shortcode

        ),
    ),


    // -----------------------------------------
    // Single Shortcode Examples               -
    // -----------------------------------------
    array(
        'title'      => 'Single Shortcode Examples',
        'shortcodes' => array(

            // begin: shortcode
            array(
                'name'      => 'cs_single_1',
                'title'     => 'Single Shortcode 1',
                'fields'    => array(

                    array(
                        'type'    => 'content',
                        'content' => 'Just click to "Insert Shortcode, this is adding a single shortcode',
                    ),

                ),
            ),
            // end: shortcode


            // begin: shortcode
            array(
                'name'      => 'cs_single_2',
                'title'     => 'Single Shortcode 2',
                'fields'    => array(

                    array(
                        'type'    => 'content',
                        'content' => 'Just click to "Insert Shortcode, this is adding a single shortcode',
                    ),

                ),
            ),
            // end: shortcode

            // begin: shortcode
            array(
                'name'      => 'cs_single_3',
                'title'     => 'Single Shortcode 3',
                'fields'    => array(

                    array(
                        'id'    => 'content',
                        'type'  => 'textarea',
                        'title' => 'Content',
                        'help'  => 'This is a single shortcode and there is only content.',
                    )

                ),
            ),
            // end: shortcode

        ),
    ),

    // -----------------------------------------
    // Advanced Shortcode Examples             -
    // -----------------------------------------
    array(
        'title'      => 'Advanced Shortcode Examples',
        'shortcodes' => array(

            // begin: shortcode
            array(
                'name'           => 'cs_advanced_1',
                'title'          => 'Duplicate Shortcode',
                'view'           => 'clone_duplicate',
                'clone_title'    => 'Add New',
                'clone_fields'   => array(

                    array(
                        'id'         => 'title',
                        'type'       => 'text',
                        'title'      => 'Title',
                    ),

                    array(
                        'id'         => 'content',
                        'type'       => 'textarea',
                        'title'      => 'Content',
                    ),

                )
            ),
            // end: shortcode

            // begin: shortcode
            array(
                'name'          => 'cs_advanced_3',
                'title'         => 'Duplicate Group Shortcode',
                'view'          => 'clone',
                'clone_id'      => 'cs_advanced_3_sub',
                'clone_title'   => 'Add New',
                'fields'        => array(

                    array(
                        'id'        => 'option_1',
                        'type'      => 'text',
                        'title'     => 'Option 1',
                    ),

                    array(
                        'id'        => 'option_2',
                        'type'      => 'select',
                        'title'     => 'Option 2',
                        'shortcodes'   => array(
                            'value-1' =>  'Value 1',
                            'value-2' =>  'Value 2',
                            'value-3' =>  'Value 3',
                        ),
                    ),

                ),
                'clone_fields'  => array(

                    array(
                        'id'        => 'title',
                        'type'      => 'text',
                        'title'     => 'Tab Title',
                    ),

                    array(
                        'id'        => 'content',
                        'type'      => 'textarea',
                        'title'     => 'Content',
                    ),
                )
            ),
            // end: shortcode

            // begin: shortcode
            array(
                'name'           => 'cs_advanced_4',
                'title'          => 'Contents Shortcode',
                'view'           => 'contents',
                'fields'         => array(

                    array(
                        'id'         => 'content_1',
                        'type'       => 'textarea',
                        'title'      => 'Content 1',
                    ),

                    array(
                        'id'         => 'content_2',
                        'type'       => 'textarea',
                        'title'      => 'Content 2',
                    )

                ),
            ),
            // end: shortcode

        ),
    ),


);

