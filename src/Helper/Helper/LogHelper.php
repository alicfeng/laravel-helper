<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Helper;

use DB;
use Exception;
use Illuminate\Support\Facades\Log;

class LogHelper
{
    /**
     * @function    异常日志信息记录
     * @description 异常日志信息记录
     * @param Exception $exception
     * @param string    $event
     * @author      AlicFeng
     */
    public static function exception(Exception $exception, $event = '')
    {
        Log::error($event);
        Log::error('exception message : ' . $exception->getMessage());
        Log::error('exception code    : ' . $exception->getCode());
        Log::error('exception file    : ' . $exception->getFile());
        Log::error('exception line    : ' . $exception->getLine());
    }

    /**
     * @function    数据库事件监听
     * @description 用于MySQL调用分析
     * @author      AlicFeng
     */
    public static function databaseListener()
    {
        if (true === config('app.debug')) {
            return;
        }
        DB::listen(function ($query) {
            Log::debug('databaseListener', [$query->sql, $query->bindings, $query->time]);
        });
    }
}
