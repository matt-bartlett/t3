<?php

namespace Tests\Unit\Spotify\Transformers;

use stdClass;
use Exception;
use ReflectionClass;
use Tests\TestCase;
use App\T3\Spotify\Transformers\Transformer;

class TransformerTest extends TestCase
{
    public $reflected;
    public $transformer;

    /**
     * @return void
     */
    public function setUp()
    {
        // Reflection class for testing protected methods
        $transformer = new ReflectionClass(Transformer::class);
        $this->reflected = $transformer->getMethod('get');
        $this->reflected->setAccessible(true);

        // Instantiate Transformer class
        $this->transformer = new Transformer;

        parent::setUp();
    }

    /**
     * @return void
     */
    public function test_getting_invalid_property_throws_exception()
    {
        $this->expectException(Exception::class);

        $object = $this->getUserObject();

        $this->reflected->invokeArgs($this->transformer, array($object, 'website'));
    }

    /**
     * @return void
     */
    public function test_getting_a_property_from_an_object()
    {
        $object = $this->getUserObject();

        $result = $this->reflected->invokeArgs($this->transformer, array($object, 'firstname'));

        $this->assertEquals('Matt', $result);
    }

    /**
     * @return void
     */
    public function test_getting_a_property_from_an_array()
    {
        $object = [$this->getUserObject()];

        $result = $this->reflected->invokeArgs($this->transformer, array($object, 'firstname'));

        $this->assertEquals('Matt', $result);
    }

    /**
     * Return an object of user data
     *
     * @return stdClass
     */
    private function getUserObject()
    {
        $object = new stdClass;
        $object->firstname = 'Matt';
        $object->surname = 'Bartlett';
        $object->email = 'mattbartlett@gmail.com';

        return $object;
    }
}
