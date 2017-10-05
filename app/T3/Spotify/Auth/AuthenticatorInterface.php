<?php

namespace App\T3\Spotify\Auth;

interface AuthenticatorInterface
{
    public function getAccessToken();
}
