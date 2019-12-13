<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

return [
    // about package setting
    'package'   => [
        /*Response Package Structure*/
        'structure' => [
            'code'    => 'code',
            'message' => 'message',
            'data'    => 'data',
        ],

        // Default Header simple:Content-Type => application/json
        'header'    => [

        ],

        /*Package encrypt Setting*/
        'crypt'     => [
            'instance' => \AlicFeng\Helper\Crypt\HelperCryptService::class,
            'method'   => 'aes-128-ecb',
            'password' => '1234qwer',
        ],

        /*Package format (json | xml)*/
        'format'    => 'json',

        /*Log*/
        'log'       => [
            'log'   => true,
            'level' => 'notice',
        ],
    ],

    // about log setting
    'log'       => [
        'extra_field' => [
            'runtime_file'   => true,
            'memory_message' => false,
            'web_message'    => false,
            'process_id'     => false,
        ],
    ],

    // translate
    'translate' => [
        'model'    => true,
        'instance' => \AlicFeng\Helper\Translate\Translation::class,
    ],

    // runtime model
    'runtime'   => [
        'trace' => [
            'request'    => true,
            'response'   => false,
            'filter_uri' => [

            ]
        ],
    ],

    // debug model setting
    'debug'     => false,
];
