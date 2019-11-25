<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Translate;

interface TranslationIterface
{
    /**
     * @function    translate
     * @description translate
     *
     * @param mixed|null $key translate key
     *
     * @return mixed
     *
     * @author      AlicFeng
     * @datatime    19-11-25 下午9:17
     */
    public static function translate($key = null);
}
