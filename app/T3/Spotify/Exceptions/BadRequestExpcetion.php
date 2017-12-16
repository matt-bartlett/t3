<?php

namespace App\T3\Spotify\Exceptions;

class BadRequestException extends \Exception
{
    protected $code = 400;
    protected $message = 'Your request is invalid or has missing paramters';
}
