<?php

namespace App\T3\Services;

use Illuminate\Http\Request;

interface Service
{
    /**
     * Callable method to invoke the service.
     *
     * @param Illuminate\Http\Request $request
     */
    public function make(Request $request);
}
