<?php

namespace App\Services;

use App\Http\Requests\Api\CaptchaRequest;
use App\Http\Requests\Api\VerifyCaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


/**
 * Class SmsService
 *
 * @package \App\Services
 */
class CaptchaService
{

    protected $captchaBuilder;

    public function __construct(CaptchaBuilder $captchaBuilder)
    {
        $this->captchaBuilder = $captchaBuilder;
    }
    
    /*
     * 获取 图片 验证码
     * @param phone 手机号码
     * */
    public function getCaptcha($phone, $width, $height)
    {
        $key = 'captcha-' . Str::random(15);
        $captcha = $this->captchaBuilder->build($width, $height);
        $expiredAt = now()->addMinutes(5);
        Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);
        return [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];
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

        return $captchaData;

    }
}
