<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
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
