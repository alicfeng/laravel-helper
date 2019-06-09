<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Crypt;

interface HelperCryptServiceInterface
{
    public static function encrypt(string $plaintext, $key = '');

    public static function decrypt(string $cipherText, $key = '');
}
