<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Service;

use AlicFeng\Helper\Helper\ResponseHelper as RspHelper;

/**
 * Service Base Class
 * All Service Class Extends This For Unit Result
 * Class BaseService.
 */
class BaseHelperService
{
    private $responseHelper;

    public function __construct(RspHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    /**
     * @functionName   Service Handler Result
     * @description    在此统一构建业务处理的结果报文结构体，
     * 每一个需要需要返回结果的Service尽量继承BaseService，
     * 开发者关心返回值即可
     *
     * @see            使用传参 result([100,'success'],['name'=>'alicfeng','age'=>23]) =>
     * @see            报文响应 {"code":100,"message":"success","data":{"name":"alicfeng","age":23}}
     *
     * @param array $codeEnum Code Array | [ code, message ]
     * @param mixed $data     data
     * @param bool  $log      printer log
     * @param int   $format   structure format
     * @param int   $status   http status code | default is 200
     * @param array $headers  https headers | default []
     *
     * @return string 字符串的响应报文信息
     */
    public function result(array $codeEnum, $data = '', bool $log = true, $format = RspHelper::FORMAT_JSON, int $status = 200, array $headers = [])
    {
        return $this->responseHelper->generate($codeEnum[0], $codeEnum[1], $data, $log, $format, $status, $headers);
    }
}
