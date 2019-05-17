<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException as SmsException;

/**
 * Class SmsService
 *
 * @package \App\Services
 */
class SmsService
{

    /*
     * 发送验证码
     * @param phone 手机号码
     * */
    public function send($phone)
    {
        $easySms = app('easysms');

        if (!app()->environment('production')) {
            $code = '2323';
        } else {
            // 生成4位随机数，左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            try {
                $easySms->send($phone, [
                    'content' => "【众聚协同】{$code}为您的登录验证码，请于5分钟内填写。如非本人操作，请忽略本短信。"
                ]);
            } catch (SmsException $exception) {
                $message = $exception->getException('qcloud')->getMessage();
                return $this->response->errorInternal($message ?: '短信发送异常');
            }
        }

        $key = 'verificationCode_' . Str::random(15);
        // 缓存验证码 10分钟过期。
        $expiredAt = now()->addMinutes(10);

        Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return [
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ];
    }


    /*
     *  验证验证码
     * */

    public function verify($verificationKey, $code)
    {

        $verifyData = Cache::get($verificationKey);

        if (!$verifyData) return '验证码失效';


        if (!hash_equals($verifyData['code'], $code)) return '验证码错误';


        Cache::forget($verificationKey);

        return $verifyData;

    }
}
