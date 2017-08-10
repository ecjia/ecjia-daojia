<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom  Salt
    |--------------------------------------------------------------------------
    |
    | Hashids supports personalizing your hashes by accepting a salt value.
    | If you don't want others to decrypt your hashes, provide a unique
    | string used for salting.
    |
    */

    'salt' => env('HASHIDS_SALT', 'THISISMYREALLYSECRETSALT'),

    /*
    |--------------------------------------------------------------------------
    | Hash Length
    |--------------------------------------------------------------------------
    |
    | By default, hashes are going to be the shortest possible. You can also
    | set the minimum hash length to obfuscate how large the number behind
    | the hash is.
    |
    */

    'length' => env('HASHIDS_LENGTH', 8),

    /*
    |--------------------------------------------------------------------------
    | Custom alphabet
    |--------------------------------------------------------------------------
    |
    | The default alphabet contains all lowercase and uppercase letters
    | and numbers. If you'd like to make it longer, you can add more
    | characters like - @ $ % ^ & * ( ) [ ] { }
    |
    */

    'alphabet' => env('HASHIDS_ALPHABET', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'),

];
