<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\CaptchaRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\SmsRequest;
use App\Http\Requests\Api\VerifyCaptchaRequest;
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
     * 图片验证码
     * */
    public function captchas(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-' . Str::random(15);
        $phone = $request->phone;
        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(2);
        Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);
        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];

        return $this->success($result);
    }

    /*
     * 验证图片验证码
     * */
    public function verifycaptcha(VerifyCaptchaRequest $request)
    {
        $captchaData = Cache::get($request->captcha_key);

        if (!$captchaData) return '图片验证码已失效';

        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            // 验证错误就清除缓存
            Cache::forget($request->captcha_key);
            return '验证码错误';
        }

        Cache::forget($request->captcha_key);


    }

}
