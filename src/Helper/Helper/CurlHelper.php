<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Helper;

use AlicFeng\Helper\Code\HttpCode;
use AlicFeng\Helper\Code\HttpMethod;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class CurlHelper
{
    /**
     * @function    post request
     * @description post request
     * @param string $url
     * @param array  $parameters
     * @param array  $headers
     * @param bool   $json
     * @return Response|ResponseFactory
     */
    public static function post(string $url, array $parameters = [], array $headers = [], bool $json = true)
    {
        return self::request(HttpMethod::POST, $url, $parameters, $headers, $json);
    }

    /**
     * @function    delete request
     * @description delete request
     * @param string $url
     * @param array  $parameters
     * @param array  $headers
     * @param bool   $json
     * @return Response|ResponseFactory
     */
    public static function delete(string $url, array $parameters = [], array $headers = [], bool $json = true)
    {
        return self::request(HttpMethod::DELETE, $url, $parameters, $headers, $json);
    }

    /**
     * @function    get request
     * @description get request
     * @param string $url
     * @param array  $parameters
     * @param array  $headers
     * @return Response|ResponseFactory
     */
    public static function get(string $url, array $parameters = [], array $headers = [])
    {
        if ($query = http_build_query($parameters)) {
            $url .= '?' . $query;
        }

        return self::request(HttpMethod::GET, $url, $headers);
    }

    /**
     * @function    request common
     * @description request common
     * @param string $method
     * @param array  $parameters
     * @param array  $headers
     * @param bool   $json
     * @return Response|ResponseFactory
     */
    public static function request(string $method, $url, array $parameters = [], array $headers = [], bool $json = true)
    {
        $request = self::prepare($url, $headers);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, $method);
        self::parameters($request, $parameters, $json);

        $body        = curl_exec($request);
        $info        = curl_getinfo($request);
        $header_size = curl_getinfo($request, CURLINFO_HEADER_SIZE);
        $header      = substr($request, 0, $header_size);
        curl_close($request);

        return response((string) $body, $info['http_code'] ?? HttpCode::HTTP_INTERNAL_SERVER_ERROR, json_decode($header, true) ?? []);
    }

    /**
     * @function    parameters handler
     * @description parameters handler
     * @param false|resource $request
     * @param array          $parameters
     * @param bool           $json
     */
    private static function parameters($request, array $parameters = [], bool $json = true): void
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

    /**
     * @function    prepare
     * @description prepare curl
     * @param string $url
     * @param array  $headers
     * @return false|resource
     */
    private static function prepare(string $url, array $headers = [])
    {
        $request = curl_init();
        $headers = array_merge(['Content-Type: ' . 'application/json; charset=utf-8'], $headers);
        curl_setopt($request, CURLOPT_URL, $url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($request, CURLINFO_HEADER_OUT, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, true);

        return $request;
    }
}
