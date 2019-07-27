<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Helper;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Log;
use Spatie\ArrayToXml\ArrayToXml;

class ResponseHelper
{
    // package structure format supported including json and xml
    const FORMAT_JSON = 'json';
    const FORMAT_XML  = 'xml';

    // about http message | status_code( default 200 ) and header message
    protected $status_code = 200;
    protected $headers     = [];

    // package value [code,message,data]
    protected $code    = null;
    protected $message = null;
    protected $data    = null;

    // plugin setting including log flag
    protected $log = true;

    /**
     * @functionName set http header
     * @description  setting http header
     *
     * @param array $headers http header message
     *
     * @return ResponseHelper $this
     */
    private function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @functionName set data
     * @description  setting data of package dom
     *
     * @param mixed $data data of package
     *
     * @return $this
     */
    private function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @functionName set codeEnum
     * @description  setting code and message of package dom
     *
     * @param array $codeEnum code and message
     *
     * @return $this
     */
    private function setCodeEnum(array $codeEnum)
    {
        $this->code    = $codeEnum[0];
        $this->message = end($codeEnum);

        return $this;
    }

    /**
     * @functionName set statusCode
     * @description  setting http status code
     *
     * @param mixed $status_code http status code
     *
     * @return $this
     */
    private function setStatusCode(int $status_code)
    {
        $this->status_code = $status_code;

        return $this;
    }

    /**
     * @functionName set log flag
     * @description  set log flag for log::notice
     *
     * @param mixed $flag log flag
     *
     * @return $this
     */
    private function setLogFlag(bool $flag)
    {
        $this->log = $flag;

        return $this;
    }

    /**
     * @functionName print log
     * @description  print response package log
     *
     * @param string $package package message
     */
    private function printLog($package)
    {
        Log::notice($package);
    }

    /**
     * @functionName   generate unified structure package
     * @description    generate unified structure package
     *
     * @param string $format structure format
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    private function generate(string $format = self::FORMAT_JSON)
    {
        $structure = config('helper.package.structure', []);

        $package = [
            Arr::get($structure, 'code', 'code')       => $this->code,
            Arr::get($structure, 'message', 'message') => $this->message,
            Arr::get($structure, 'data', 'data')       => $this->data,
        ];

        if ($this->data instanceof Arrayable) {
            $package[Arr::get($structure, 'data', 'data')] = $this->data->toArray();
        }
        $package = call_user_func([self::class, $format], $package);

        if ($this->log) {
            $this->printLog($package);
        }

        return response($package, $this->status_code, $this->headers);
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

    /**
     * @functionName   Service Handler Result
     * @description    在此统一构建业务处理的结果报文结构体，
     * 每一个需要需要返回结果的Service尽量继承BaseService，
     * Developers care about the return value
     *
     * @param array  $codeEnum    Code Array | [ code, message ]
     * @param mixed  $data        data
     * @param bool   $log         printer log
     * @param string $format      structure format
     * @param int    $status_code http status code | default is 200
     * @param array  $headers     https headers | default []
     *
     * @return string response message
     */
    public function result(
        array $codeEnum, $data = '',
        bool $log = true, $format = self::FORMAT_JSON,
        int $status_code = 200, array $headers = []
    ) {
        return $this
            ->setStatusCode($status_code)
            ->setHeaders($headers)
            ->setCodeEnum($codeEnum)
            ->setData($data)
            ->setLogFlag($log)
            ->generate($format);
    }

    /**
     * @functionName noContent
     * @description  response nothing content
     *
     * @param int   $status_code http code | default 204
     * @param array $headers     http headers message
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function noContent($status_code = 204, $headers = [])
    {
        return response('', $status_code, $headers);
    }
}
