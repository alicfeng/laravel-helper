<?php
/**
 * Created by PhpStorm.
 * User: fsliu
 * Date: 2020/6/16
 * Time: 下午4:17
 */

namespace AlicFeng\Helper\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;

class DecryptMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!call_user_func([config('helper.package.crypt.instance'), 'decrypt'], $request->getContent())){
            Log::debug('decrypting by decrypt middleware encrypt error value:'.$request->getContent());
            return Response('Invalid Param', '403');
        }
        Log::debug('decrypting by decrypt middleware encrypt success value:'.$request->getContent());
        return $next($request);

    }
}