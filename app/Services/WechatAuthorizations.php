<?php

namespace App\Services;

/**
 * Class WechatAuthorizations
 *
 * @package \App\Services
 */
class WechatAuthorizations
{
    public $app;

    public function __construct()
    {
        $this->app = \EasyWeChat::miniProgram();
    }


    /*
     * 登录授权
     *
     * */
    public function loginAuthorization($code)
    {

        return $this->app->auth->session($code);

    }
}
