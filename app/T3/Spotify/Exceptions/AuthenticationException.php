<?php

namespace App\T3\Spotify\Exceptions;

class AuthenticationException extends \Exception
{
    protected $code = 401;
    protected $message = 'Your access token is invalid or has expired';
}
