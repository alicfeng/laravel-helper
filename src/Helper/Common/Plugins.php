<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Common;

/**
 * Plugin Env Reader and Setting
 * Class Plugins.
 */
class Plugins
{
    /**
     * get this plugin debug model.
     *
     * @return bool
     */
    public static function debug()
    {
        return config('helper.debug', false);
    }
}
