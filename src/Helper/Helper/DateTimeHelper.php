<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Helper;

class DateTimeHelper
{
    /**
     * @function    msectime
     * @description return current Unix timestamp with microseconds
     *
     * @return int
     */
    public static function msectime()
    {
        return (int) (microtime(true) * 1000);
    }

    public function __call($name, $arguments)
    {
        return call_user_func([self::class, $name], $arguments);
    }
}
