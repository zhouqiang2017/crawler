<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\CaptchaRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\SmsRequest;
use App\Http\Requests\Api\VerifyCaptchaRequest;
use Facades\App\Services\CaptchaService;
use Facades\App\Services\SmsService;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class HelperController extends Controller
{

    /*
     * 发送短息验证码
     * */
    public function getSmsCode(RegisterRequest $request)
    {
        $phone = $request->phone;
        $response = SmsService::send($phone);
        return $this->success($response);
    }


    /*
     * 验证码 验证
     * */
    public function verifySmsCode(RegisterRequest $request)
    {

        $verificationKey = $request->verification_key;

        $code = $request->code;

        $response = SmsService::verify($verificationKey, $code);

        if (!is_array($response)) return $this->failed($response);
        // 验证通过执行下面的操作  短息验证码验通过 并返回数据 [ "phone" => "17358630294""code" => "2323"]
    }

    /*
     * 获取图片验证码
     * */
    public function getCaptcha(CaptchaRequest $request)
    {

        list($width, $height) = $request->size ?? [150, 40];

        $response = CaptchaService::getCaptcha($request->phone, $width, $height);

        return $this->success($response);

    }

    /*
     * 验证图片验证码
     * */
    public function verifycaptcha(VerifyCaptchaRequest $request)
    {

    }

}
