<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Controller;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseHelperController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @description Safely Filter Parameter Value
     *
     * @param mixed $parameter value
     *
     * @return mixed
     */
    public function safeFilter($parameter)
    {
        if (is_array($parameter)) {
            foreach ($parameter as $key => $value) {
                $parameter[$key] = $this->safeFilter($value);
            }
        }
        if ($parameter && is_string($parameter)) {
            //防止SQL注入
            $parameter = addslashes(
            //将字符内容转化为html实体
                htmlspecialchars(
                //过滤html标签
                    strip_tags(
                    //清理空格
                        trim($parameter)
                    )
                )
            );
        }

        return $parameter;
    }
}
