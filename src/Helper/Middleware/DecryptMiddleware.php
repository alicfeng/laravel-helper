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
use Log;

class DecryptMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!call_user_func([config('helper.package.crypt.instance'), 'decrypt'], $request->getContent())) {
            Log::debug('decrypting by decrypt middleware encrypt error value:' . $request->getContent());

            return Response('Invalid Param', '403');
        }
        Log::debug('decrypting by decrypt middleware encrypt success value:' . $request->getContent());

        return $next($request);
    }
}
