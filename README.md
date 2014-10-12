## reCAPTCHA v2 PHP Library

[![Build Status](https://travis-ci.org/schnabear/recaptcha.svg?branch=master)](https://travis-ci.org/schnabear/recaptcha)
[![WTFPL](http://www.wtfpl.net/wp-content/uploads/2012/12/wtfpl-badge-2.png)](http://www.wtfpl.net)

A reCAPTCHA PHP library using v2 API

## Sample Usage

```php
<?php

use Oz\Recaptcha;

$sitekey = 'YOUR_PUBLIC_KEY';
$secret = 'YOUR_PRIVATE_KEY';

$recaptcha = new Recaptcha($sitekey, $secret);

$is_verified = false;
if ( isset($_POST[Recaptcha::RESPONSE_FIELD_KEY]) )
{
    $is_verified = $recaptcha->verify($_POST[Recaptcha::RESPONSE_FIELD_KEY]);
}
```

```php
<!DOCTYPE html>
<html>
<head>
    <title>ReCAPTCHA</title>
    <script src="<?php echo Recaptcha::SCRIPT_URL ?>"></script>
</head>
<body>
    <p>Test Result: <?php echo $is_verified ? '&#12295;' : '&#10005;' ?></p>
    <form method="post" action="#">
        <?php echo $recaptcha->getHTML() . PHP_EOL ?>
        <input type="submit" value="TEST" />
    </form>
</body>
</html>
```
