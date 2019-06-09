<?php

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
