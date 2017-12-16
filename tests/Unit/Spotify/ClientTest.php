<?php

namespace Tests\Unit\Spotify;

use Tests\TestCase;
use App\T3\Spotify\API;
use App\T3\Spotify\Client;
use App\T3\Spotify\Auth\Authenticator;

class ClientTest extends TestCase
{
    public $client;
    public $apiMock;
    public $authenticatorMock;

    /**
     * @return void
     */
    public function setUp()
    {
        // API Mock
        $this->apiMock = $this->createMock(API::class);

        // Authenticator Mock
        $this->authenticatorMock = $this->getMockBuilder(Authenticator::class)
            ->disableOriginalConstructor()
            ->setMethods(array('getAccessToken'))
            ->getMock();

        $this->client = new Client($this->apiMock, $this->authenticatorMock);

        parent::setUp();
    }

    /**
     * @return void
     */
    public function test_api_getter()
    {
        $this->assertInstanceOf(API::class, $this->client->getApi());
    }
}
