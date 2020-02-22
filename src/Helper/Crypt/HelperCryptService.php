<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Crypt;

class HelperCryptService implements HelperCryptServiceInterface
{
    /**
     * @description encrypt using openssl_encrypt
     * @param string $plaintext plaintext content
     * @param string $key       password
     * @return string
     */
    public static function encrypt(string $plaintext, $key = '')
    {
        list($key, $method) = [config('helper.crypt.key'), config('helper.crypt.method', 'aes-128-ecb')];
        $key                = substr(openssl_digest(openssl_digest($key, 'sha1', true), 'sha1', true), 0, 16);
        $cipherRaw          = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA);

        return self::urlsafe_b64encode($cipherRaw);
    }

    /**
     * @description decrypt using openssl_decrypt
     * @param string $cipherText ciphertext content
     * @param string $key        password
     * @return string
     */
    public static function decrypt(string $cipherText, $key = '')
    {
        list($key, $method) = [config('helper.package.crypt.key'), config('helper.package.crypt.method', 'aes-128-ecb')];

        $key       = substr(openssl_digest(openssl_digest($key, 'sha1', true), 'sha1', true), 0, 16);
        $cipherRaw = self::urlsafe_b64decode($cipherText);

        return openssl_decrypt($cipherRaw, $method, $key, OPENSSL_RAW_DATA);
    }

    /**
     * urlsafe_b64decode
     * '-' => '+'
     * '_' => '/'
     * 字符串长度%4的余数，补'='.
     * @param string $string
     * @return string
     */
    public static function urlsafe_b64decode($string)
    {
        $data = str_replace(['-', '_'], ['+', '/'], $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }

        return base64_decode($data);
    }

    /**
     * urlsafe_b64encode
     * '+' => '-'
     * '/' => '_'
     * '=' => ''.
     * @param string $string
     * @return string
     */
    public static function urlsafe_b64encode($string)
    {
        $data = base64_encode($string);

        return str_replace(['+', '/', '='], ['-', '_', ''], $data);
    }
}
