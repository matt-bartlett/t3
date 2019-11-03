<?php

namespace App\T3\Spotify\Transformers;

use stdClass;

interface TransformerInterface
{
    /**
     * Transform the response from Spotify's API into a desired structure
     *
     * @param stdClass $object
     * @return array
     */
    public function transform(stdClass $object) : array;
}
