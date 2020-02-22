<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Service;

use Log;

class CryptHelperService extends BaseHelperService
{
    const SUCCESS = [1000, 'success'];
    const FAILURE = [2000, 'failure'];

    public function decrypt(string $message)
    {
        try {
            $result = call_user_func([config('helper.package.crypt.instance'), 'decrypt'], $message);
            if ($result) {
                return $this->rspHelper->result(self::SUCCESS, json_decode($result, JSON_UNESCAPED_UNICODE), 200, []);
            }
        } catch (\Exception $exception) {
            Log::error($exception);
        }

        return $this->rspHelper->result(self::FAILURE, '', 200, []);
    }
}
