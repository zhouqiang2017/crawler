<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\PassportToken;
use App\Traits\ApiResponse;

class IndexController extends Controller
{
    use PassportToken, ApiResponse;

    public function index(User $user)
    {
        $authCode = $this->getBearerTokenByUser($user, 1, false);

        return $this->success($authCode);
    }


    public function show(User $user)
    {
        return $this->success($user);
    }
}
