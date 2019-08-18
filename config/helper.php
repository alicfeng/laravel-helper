<?php

/**
 * laravel-helper plugin configuration File
 * About Package Setting
 */
return [
    // about package setting
    'package' => [
        /*Response Package Structure*/
        'structure' => [
            'code'    => 'code',
            'message' => 'message',
            'data'    => 'data',
        ],

        /*Package encrypt Setting*/
        'crypt'     => [
            'instance' => \AlicFeng\Helper\Crypt\HelperCryptService::class,
            'method'   => 'aes-128-ecb',
            'password' => '1234qwer',
        ],

        /*Package format*/
        'format'    => 'json',

        /*Log*/
        'log'       => [
            'log'   => true,
            'level' => 'notice'
        ],
    ],

    //  about log setting
    'log'     => [
        'extra_field' => [
            'runtime_file'   => true,
            'memory_message' => true,
            'web_message'    => true,
            'process_id'     => true,
        ],
    ],

    // debug model setting
    'debug'   => false,
];
