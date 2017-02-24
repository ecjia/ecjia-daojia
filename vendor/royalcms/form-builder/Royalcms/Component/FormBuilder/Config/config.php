<?php

return [
    'defaults'      => [
        'wrapper_class'       => 'form-group',
        'wrapper_error_class' => 'has-error',
        'label_class'         => 'control-label',
        'field_class'         => 'form-control',
        'help_block_class'    => 'help-block',
        'error_class'         => 'text-danger',
        'required_class'      => 'required'
    ],
    // Templates
    'form'          => 'form-builder::form',
    'text'          => 'form-builder::text',
    'textarea'      => 'form-builder::textarea',
    'button'        => 'form-builder::button',
    'radio'         => 'form-builder::radio',
    'checkbox'      => 'form-builder::checkbox',
    'select'        => 'form-builder::select',
    'choice'        => 'form-builder::choice',
    'repeated'      => 'form-builder::repeated',
    'child_form'    => 'form-builder::child_form',
    'collection'    => 'form-builder::collection',
    'static'        => 'form-builder::static',

    'default_namespace' => '',

    'custom_fields' => [
//        'datetime' => 'App\Forms\Fields\Datetime'
    ]
];
