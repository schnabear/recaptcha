<?php

use Oz\Recaptcha\Captcha;

class CaptchaTest extends PHPUnit_Framework_TestCase
{
    public function testVerifyReturnsFalseIfEmptyKeys()
    {
        $captcha = new Captcha('', '');
        $this->assertFalse($captcha->verify(''));
    }

    public function testVerifyReturnsFalseIfInvalidKeys()
    {
        $captcha = new Captcha('INVALID', 'INVALID');
        $this->assertFalse($captcha->verify('INVALID'));
    }
}
