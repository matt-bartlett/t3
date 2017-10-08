<?php

namespace App\T3\Spotify\Transformers;

use Exception;

class Transformer
{
    /**
     * Helper method to check for the existance of the desired property
     * from an object. Returns the value if found, or null.
     * Throws an exception if the property doesn't exist.
     *
     * @param stdClass|array $object
     * @param string $property
     * @return string
     * @throws Exception
     */
    protected function get($object, $property)
    {
        if (is_array($object)) {
            $object = $object[0];
        }

        if (property_exists($object, $property)) {
            if (!empty($object->{$property})) {
                return $object->{$property};
            }

            return null;
        }

        throw new Exception("Failed to find that property from the object");
    }
}
