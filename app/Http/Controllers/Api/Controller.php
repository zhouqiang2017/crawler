<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Traits\ApiResponse;
use App\Traits\PassportToken;

class Controller extends BaseController
{
    use PassportToken, ApiResponse;
}
