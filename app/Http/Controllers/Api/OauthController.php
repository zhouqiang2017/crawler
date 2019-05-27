<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;

class OauthController extends Controller
{
    /*
     *  为用户生成token
     *  @param $user
     *  return Json
     * */
    public function index(User $user)
    {

        $oauth = $this->getBearerTokenByUser($user, 1, false);

        return $this->success($oauth);

    }
}
