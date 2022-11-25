<?php
/**
 *
 * User: songrui
 * Date: 2022/11/25
 * Email: <sr_yes@foxmail.com>
 */
namespace Arui\TcCaptcha;

use Illuminate\Support\ServiceProvider;

class TcCaptchaProvider extends ServiceProvider
{
    public function boot (){
        $this->publishes([
            __DIR__.'/config/qq_captcha.php' => config_path('qq_captcha.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('TcCaptcha',function ($app){
            return new TcCaptcha();
        });
    }
}
