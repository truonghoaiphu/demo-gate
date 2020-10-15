<?php

namespace Katniss\Everdeen\Http\Middleware;

use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Katniss\Http\Middleware\EncryptCookies as BaseEncryptCookies;

class EncryptCookies extends BaseEncryptCookies
{
    public function __construct(EncrypterContract $encrypter)
    {
        parent::__construct($encrypter);

        $this->except = [
            _k('home_cookie_name'),
            _k('home_cookie_settings_name'),
        ];
    }
}
