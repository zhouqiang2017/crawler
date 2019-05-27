<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Traits\PassportToken;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    use PassportToken, ApiResponse;
}
