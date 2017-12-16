<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Return a fixture from the Fixtures directory
     *
     * @param string $path
     * @return void
     */
    protected function getFixture($path)
    {
        return unserialize(file_get_contents(__DIR__ . '/Unit/Fixtures/' . $path));
    }
}
