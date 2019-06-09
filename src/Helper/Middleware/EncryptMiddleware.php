<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

/**
 * encrypt package middleware
 * Class EncryptMiddleware.
 */
class EncryptMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($response instanceof Response) {
            Log::debug('encrypting by encrypt middleware');
            $response->setContent(call_user_func([config('helper.package.crypt.instance'), 'encrypt'], $response->getContent()));
        }

        return $response;
    }
}
