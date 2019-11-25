<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Helper;

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
     * helper debug.
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * helper transform_class.
     *
     * @var null
     */
    protected $transform_class = null;

    public function __construct()
    {
        $this->log       = config('helper.package.log.log', true);
        $this->log_level = config('helper.package.log.level', 'notice');
        $this->format    = config('helper.package.format', 'json');
        $this->debug     = config('helper.debug', false);
    }

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
        if (true === config('helper.translate.model')) {
            $this->message = $this->translate($this->message);
        }

        return $this;
    }

    /**
     * @function    translate
     * @description translate
     *
     * @param mixed $message translate
     *
     * @return mixed
     *
     * @author      AlicFeng
     * @datatime    19-11-25 下午9:15
     */
    private function translate($message)
    {
        return call_user_func([config('helper.translate.instance'), 'translate'], $message);
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
        // package.data transform
        if (null !== $this->transform_class) {
            $this->data = app($this->transform_class)->transfrom($this->data);
        }

        // build package structure
        $structure = config('helper.package.structure', []);
        $package   = [
            Arr::get($structure, 'code', 'code')       => $this->code,
            Arr::get($structure, 'message', 'message') => $this->message,
            Arr::get($structure, 'data', 'data')       => $this->data,
        ];

        // debug meta message
        if (true === $this->debug) {
            $package['debug'] = [
                'runtime' => DateTimeHelper::msectime() - (int) (LARAVEL_START * 1000) . ' ms',
                'length'  => mb_strlen(call_user_func([self::class, $this->format . 'Format'], $package)) . ' byte',
            ];
        }

        // translate package | json or xml
        $this->response = call_user_func([self::class, $this->format . 'Format'], $package);

        // unset useless vars
        unset($package, $structure);

        // response to print log
        if (true === $this->log) {
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
        $message = json_decode(json_encode($message), true);

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
            $this->log_level = config('helper.package.log.level', 'notice');
        }

        return $this;
    }

    /**
     * @function    transform
     * @description transform
     *
     * @param string $transform_class
     *
     * @return self $this
     *
     * @author      alicfeng
     */
    public function transform(string $transform_class)
    {
        $this->transform_class = $transform_class;

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
