<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use DB;
use function response;

class checkAppVersionController extends Controller
{
    public function mobile()
    {

       return response(['mobile_version' => env('APP_VERSION_MOBILE')],200);
    }
}
