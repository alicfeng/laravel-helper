<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace Tests\Feature;

use AlicFeng\Helper\Helper\ResponseHelper;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testFormatJsonResponse()
    {
        $code      = 1000;
        $message   = 'success';
        $data      = ['name' => 'alicfeng'];
        $helper    = new ResponseHelper();
        $json      = $helper->result([$code, $message], $data);
        $structure = config('helper.package.structure');
        $this->assertEquals($json, response(json_encode([$structure['code'] => $code, $structure['message'] => $message, $structure['data'] => $data], JSON_UNESCAPED_UNICODE)));
    }
}
