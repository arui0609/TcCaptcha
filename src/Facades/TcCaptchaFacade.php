<?php
/**
 *
 * User: songrui
 * Date: 2022/11/25
 * Email: <sr_yes@foxmail.com>
 */
namespace Arui\TcCaptcha\Facades;

use Illuminate\Support\Facades\Facade;

class TcCaptchaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TcCaptcha';
    }
}
