<?php
/**
 * Created by AlicFeng at 2019-06-08 21:09
 */

namespace Tests\Unit;

use AlicFeng\Helper\Crypt\HelperCryptService;
use Tests\TestCase;

class CryptTest extends TestCase
{
    public function testCrypt()
    {
        $content = time() . 'testing';
        $this->assertEquals($content, HelperCryptService::decrypt(HelperCryptService::encrypt($content)));
    }
}
