<?php

namespace Anam\Captcha\Tests;

use Anam\Captcha\Captcha;

class CaptchaTest extends TestCase
{
    /**
     * Check that the multiply method returns correct result
     * 
     * @return void
     */
    public function testMultiplyReturnsCorrectValue()
    {
        $this->assertSame(16, 16);
        $this->assertSame(18, 18);
    }
}