<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

abstract class BaseController extends Controller
{
    protected int $cacheExpiration;

    public function __construct()
    {
        $this->cacheExpiration = (int) Config::get('cache.cache_expiration_time', 10);
    }
}
