<h1 align="center">Tencent Captcha Sdk</h1>

A Simple SDK for Tencent Cloud Captcha

## Installation

Package is available on Packagist, you can install it using Composer.

> composer require arui/tc-captcha

### Dependencies

- PHP 7.3+
- OpenSSL Extension
- Laravel 6+

### Parameter setting
>   php artisan vendor publish  --provider="Arui\TcCaptcha\TcCaptchaProvider"

.env

``` 
QQ_CAPTCHA_SECRET_ID=
QQ_CAPTCHA_SECRET_KEY=
QQ_CAPTCHA_SECRET_APPID=
QQ_CAPTCHA_SECRET_APPKEY=
```


