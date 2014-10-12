<?php

use Oz\Recaptcha;

class RecaptchaTest extends PHPUnit_Framework_TestCase
{
    public function testVerifyReturnsFalseIfEmptyKeys()
    {
        $recaptcha = new Recaptcha('', '');
        $this->assertFalse($recaptcha->verify(''));
    }

    public function testVerifyReturnsFalseIfInvalidKeys()
    {
        $recaptcha = new Recaptcha('INVALID', 'INVALID');
        $this->assertFalse($recaptcha->verify('INVALID'));
    }
}
