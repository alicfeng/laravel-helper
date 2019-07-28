<?php
/**
 * Created by AlicFeng at 2019-07-28 11:54
 */

namespace AlicFeng\Helper\Helper;


class DateTimeHelper
{
    /**
     * @function    msectime
     * @description return current Unix timestamp with microseconds
     * @return integer
     */
    public static function msectime()
    {
        return (int)(microtime(true) * 1000);
    }

    public function __call($name, $arguments)
    {
        return call_user_func([self::class, $name], $arguments);
    }
}
