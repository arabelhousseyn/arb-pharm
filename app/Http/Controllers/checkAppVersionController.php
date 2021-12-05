<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class checkAppVersionController extends Controller
{
    public function mobile()
    {

       return response(['mobile_version' => env('APP_VERSION_MOBILE')],200);
    }
}
