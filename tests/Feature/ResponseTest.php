<?php
/**
 * Created by AlicFeng at 2019-06-09 02:13
 */

namespace Tests\Feature;

use AlicFeng\Helper\Helper\ResponseHelper;
use Tests\TestCase;

class ResponseTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testFormatJson()
    {
        $code      = 1000;
        $message   = 'success';
        $data      = ['name' => 'alicfeng'];
        $helper    = new ResponseHelper();
        $json      = $helper
            ->generate($code, $message, $data)
            ->getContent();
        $structure = config('helper.package.structure');
        $this->assertEquals($json, json_encode([$structure['code'] => $code, $structure['message'] => $message, $structure['data'] => $data], JSON_UNESCAPED_UNICODE));
    }

}
