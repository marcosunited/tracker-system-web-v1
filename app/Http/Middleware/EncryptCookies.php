<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'XDEBUG_SESSION'
    ];
}
