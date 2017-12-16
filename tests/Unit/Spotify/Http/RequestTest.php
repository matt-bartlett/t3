<?php

namespace Tests\Unit\Spotify\Http;

use stdClass;
use Tests\TestCase;
use GuzzleHttp\Client;
use App\T3\Spotify\Http\Request;
use App\T3\Spotify\Http\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class RequestTest extends TestCase
{
    public $request;
    public $responseMock;
    public $guzzleClientMock;
    public $guzzleResponseMock;

    /**
     * @return void
     */
    public function setUp()
    {
        // Response Mock
        $this->responseMock = $this->getMockBuilder(Response::class)
            ->setMethods(array('parse'))
            ->getMock();

        // Guzzle Response Mock
        $this->guzzleResponseMock = $this->getMockBuilder(GuzzleResponse::class)->getMock();

        // Guzzle Client Mock
        $this->guzzleClientMock = $this->getMockBuilder(Client::class)
            ->setMethods(array('request'))
            ->getMock();

        // Instantiate Request class
        $this->request = new Request($this->responseMock, $this->guzzleClientMock);

        parent::setUp();
    }

    /**
     * @return void
     */
    public function test_request_is_successful()
    {
        $expected = new stdClass;
        $expected->property = 'Test';

        $this->guzzleClientMock->expects($this->once())
            ->method('request')
            ->willReturn($this->guzzleResponseMock);

        $this->responseMock->expects($this->once())
            ->method('parse')
            ->willReturn($expected);

        $response = $this->request->send(
            'https://test.api.com', 'GET', ['foo' => 'bar'], ['foo' => 'bar']
        );

        $this->assertEquals($response, $expected);
    }
}
