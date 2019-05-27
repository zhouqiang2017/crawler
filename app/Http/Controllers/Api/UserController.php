<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

use App\Http\Requests\Api\UserStoreRequest;
use Facades\App\Services\WechatAuthorizations;

class UserController extends Controller {
    public function store(UserStoreRequest $request)
    {
        $code = $request->code;
        $userInfo = $request->userInfo;
        $authSession = WechatAuthorizations::loginAuthorization($code);
        $userData = [
            'open_id' => $authSession['openid'],
            'session_key' => $authSession['session_key'],
            'union_id' => $authSession['union_id'] ?? '',
            'nick_name' => $userInfo['nickName'],
            'gender' => $userInfo['gender'],
            'language' => $userInfo['language'],
            'city' => $userInfo['city'],
            'province' => $userInfo['province'],
            'country' => $userInfo['country'],
            'avatar' => $userInfo['avatarUrl']
        ];

        $user = User::updateOrCreate(['open_id' => $userData['open_id']], $userData);

        $oauth = $this->getBearerTokenByUser($user, 1, false);

        $user->oauth = $oauth;

        return $this->success(compact('user'));

    }
}
