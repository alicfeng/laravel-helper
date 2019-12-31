<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace Tests\Unit;

use AlicFeng\Helper\Controller\BaseHelperController;
use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    public function testSafeFilter()
    {
        $baseController = new BaseHelperController();
        $param          = "<div><script>alert('Hello')</script></div> ";
        $this->assertEquals("alert(\'Hello\')", $baseController->safeFilter($param));
    }
}
