<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Translate;

class Translation implements TranslationIterface
{
    /**
     * Translate the given message.
     *
     * @param string $key
     *
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    public static function translate($key = null)
    {
        return trans($key, [], 'zh');
    }
}
