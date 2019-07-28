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
    /**
     * package structure format supported including json and xml.
     */
    const FORMATS = ['json', 'xml'];

    /**
     * http status code.
     *
     * @var int
     */
    protected $status_code = 200;

    /**
     * http response headers.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * package structure code dom.
     *
     * @var null
     */
    protected $code = null;

    /**
     * package structure message dom.
     *
     * @var null
     */
    protected $message = null;

    /**
     * package structure data dom.
     *
     * @var null
     */
    protected $data = null;

    /**
     * package structure format
     * default json format.
     *
     * @var string
     */
    protected $format = 'json';

    /**
     * http response.
     *
     * @var string
     */
    private $response = '';

    // plugin setting including log flag
    /**
     * response log flag
     * if true that printer log message
     * by using laravel Log.
     *
     * @var bool
     */
    protected $log = true;

    /**
     * log level
     * setting by helper configuration file or log function
     * default notice level.
     *
     * @var string
     */
    protected $log_level = 'notice';

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
     * @function     set data
     * @description  setting package.data dom value
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
     * @function    setCodeEnum
     * @description setting package.code and package.message
     *
     * @param array $codeEnum [code,message]
     *
     * @return self $this
     */
    private function setCodeEnum(array $codeEnum)
    {
        $this->code    = $codeEnum[0];
        $this->message = end($codeEnum);

        return $this;
    }

    /**
     * @function    setting status code
     * @description setting http.status_code
     *
     * @param int $status_code
     *
     * @return $this
     */
    private function setStatusCode(int $status_code)
    {
        $this->status_code = $status_code;

        return $this;
    }

    /**
     * @function    generate the response
     * @description generate response package message
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    private function generate()
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

        $this->response = call_user_func([self::class, $this->format . 'Format'], $package);

        unset($package, $structure);

        if ($this->log) {
            call_user_func([Log::class, $this->log_level], $this->response);
        }

        return response($this->response, $this->status_code, $this->headers);
    }

    /**
     * @function    jsonFormat
     * @description generate the response to json string
     *
     * @param array $message
     *
     * @return false|string
     */
    private static function jsonFormat(array $message)
    {
        return json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @function    xmlFormat
     * @description generate the response to xml string
     *
     * @param array $message
     *
     * @return string
     */
    private static function xmlFormat(array $message)
    {
        return ArrayToXml::convert($message, 'root');
    }

    /**
     * @function    json
     * @description setting format to json
     *
     * @return $this
     */
    public function json()
    {
        $this->format = self::FORMATS[0];

        return $this;
    }

    /**
     * @function    xml
     * @description setting format to xml
     *
     * @return $this
     */
    public function xml()
    {
        $this->format = self::FORMATS[1];

        return $this;
    }

    /**
     * @function    log
     * @description setting log configuration
     *
     * @param bool $flag
     * @param null $level
     *
     * @return self $this
     */
    public function log(bool $flag, $level = null)
    {
        $this->log = $flag;

        if (null === $level) {
            $this->log_level = config('helper.package.log_level', 'notice');
        }

        return $this;
    }

    /**
     * @function    generate the response result
     * @description generate the response result
     *
     * @param array  $codeEnum    package[code,message]
     * @param string $data        package.data
     * @param int    $status_code http.status_code
     * @param array  $headers     http.headers
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function result(
        array $codeEnum, $data = '',
        int $status_code = 200, array $headers = []
    ) {
        return $this
            ->setStatusCode($status_code)
            ->setHeaders($headers)
            ->setCodeEnum($codeEnum)
            ->setData($data)
            ->generate();
    }

    /**
     * @function    response nothing
     * @description Respond with a no content response.
     *
     * @param int   $status_code
     * @param array $headers
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function noContent($status_code = 204, $headers = [])
    {
        return response('', $status_code, $headers);
    }
}
