<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Helper;

use Log;
use Spatie\ArrayToXml\ArrayToXml;

class ResponseHelper
{
    // package structure format supported including Json and Xml
    const FORMAT_JSON = 0;
    const FORMAT_XML  = 1;
    const FORMATS     = ['json', 'xml'];

    const ENCRYPT_DEFAULT = null;
    const ENCRYPT_ENABLE  = true;
    const ENCRYPT_DISABLE = false;

    /**
     * @functionName   Generate Unified Structure Package
     * @description    统一构建生成响应体
     *
     * @param mixed  $code    code
     * @param string $message message
     * @param mixed  $data    data
     * @param bool   $log     printer log
     * @param int    $format  structure format
     * @param int    $status  http status code | default is 200
     * @param array  $headers https headers | default []
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function generate($code, string $message, $data = '', bool $log = true, int $format = self::FORMAT_JSON, int $status = 200, array $headers = [])
    {
        $package = [
            config('helper.package.structure.code', 'code')       => $code,
            config('helper.package.structure.message', 'message') => $message,
            config('helper.package.structure.data', 'data')       => $data,
        ];
        $package = call_user_func([self::class, self::FORMATS[$format]], $package);
        (!$log) ?: Log::info($package);

        return response($package, $status, $headers);
    }

    /**
     * @functionName   array2json
     * @description    array to json format
     *
     * @param array $message
     *
     * @return string
     */
    private static function json(array $message)
    {
        return json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @functionName   array2xml
     * @description    array to xml format
     *
     * @param array $message
     *
     * @return string
     */
    private static function xml(array $message)
    {
        return ArrayToXml::convert($message, 'root');
    }
}
