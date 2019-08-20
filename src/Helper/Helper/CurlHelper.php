<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Helper;

use Illuminate\Support\Facades\Response;

class CurlHelper
{
    const POST   = 'POST';
    const GET    = 'GET';
    const DELETE = 'DELETE';
    const PUT    = 'PUT';

    public static function post($url, array $parameters = [], array $headers = [], bool $json = true)
    {
        return self::common(self::POST, $url, $parameters, $headers, $json);
    }

    public static function delete($url, array $parameters = [], array $headers = [], bool $json = true)
    {
        return self::common(self::DELETE, $url, $parameters, $headers, $json);
    }

    public static function get($url, array $parameters = [], array $headers = [])
    {
        if ($query = http_build_query($parameters)) {
            $url .= '?' . $query;
        }
        $request = self::request($url, $headers, false);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, self::GET);

        return self::execute($request);
    }

    private static function common($method, $url, array $parameters = [], array $headers = [], bool $json = true)
    {
        $request = self::request($url, $headers, $json);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, $method);
        self::parameters($request, $parameters, $json);

        return self::execute($request);
    }

    private static function parameters($request, array $parameters = [], bool $json = true)
    {
        if (0 === count($parameters)) {
            return;
        }
        if (true === $json) {
            curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($parameters));
        } else {
            curl_setopt($request, CURLOPT_POSTFIELDS, http_build_query($parameters));
        }
    }

    private static function request($url, array $headers = [], string $content_type = 'application/json; charset=utf-8')
    {
        $request   = curl_init();
        $headers[] = 'Content-Type: ' . $content_type;
        curl_setopt($request, CURLOPT_URL, $url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($request, CURLINFO_HEADER_OUT, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, true);

        return $request;
    }

    private static function execute($request)
    {
        $body = curl_exec($request);
        $info = curl_getinfo($request);
        curl_close($request);

        return new Response((string) $body, $info['http_code'] ?? 500, []);
    }
}
